<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Nets\Easy;
use Nets\Easy\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;

class User_payment extends MY_Controller
{
    protected $coupon_id;
    protected $client;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        check_info();
        $this->security->pay_in_cash();
        if (d_auth('is_discount') == TRUE) {
            $this->coupon_id = !empty(d_auth('coupon_id')) ? d_auth('coupon_id') : 0;
        } else {
            $this->coupon_id = 0;
        }
        $this->client = new Client();
    }

    public function iyzico($slug = '')
    {
        if (empty($slug)) {
            $this->session->set_flashdata('error', 'Restaurant not found');
            redirect(base_url());
            exit();
        }
        $postData = $this->input->get();
        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $this->session->set_flashdata('error', 'Token not found');
            redirect(base_url());
            exit();
        }



        $settings = $this->admin_m->get_restaurant_info_slug($slug);

        $iyzico = isJson($settings['iyzico_config']) ? json_decode($settings['iyzico_config']) : '';
        $baseUrl = isset($iyzico->is_iyzico_live) && $iyzico->is_iyzico_live == 1 ? 'https://api.iyzipay.com' : 'https://sandbox-api.iyzipay.com';

        // 8391bc05-6e4d-4080-8a9f-aff1648616ef

        $checkoutFormToken = $postData['token'];
        // Initialize Iyzico API Options
        $options = new \Iyzipay\Options();
        $options->setApiKey(isset($iyzico->iyzico_api_key) && !empty($iyzico->iyzico_api_key) ? $iyzico->iyzico_api_key : '');  // Use your sandbox key
        $options->setSecretKey(isset($iyzico->iyzico_secret_key) && !empty($iyzico->iyzico_secret_key) ? $iyzico->iyzico_secret_key : '');  // Use your sandbox secret
        $options->setBaseUrl($baseUrl);  // Sandbox URL for testing


        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);  // Locale for the request
        $request->setConversationId(uniqid());  // Use your conversation ID
        $request->setToken($checkoutFormToken);  // Token received from Iyzico

        // Retrieve checkout form result
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

        $payment = auth('payment');
        if ($checkoutForm->getStatus() === "success") {
            $paidAmount = $checkoutForm->getPaidPrice();
            $currency = $checkoutForm->getCurrency();
            $transactionId = $checkoutForm->getPaymentId();
            $data_info = array(
                'user_id' => $settings['user_id'],
                'order_id' => $payment['uid'],
                'shop_id' => $payment['shop_id'],
                'order_type' => $payment['order_type'],
                'price' => $paidAmount ?? $payment['total'],
                'currency_code' => $currency ?? restaurant($settings['id'])->currency_code,
                'status' => 'success',
                'txn_id' => $transactionId,
                'payment_by' => 'iyzico',
                'created_at' => d_time(),
            );

            $insert = $this->common_m->insert($data_info, 'order_payment_info');

            redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $data_info['txn_id']) . '&method=iyzico&amount=' . $data_info['price']);
        } else {
            redirect(base_url('user_payment/payment_cancel/' . $slug));
        }
    }


    public function iyzico_callback($slug = null)
    {
        $transaction_id = $this->input->get('transaction_id');


        $temp_file = APPPATH . 'temp/' . $transaction_id . '.tmp';

        if (file_exists($temp_file)) {
            $encoded_session_data = file_get_contents($temp_file);
            $session_data = json_decode(base64_decode($encoded_session_data), true);

            if (isset($session_data['csrf_token'])) {
                $this->security->csrf_set_cookie();
                $this->security->csrf_hash = $session_data['csrf_token'];
                unset($session_data['csrf_token']);
            }

            $this->session->set_userdata($session_data);

            unlink($temp_file);
        }

        $this->security->csrf_verify = false;
        $postData = $this->input->post(); // Retrieve the data sent from Iyzico

        if (isset($postData['token']) && empty($postData['token'])) {
            $this->session->set_flashdata('error', 'Token not found');
            redirect(base_url());
            exit();
        }

        if (empty($_GET['slug'])) {
            $this->session->set_flashdata('error', 'Restaurant not found');
            redirect(base_url());
            exit();
        }

        $slug = $_GET['slug'];

        redirect(base_url("user_payment/iyzico/{$slug}?token={$postData['token']}"));
    }


    public function myfatoorah($slug = '')
    {
        $get = $this->input->get();


        $payment_id = $get['paymentId'];
        $order_id = $get['Id'];

        if (empty($payment_id) && empty($slug)) {
            $this->session->set_flashdata('error', __('error_msg'));
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        $keyId   = $payment_id;
        $KeyType = 'paymentId';

        $payment = auth('payment');

        $settings = $this->admin_m->get_restaurant_info_slug($slug);
        $myfatoorah = isJson($settings['myfatoorah_config']) ? json_decode($settings['myfatoorah_config']) : '';

        $mfConfig = [
            'apiKey'      => isset($myfatoorah->myfatoorah_api_key) && !empty($myfatoorah->myfatoorah_api_key) ? $myfatoorah->myfatoorah_api_key : '',
            'vcCode' => isset($myfatoorah->vccode) && !empty($myfatoorah->vccode) ? $myfatoorah->vccode : 'KWT',
            'isTest'      => isset($myfatoorah->is_myfatoorah_live) && $myfatoorah->is_myfatoorah_live == 1 ? false : true,
        ];

        try {
            $mfObj = new MyFatoorahPaymentStatus($mfConfig);
            $result  = $mfObj->getPaymentStatus($keyId, $KeyType);
            if (isset($result->InvoiceStatus, $result->focusTransaction->PaymentId) && strtolower($result->InvoiceStatus) == "paid") {

                $data_info = array(
                    'user_id' => $settings['user_id'],
                    'order_id' => $payment['uid'],
                    'shop_id' => $payment['shop_id'],
                    'order_type' => $payment['order_type'],
                    'price' => $result->focusTransaction->PaidCurrencyValue ?? $payment['total'],
                    'currency_code' => isset($result->focusTransaction->Currency) ? $result->focusTransaction->Currency : restaurant($settings['id'])->currency_code,
                    'status' => 'success',
                    'txn_id' => $result->focusTransaction->TrackId,
                    'payment_by' => 'myfatoorah',
                    'created_at' => d_time(),
                );
                $insert = $this->common_m->insert($data_info, 'order_payment_info');

                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $data_info['txn_id']) . '&method=myfatoorah&amount=' . $data_info['price']);
            } else {
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            die;
        }
    }


    public function cashfree()
    {
        $orderId = $this->input->get('order_id', true);
        $slug = $this->input->get('slug', true);

        if (empty($orderId) && empty($slug)) {
            $this->session->set_flashdata('error', __('error_msg'));
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        $settings = $this->admin_m->get_restaurant_info_slug($slug);
        $cashfree = isJson($settings['cashfree_config']) ? json_decode($settings['cashfree_config']) : '';

        // Replace with your actual Cashfree API credentials
        $apiKey = isset($cashfree->cashfree_app_id) ? $cashfree->cashfree_app_id : '';
        $apiSecret = isset($cashfree->cashfree_secret_key) ? $cashfree->cashfree_secret_key : '';

        $payment = auth('payment');

        // Replace with the actual order ID
        $orderId = $_GET['order_id'];
        if (isset($cashfree->is_cashfree_live) && $cashfree->is_cashfree_live == 1):
            $url = "https://cashfree.com/pg/orders/{$orderId}";
        else:
            $url = "https://sandbox.cashfree.com/pg/orders/{$orderId}";
        endif;


        try {
            // Make a GET request to the URL
            $response = $this->client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-client-id' => $apiKey,
                    'x-client-secret' => $apiSecret,
                    'x-api-version' => '2022-09-01'  // Current API version as of my last update
                ]
            ]);

            // Get the response body as a string
            $body = $response->getBody()->getContents();

            // Parse the JSON response
            $result = json_decode($body);

            if (isset($result->order_status) && strtolower($result->order_status) == "paid") {
                $data_info = array(
                    'user_id' => $settings['user_id'],
                    'order_id' => $payment['uid'],
                    'shop_id' => $payment['shop_id'],
                    'order_type' => $payment['order_type'],
                    'price' => $result->order_amount ?? $payment['total'],
                    'currency_code' => isset($result->order_currency) ? $result->order_currency : restaurant($settings['id'])->currency_code,
                    'status' => 'success',
                    'txn_id' => $result->order_id,
                    'payment_by' => 'cashfree',
                    'created_at' => d_time(),
                );
                $insert = $this->common_m->insert($data_info, 'order_payment_info');
                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $data_info['txn_id']) . '&method=cashfree&amount=' . $data_info['price']);
            } else {
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            }
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    public function midtrans()
    {

        $order_id = $this->input->get('order_id');
        $slug = $this->input->get('slug');


        if (empty($orderId) && empty($slug)) {
            $this->session->set_flashdata('error', __('error_msg'));
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }


        $settings = $this->admin_m->get_restaurant_info_slug($slug);
        $midtrans = isJson($settings['midtrans_config']) ? json_decode($settings['midtrans_config']) : '';

        $payment = auth('payment');

        \Midtrans\Config::$serverKey = isset($midtrans->server_key) ? $midtrans->server_key : '';
        \Midtrans\Config::$isProduction = isset($midtrans->is_midtrans_live) && $midtrans->is_midtrans_live == 1 ? true : false; // Set to true for production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        try {

            $status = \Midtrans\Transaction::status($order_id);
            $status = (object) $status;



            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $data_info = array(
                    'user_id' => $settings['user_id'],
                    'order_id' => $payment['uid'],
                    'shop_id' => $payment['shop_id'],
                    'order_type' => $payment['order_type'],
                    'price' => $status->gross_amount ?? $payment['total'],
                    'currency_code' => isset($status->currency) ? $status->currency : restaurant($settings['id'])->currency_code,
                    'status' => 'success',
                    'txn_id' => $status->transaction_id,
                    'payment_by' => 'midtrans',
                    'created_at' => d_time(),
                );
                $insert = $this->common_m->insert($data_info, 'order_payment_info');
                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $data_info['txn_id']) . '&method=midtrans&amount=' . $data_info['price']);
            } elseif ($status->transaction_status == 'pending') {
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            } else {
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            }
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Error: ' . $e->getMessage());
            echo "Error checking payment status: " . $e->getMessage();
        }
    }


    public function moyasar($slug)
    {
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        if (isset($_GET['id'], $_GET['amount']) && !empty($_GET['id']) && !empty($_GET['amount']) && !empty($slug)) :
            if ($_GET['status'] == 'failed') {
                $data['msg'] = '3-D Secure transaction attempt failed (DECLINED_INVALID_PIN)';
                $data['status'] = 0;
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            } else {

                $shop = $this->admin_m->get_restaurant_info_slug($slug); //get user info by slug 
                $moyasar = isJson($shop['moyasar_config']) ? json_decode($shop['moyasar_config']) : '';

                $payment = auth('payment');


                $apiKey = isset($moyasar->moyasar_secret_key) && !empty($moyasar->moyasar_secret_key) ? $moyasar->moyasar_secret_key : '';
                $paymentId = $_GET['id'];

                $url = "https://api.moyasar.com/v1/payments/$paymentId";

                $client = new Client();

                try {
                    $response = $client->request('GET', $url, [
                        'headers' => [
                            'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
                        ],
                    ]);

                    $statusCode = $response->getStatusCode();
                    $responseData = json_decode($response->getBody());

                    if (!empty($responseData->status) && $responseData->status == 'paid') :
                        $amount = $responseData->amount / 100;
                        $txn_id = $responseData->id;
                        $currency = $responseData->currency;

                        $data_info = array(
                            'user_id' => $shop['user_id'],
                            'order_id' => $payment['uid'],
                            'shop_id' => $payment['shop_id'],
                            'order_type' => $payment['order_type'],
                            'price' => $amount,
                            'currency_code' => isset($currency) ? $currency : restaurant($shop['id'])->currency_code,
                            'status' => 'success',
                            'txn_id' => $txn_id,
                            'payment_by' => 'moyasar',
                            'created_at' => d_time(),
                        );

                        $insert = $this->common_m->insert($data_info, 'order_payment_info');
                        redirect(base_url('user_payment/payment_success/' . $shop['username'] . '?txn_id=' . $txn_id) . '&method=moyasar&amount=' . $amount);

                    else :
                        redirect(base_url('user_payment/payment_cancel/' . $slug));
                    endif;
                } catch (GuzzleHttp\Exception\RequestException $e) {
                    // Handle request exceptions (e.g., connection issues, timeouts)
                    echo 'Request failed: ' . $e->getMessage();
                } catch (Exception $e) {
                    // Handle general exceptions
                    echo 'Error: ' . $e->getMessage();
                }
            }
        endif;
    }



    public function netseasy($slug)
    {
        $data = [];
        $data['page_title'] = 'Netseasy';
        $data['slug'] = $slug;
        $data['settings'] = settings();
        $data['u_info'] =  $this->admin_m->get_restaurant_info_slug($slug);
        $data['netseasy'] = isJson($data['u_info']['netseasy_config']) ? json_decode($data['u_info']['netseasy_config']) : '';
        $data['paymentId'] = isset($_GET['paymentId']) ? $_GET['paymentId'] : '';
        $this->load->view('payment/user_netseasy_payment', $data);
    }

    public function netseasy_verify($slug)
    {
        $data = [];
        $data['slug'] = $slug;
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by slug 
        $netseasy = isJson($u_info['netseasy_config']) ? json_decode($u_info['netseasy_config']) : '';
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $payment = auth('payment');
        $paymentId = $_GET['paymentId'];
        $url = netseasyUrl($netseasy->is_netseasy_live)->url;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "{$url}/v1/payments/{$paymentId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: {$netseasy->netseasy_secret_key}",
                "CommercePlatformTag: {$this->settings['site_name']}"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $netseasy = json_decode($response)->payment;
            if (isset($netseasy->paymentId) && !empty($netseasy->paymentId)) :
                $data = array(
                    'currency_code' => $netseasy->orderDetails->currency,
                    'price' => $netseasy->orderDetails->amount / 100,
                    'txn_id' => $netseasy->paymentId,
                    'status' => 'success',
                    'payment_by' => 'netseasy',
                    'user_id' => $u_info['user_id'],
                    'order_id' => $payment['uid'],
                    'shop_id' => $payment['shop_id'],
                    'order_type' => $payment['order_type'],
                    'created_at' => d_time(),
                );
                $insert = $this->common_m->insert($data, 'order_payment_info');

                redirect(base_url('user_payment/payment_success/' . $u_info['username'] . '?txn_id=' . $data["txn_id"]) . '&method=netseasy&amount=' . $data["price"]);
            else :
                $data['msg'] = 'Sorry transaction faild';
                $data['status'] = 0;
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            endif;
        }
    }








    /*----------------------------------------------
        START RAZOPRPAY PAYMENT
        ----------------------------------------------*/
    public function razorpay_payment()
    {
        $statusMsg = '';
        $data = array();
        if (!empty($this->input->post('razorpay_payment_id'))) {


            $payment_id = $this->input->post('razorpay_payment_id');
            $slug = $this->input->post('username');
            $settings = settings();
            $u_info = $this->admin_m->get_restaurant_info_slug($slug);
            $data['id'] = $u_info['id'];
            if (empty($id)) {
                redirect(base_url('error-404'));
            }
            $payment = auth('payment');
            $amount = $this->input->post('totalAmount');
            $total_price = $amount / 100;

            $razorpay = json_decode($u_info['razorpay_config'], TRUE);

            $keys = array(
                'key_id' => $razorpay['razorpay_key_id'],
                'secret_key' => $razorpay['razorpay_key'],
            );


            $data = array(
                'amount' => round($amount),
                'currency' => $u_info['currency_code'],
            );

            $success = false;
            $error = '';
            $status = '';

            try {
                $ch = $this->curl_handler($payment_id, $data, $keys);
                //execute post
                $result = curl_exec($ch);

                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                 echo "<pre>";print_r($result);exit();
                if ($result === false) {
                    $success = false;
                    $msg = 'Curl error: ' . curl_error($ch);
                    echo json_encode(['st' => 0, 'msg' => $msg]);
                } else {
                    $response_array = json_decode($result, true);
                   
                    //Check success response
                    if ($http_status === 200 and isset($response_array['error']) === false) {
                        $success = true;
                        $status = $response_array['status'];
                    } else {
                        $success = false;
                        $status = $response_array['status'];
                        if (!empty($response_array['error']['code'])) {
                            $msg = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                        } else {
                            $msg = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                        }
                        echo json_encode(['st' => 0, 'msg' => $msg]);
                    }
                }
                //close curl connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $msg = 'Request to Razorpay Failed';
                echo json_encode(['st' => 0, 'msg' => $msg]);
            }


            if ($success === true) {
                $data_info = array(
                    'user_id' => $u_info['user_id'],
                    'order_id' => $payment['uid'],
                    'shop_id' => $payment['shop_id'],
                    'order_type' => $payment['order_type'],
                    'price' => $total_price,
                    'currency_code' => 'INR',
                    'status' => strtolower(!empty($status) ? $status : 'authorized'),
                    'txn_id' => $payment_id,
                    'payment_by' => 'razorpay',
                    'created_at' => d_time(),
                );

                $insert = $this->common_m->insert($data_info, 'order_payment_info');

                if ($insert) :
                    $data['url'] = base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $payment_id) . '&method=razorpay&amount=' . $total_price;

                    $data['status'] = 1;
                    $data['msg'] = lang('payment_success');
                else :
                    $data['msg'] = lang('payment_failed');
                    $data['status'] = 0;
                endif;

                echo json_encode($data);
            } else {
                $msg = 'Payment Canceled';
                echo json_encode(['st' => 0, 'msg' => $msg]);
            } //success === true


        } else {
            $msg = 'An error occured. Contact site administrator, please!';
            echo json_encode(['st' => 0, 'msg' => $msg]);
        }
    }

    private function curl_handler($payment_id, $data, $keys)
    {
        $url            = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';
        $key_id         = $keys['key_id'];
        $key_secret     = $keys['secret_key'];
        $params = http_build_query($data);
        // $params = http_build_query($data);
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch;
    }

    /*----------------------------------------------
        END RAZOPRPAY PAYMENT
        ----------------------------------------------*/










    // Payment succes 
    function paypal($slug)
    {
        $data = array();
        //get payment data from paypal url
        $paypalInfo = $this->input->get();
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }


        $payment = auth('payment');
        $data_info = array(
            'user_id' => $u_info['user_id'],
            'order_id' => $payment['uid'],
            'shop_id' => $payment['shop_id'],
            'order_type' => $payment['order_type'],
            'price' => $paypalInfo["amt"],
            'currency_code' => $paypalInfo["cc"],
            'status' => $paypalInfo["st"],
            'txn_id' => $paypalInfo["tx"],
            'payment_by' => 'paypal',
            'created_at' => d_time(),
        );
        $insert = $this->common_m->insert($data_info, 'order_payment_info');

        if ($insert) :
            if ($paypalInfo["st"] == 'Approved' || $paypalInfo["st"] == 'Completed') {

                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $paypalInfo["tx"]) . '&method=paypal&amount=' . $paypalInfo["amt"]);
            } else {
                $data['msg'] = lang('payment_failed');
                $data['status'] = 0;

                redirect(base_url('user_payment/payment_cancel/' . $slug));
            }
        else :
            redirect(base_url('user_payment/payment_cancel/' . $slug));
        endif;
        //pass the transaction data to view
    }


    public function offline_payment_request($slug)
    {
        is_test();
        $id =  $this->input->post('id', true);
        $data = array();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $payment = auth('payment');

        if (empty($payment)) {
            redirect(base_url($slug));
            exit();
        }

        $this->form_validation->set_rules('order_id', __('order_id'), 'trim|xss_clean|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $payment = auth('payment');
            $offline_type = $this->input->post('offline_type', true);
            $data_info = array(
                'user_id' => $u_info['user_id'],
                'order_id' => $payment['uid'],
                'shop_id' => $payment['shop_id'],
                'order_type' => $payment['order_type'],
                'price' => $payment["total"],
                'currency_code' => $u_info['currency_code'],
                'status' => 'pending',
                'txn_id' => random_string('alnum', 12),
                'payment_by' => 'offline',
                'offline_type' => $offline_type ?? 0,
                'created_at' => d_time(),
            );
            $txn_id = $this->input->post('transaction_id', true);
            $insert = $this->common_m->insert($data_info, 'order_payment_info');
            if ($insert) :
                $data = [];
                if (!empty($_FILES['file']['name'])) {
                    $up_load = $this->upload_m->upload();;
                    if ($up_load['st'] == 1) :
                        foreach ($up_load['data'] as $key => $value) {
                            $data[] = array(
                                'images' => $value['image'],
                                'thumb' => $value['thumb'],
                            );
                        }
                    endif;
                }
                $txn_id = ['txn_id' => $txn_id ?? ''];
                $data =  array_merge($txn_id, $data);

                $this->admin_m->update(['offline_payment_info' => json_encode($data)], $insert, 'order_payment_info');

                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $data_info["txn_id"]) . '&method=offline&amount=' . $data_info["price"]);
            else :
                redirect(base_url('user_payment/payment_cancel/' . $slug));
            endif;
        }
    }




    /*----------------------------------------------
Payment success
----------------------------------------------*/
    public function payment_success($slug)
    {
        try {
            if (empty($slug)) {
                throw new Exception('Invalid slug provided');
            }

            $this->load->model('order_m');

            $id = get_id_by_slug($slug);
            if (empty($id)) {
                log_message('error', 'Invalid shop slug: ' . $slug);
                redirect(base_url('error-404'));
                return;
            }

            $payment = auth('payment');
            if (empty($payment)) {
                log_message('error', 'Payment authentication failed for slug: ' . $slug);
                redirect(base_url($slug));
                return;
            }

            // Get shop information
            $u_info = $this->admin_m->get_restaurant_info_slug($slug);
            $shop_info = $this->admin_m->get_restaurant_info($id);

            if (empty($shop_info)) {
                throw new Exception('Shop information not found');
            }

            // Prepare price data
            $prices = [
                'price' => $payment['total'] ?? 0,
                'tax_fee' => $payment['tax_fee'] ?? 0,
                'is_item_tax' => $payment['is_item_tax'] ?? 0,
                'total' => $payment['sub_total'] ?? 0,
            ];

            // Prepare customer data
            $customer_data = [
                'name' => $payment['name'] ?? '',
                'email' => $payment['email'] ?? '',
                'phone' => $payment['phone'] ?? '',
                'customer_id' => $payment['customer_id'] ?? 0,
                'is_guest' => $payment['is_guest_login'] ?? 0
            ];

            // Prepare input data
            $inputData = array_merge(
                $payment,
                [
                    'is_payment' => isset($_GET['method']) && $_GET['method'] == 'offline' ? 0 : 1,
                    'payment_by' => $_GET['method'] ?? '',
                ]
            );

            // Prepare and validate order data
            $order_data = $this->order_m->prepare_order_data($inputData, $shop_info, $prices, $customer_data);
            if (empty($order_data)) {
                throw new Exception('Failed to prepare order data');
            }

            // Check existing order
            $check = $this->common_m->check_order($order_data['shop_id'], $order_data['uid']);

            if ($check['check'] == 0) {
                $insert = $this->order_m->create_order($order_data);
                if (!$insert) {
                    throw new Exception('Failed to create order');
                }
                $data = $this->order_m->order_info($insert, $order_data, $type = 0);
            } else {
                $insert = $check['result']['id'];
                $order_data = $check['result'];
            }

            // Process payment link if exists
            if ($insert) {
                if (!empty(auth('is_paymentLink')) && auth('is_paymentLink') == 1) {
                    $updateData = [
                        'is_payment' => 1,
                        'payment_by' => $_GET['method'] ?? '',
                    ];

                    $update_result = $this->admin_m->update_with_uid($updateData, $order_data['uid'], 'order_user_list');
                    if (!$update_result) {
                        log_message('error', 'Failed to update payment status for order: ' . $order_data['order_id']);
                    }
                }

                // Send order email
                try {
                    $this->user_email_m->send_order_mail($order_data['order_id'], 0);
                } catch (Exception $e) {
                    log_message('error', 'Failed to send order email: ' . $e->getMessage());
                }

                redirect(base_url("order-success/{$slug}/{$payment['uid']}?txn_id={$_GET['txn_id']}&method={$_GET['method']}&amount={$payment['total']}"));
                return;
            }

            throw new Exception('Failed to process order');
        } catch (Exception $e) {
            log_message('error', 'Payment processing error: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while processing your payment. Please try again.');
            redirect(base_url($slug));
            return;
        }
    }





    public function stripe_payment()
    {

        $data = array();
        $statusMsg = '';

        if (!empty($this->input->post('stripeToken'))) {
            $amount = $this->input->post('amount');
            $shop_id = $this->input->post('shop_id');
            $slug = $this->input->post('username');
            $name = $this->input->post('stripe_name');
            $email = $this->input->post('stripe_email');

            $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url
            $secret_key = json_decode($u_info['stripe_config']);
            $id = get_id_by_slug($slug);
            $data['id'] = $id;
            if (empty($id)) {
                redirect(base_url('error-404'));
            }


            $params = array(
                'amount' => $amount * 100,
                'currency' => $u_info['currency_code'],
                'description' => 'Charge for ' . $slug . ' Order',
                'source' => $this->input->post('stripeToken'),
                'metadata' => array(
                    'shop_id' => $shop_id,
                    'shipping' => 'express'
                )
            );
            $jsonData = $this->get_curl_handle($params, $secret_key->secret_key);
            $resultJson = json_decode($jsonData, true);
            if ($resultJson['amount_refunded'] == 0 && empty($resultJson['failure_code']) && $resultJson['paid'] == 1 && $resultJson['captured'] == 1) {
                // Order details  
                $transactionID = $resultJson['balance_transaction'];
                $currency = $resultJson['currency'];
                $payment_status = $resultJson['status'];


                // If the order is successful 
                if ($payment_status == 'succeeded') {

                    $payment = auth('payment');
                    $total_price = $payment['total'];
                    $data_info = array(
                        'user_id' => $u_info['user_id'],
                        'order_id' => $payment['uid'],
                        'shop_id' => $payment['shop_id'],
                        'order_type' => $payment['order_type'],
                        'price' => $total_price,
                        'currency_code' => $currency,
                        'status' => $payment_status,
                        'txn_id' => $transactionID,
                        'payment_by' => 'stripe',
                        'created_at' => d_time(),
                    );
                    $insert = $this->common_m->insert($data_info, 'order_payment_info');

                    if ($insert) {
                        redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $transactionID . '&method=stripe'));
                    }


                    $data['status'] = 1;
                    $data['msg'] = lang('payment_success');


                    $this->session->set_flashdata('payment_msg', $statusMsg);
                } else {
                    $data['msg'] = 'Payment failed';
                    $data['status'] = 0;
                    redirect(base_url('user_payment/payment_cancel/' . $slug));
                }
            } else {
                $data['msg'] = 'Transaction has been failed!';
                $data['status'] = 0;

                redirect(base_url('user_payment/payment_cancel/' . $slug));
            }
        } else {
            $statusMsg = "Error on form submission.";
            redirect(base_url('user_payment/payment_cancel/'));
        }
    }

    // get curl handle method
    private function get_curl_handle($data, $secret_key)
    {
        $url = 'https://api.stripe.com/v1/charges';
        $key_secret = $secret_key;
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        $params = http_build_query($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $output = curl_exec($ch);
        return $output;
    }


    public function payment_cancel($slug)
    {
        $data = [];
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        $data['slug'] = $slug;

        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $data['id'] = $u_info['user_id'];
        $data['slug'] = $u_info['username'];
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], TRUE);
        $data['status'] = 1;
        $data['msg'] = lang('payment_success');
        $data['main_content'] = $this->load->view('payment/payment_cancel', $data, TRUE);
        $this->load->view('payment_index', $data);
    }


    /* end stripe payment
    ================================================== */

    /*----------------------------------------------
        STRIPE FPX
        ----------------------------------------------*/

    public function stripe_fpx()
    {
        if (isset($_GET['slug'])) {
            $slug = $_GET['slug'];
        } else {
            redirect(base_url('error-404'));
        }
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url

        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $stripe_fpx = json_decode($u_info['fpx_config']);
        $stripe = $this->input->get();
        \Stripe\Stripe::setApiKey($stripe_fpx->fpx_secret_key);

        $intent = \Stripe\PaymentIntent::retrieve($stripe['payment_intent']); //PAYMENT_INTENT_ID
        $charges = $intent->charges->data;
        if ($stripe['redirect_status'] == "succeeded") :
            $bank_name = $charges[0]->payment_method_details->fpx->bank;
            $bank_txn = $charges[0]->payment_method_details->fpx->transaction_id;

            $payment = auth('payment');
            $total_price = $payment['total'];
            $data_info = array(
                'user_id' => $u_info['user_id'],
                'order_id' => $payment['uid'],
                'shop_id' => $payment['shop_id'],
                'order_type' => $payment['order_type'],
                'price' => $charges[0]->amount_captured / 100,
                'currency_code' => $charges[0]->currency,
                'status' => $charges[0]->status,
                'txn_id' => $charges[0]->balance_transaction,
                'payment_by' => 'stripe_fpx',
                'created_at' => d_time(),
                'all_info' => json_encode(['bank_name' => $bank_name, 'bank_txn_id' => $bank_txn]),
            );
            $insert = $this->common_m->insert($data_info, 'order_payment_info');

            redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $charges[0]->balance_transaction . '&method=stripe_fpx'));

        elseif ($stripe['redirect_status'] == "failed") :
            redirect(base_url('user_payment/payment_cancel/' . $slug . '/stripe_fpx'));
        endif;
    }

    /*----------------------------------------------
       START  PAYTM
       ----------------------------------------------*/


    public function paytm_verify()
    {

        $slug = $_GET['slug'];
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url

        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $mkey = $_GET['key'];
        require_once("vendor/paytm/paytmchecksum/PaytmChecksum.php");
        $checksum = (!empty($_POST['CHECKSUMHASH'])) ? $_POST['CHECKSUMHASH'] : '';
        unset($_POST['CHECKSUMHASH']);
        $verifySignature = PaytmChecksum::verifySignature($_POST, $mkey, $checksum);
        if ($verifySignature) {
            $payment = auth('payment');
            $total_price = $payment['total'];
            $data_info = array(
                'user_id' => $u_info['user_id'],
                'order_id' => $payment['uid'],
                'shop_id' => $payment['shop_id'],
                'order_type' => $payment['order_type'],
                'price' => $_POST['TXNAMOUNT'],
                'currency_code' => $_POST['CURRENCY'],
                'status' => $_POST['STATUS'] == 'TXN_SUCCESS' ? 'success' : $_POST['STATUS'],
                'txn_id' => $_POST['TXNID'],
                'payment_by' => 'paytm',
                'created_at' => d_time(),
                'all_info' => json_encode(['bank_name' => $_POST['BANKNAME'], 'bank_txn_id' => $_POST['BANKTXNID'], 'gateway' => $_POST['GATEWAYNAME'], 'payment_mode' => $_POST['PAYMENTMODE']]),
            );
            $insert = $this->common_m->insert($data_info, 'order_payment_info');
            redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $_POST['TXNID'] . '&method=paytm'));
        } else {
            redirect(base_url('user_payment/payment_cancel/' . $slug . '/paytm'));
        }
    }

    /*----------------------------------------------
        MERCADOPAGO
        ----------------------------------------------*/
    public function mercado()
    {
        $slug = $_GET['slug'];
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url

        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $settings = settings();
        $mercado = !empty($u_info['mercado_config']) ? json_decode($u_info['mercado_config']) : '';

        $respuesta = array(
            'Payment' => $_GET['payment_id'],
            'Status' => $_GET['status'],
            'MerchantOrder' => $_GET['merchant_order_id']
        );
        MercadoPago\SDK::setAccessToken($mercado->access_token);
        $merchant_order = $_GET['payment_id'];

        $payment = MercadoPago\Payment::find_by_id($merchant_order);

        $payments = auth('payment');
        $total_price = $payments['total'];
        if ($_GET['status'] == 'approved' || $_GET['status'] == 'pending') :
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
            if ($payment->transaction_details->total_paid_amount >= $total_price) :
                $data_info = array(
                    'user_id' => $u_info['user_id'],
                    'order_id' => $payments['uid'],
                    'shop_id' => $payments['shop_id'],
                    'price' => $payment->transaction_details->total_paid_amount,
                    'currency_code' => $payment->currency_id,
                    'status' => $payment->status,
                    'txn_id' => $_GET['preference_id'],
                    'payment_by' => 'paytm',
                    'created_at' => d_time(),
                    'all_info' => json_encode($merchant_order->payments),
                );
                $insert = $this->common_m->insert($data_info, 'order_payment_info');
                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $_GET['preference_id'] . '&method=mercadopago'));
            else :
                $data_info = array(
                    'user_id' => $u_info['user_id'],
                    'order_id' => $payments['uid'],
                    'shop_id' => $payments['shop_id'],
                    'price' => $payment->transaction_details->total_paid_amount,
                    'currency_code' => $payment->currency_id,
                    'status' => $payment->status,
                    'txn_id' => $_GET['preference_id'],
                    'payment_by' => 'paytm',
                    'created_at' => d_time(),
                    'all_info' => json_encode($merchant_order->payments),
                );
                $insert = $this->common_m->insert($data_info, 'order_payment_info');
                redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $_GET['preference_id'] . '&method=mercadopago'));
            endif;
        else :
            redirect(base_url('user_payment/payment_cancel/' . $slug . '/mercadopago'));
            exit();
        endif;

        $paid_amount = 0;
        foreach ($merchant_order->payments as $payment) {
            if ($payment['status'] == 'approved') {
                $paid_amount += $payment['transaction_amount'];
            }
        }
        echo "<pre>";
        print_r($merchant_order->payments);
        exit();
        // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
        if ($paid_amount >= $merchant_order->total_amount) {
            if (count($merchant_order->shipments) > 0) { // The merchant_order has shipments
                if ($merchant_order->shipments[0]->status == "ready_to_ship") {
                    print_r("Totally paid. Print the label and release your item.");
                }
            } else { // The merchant_order don't has any shipments
                print_r("Totally paid. Release your item.");
            }
        } else {
            print_r("Not paid yet. Do not release your item.");
        }

        echo "<pre>";
        print_r($_GET);
        exit();
    }


    /*----------------------------------------------
FLUTTERWAVE
----------------------------------------------*/



    public function flutterwave_create_transaction()
    {
        $post = $_POST;
        $data = array(
            'amount' => $post['amount'],
            'customer_email' => $post['customer_email'],
            'redirect_url' => base_url("user_payment/flutterwave_payment_status/?slug={$post['slug']}"),
            'payment_plan' => $post['payment_plan'],
            'csrf_test_name' => $this->security->get_csrf_hash(),
            'slug' => $post['slug'],
        );
        $this->response = $this->user_payment_m->create_flutterwave_payment($data);
        if (!empty($this->response) || $this->response != '') {
            $this->response = json_decode($this->response, 1);
            if (isset($this->response['status']) && $this->response['status'] == 'success') {
                redirect($this->response['data']['link']);
            } else {
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', 'API returned error >> ' . $this->response['message']);
                redirect(base_url('user_payment/payment_cancel/' . $_POST['slug'] . '/flutterwave'));
            }
        }
    }
    public function flutterwave_payment_status()
    {
        $params = $this->input->get();

        $slug = $_GET['slug'];
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get restauratn info by slug
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $payment = auth('payment');
        $total_price = $payment['total'];


        if (isJson($u_info['flutterwave_config'])) :
            $flutterwave = !empty($u_info['flutterwave_config']) ? json_decode($u_info['flutterwave_config']) : '';
            $_ENV = [
                "PUBLIC_KEY" => $flutterwave->fw_public_key, // can be gotten from the dashboard
                "SECRET_KEY" => $flutterwave->fw_secret_key, // can be gotten from the dashboard
                "ENCRYPTION_KEY" => $flutterwave->encryption_key,
                "ENV" => $flutterwave->is_flutterwave_live == 0 ? "development" : "production",
            ];
        endif;



        if (empty($params)) {
            redirect(base_url('user_payment/payment_cancel/' . $slug . '/flutterwave'));
        } elseif (isset($params['tx_ref']) && !empty($params['tx_ref'])) {
            $response = $this->user_payment_m->verify_flutterwave($params);
            if (!empty($response)) {
                if ($response['status'] == 'success' && isset($response['data']['charged_amount']) && (!$response['data']['charged_amount'] == '00' || !$response['data']['charged_amount'] == '0')) {


                    $data['customer_email']         = $response['data']['customer']['email'];
                    $data['txn_id']         = $response['data']['flw_ref'];
                    $data['amount']    = $response['data']['amount'];
                    $data['currency_code']  = $response['data']['currency'];
                    $data['status']         = $response['data']['status'];
                    $data['message']        = $response['message'];
                    $data['full_data']      = $response;

                    $data_info = array(
                        'user_id' => $u_info['user_id'],
                        'order_id' => $payment['uid'],
                        'shop_id' => $payment['shop_id'],
                        'order_type' => $payment['order_type'],
                        'price' => $data['amount'],
                        'currency_code' => $data['currency_code'],
                        'status' => $data['status'],
                        'txn_id' => $data['txn_id'],
                        'payment_by' => 'flutterwave',
                        'created_at' => d_time(),
                        'all_info' => json_encode(['customer_email' => $data['customer_email'], 'ip' => $response['data']['ip'], 'txid' => $data['txn_id']]),
                    );
                    $insert = $this->common_m->insert($data_info, 'order_payment_info');

                    redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $data['txn_id'] . '&method=flutterwave'));
                } elseif ((isset($params['cancelled']) && $params['cancelled'] == true)) {
                    redirect(base_url('user_payment/payment_cancel/' . $slug . '/flutterwave'));
                } elseif ($response['status'] == 'error') {
                    redirect(base_url('user_payment/payment_cancel/' . $slug . '/flutterwave'));
                }
            } else {

                redirect(base_url('user_payment/payment_cancel/' . $slug . '/flutterwave'));
            }
        }
    }

    public function verify_payment($ref)
    {


        $result = array();
        $slug = isset($_GET['user']) ? $_GET['user'] : '';
        $u_info = $this->admin_m->get_restaurant_info_slug($slug); //get user info by id from paypal url

        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $payment = auth('payment');
        $total_price = $payment['total'];


        $paystack = !empty($u_info['paystack_config']) ? json_decode($u_info['paystack_config']) : '';
        $paystack_secret_key = !empty($paystack->paystack_secret_key) ? $paystack->paystack_secret_key : '';

        $url = 'https://api.paystack.co/transaction/verify/' . $ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . $paystack_secret_key
            ]
        );
        $request = curl_exec($ch);

        curl_close($ch);
        //
        if ($request) {
            $result = json_decode($request, true);
            // print_r($result);
            if ($result) {
                if ($result['data']) {
                    //something came in
                    if ($result['data']['status'] == 'success') {

                        //echo "Transaction was successful";
                        $this->paystack_success($ref, $slug, $paystack_secret_key, 'success');
                    } else {
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        $this->paystack_success($ref, $slug, '', 'fail');
                    }
                } else {

                    //echo $result['message'];
                    $this->paystack_success($ref, $slug, '', 'fail');
                }
            } else {
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                $this->paystack_success($ref, $slug, '', 'fail');
            }
        } else {
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            $this->paystack_success($ref, $slug, '', 'fail');
        }
    }

    public function paystack_success($ref, $slug, $secret_key, $type)
    {
        $data = array();

        $info = $this->getPaymentInfo($ref, $secret_key);
        if ($type == "success") :
            $u_info = $this->admin_m->get_restaurant_info_slug($slug);
            $payment = auth('payment');
            $total_price = $payment['total'];
            $data_info = array(
                'user_id' => $u_info['user_id'],
                'order_id' => $payment['uid'],
                'shop_id' => $payment['shop_id'],
                'order_type' => $payment['order_type'],
                'price' => $info['amount'] / 100,
                'currency_code' => $info['currency'],
                'status' => $info['status'],
                'txn_id' => $info['reference'],
                'payment_by' => 'paystack',
                'created_at' => d_time(),
                'all_info' => json_encode(['customer_email' => $info['customer']['email'], 'ip' => $info['ip_address'], 'customer_code' => $info['customer']['customer_code']]),
            );
            $insert = $this->common_m->insert($data_info, 'order_payment_info');

            redirect(base_url('user_payment/payment_success/' . $slug . '?txn_id=' . $info['reference'] . '&method=paystack'));
        else :
            $data = [
                'amount' => $info['amount'] / 100,
                'currency' => $info['currency'],
                'status' => 'Failed',
                'txn_id' => '1254879287',
                'payment_type' => 'paystack',
                'all_info' => '',
            ];

            redirect(base_url('user_payment/payment_cancel/' . $_POST['slug'] . '/paystack'));
        endif;
    }

    private function getPaymentInfo($ref, $secret_key)
    {

        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/' . $ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Authorization: Bearer ' . $secret_key
            ]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($request, true);
        return $result['data'];
    }

    /*----------------------------------------------
            Pagadito Payment gateways      
            ----------------------------------------------*/
    public function pagadito_success()
    {
        $_ENV = $this->session->userdata('pagadito_data');
        $u_info = get_all_user_info_slug(pagadito('slug'));
        if (isset($_GET)) {
            $response = $this->payment_m->pagadito_verify($_GET);
            if (!empty($response)) :
                if ($response['status'] == 'success') {
                    $currency = $_ENV['currency'];
                    $amount = $_ENV['amount'];
                    // $amount = $response['details']->response->value->amount;
                    $txn_id = $response['details']->response->value->reference;

                    $payment = auth('payment');
                    $data_info = array(
                        'user_id' => $u_info['user_id'],
                        'order_id' => $payment['uid'],
                        'shop_id' => $payment['shop_id'],
                        'order_type' => $payment['order_type'],
                        'price' => $amount,
                        'currency_code' => isset($currency) ? $currency : restaurant($u_info['id'])->currency_code,
                        'status' => $response['status'],
                        'txn_id' => $txn_id,
                        'payment_by' => 'pagadito',
                        'created_at' => d_time(),
                    );
                    $insert = $this->common_m->insert($data_info, 'order_payment_info');

                    redirect(base_url('user_payment/payment_success/' . $u_info['username'] . '?txn_id=' . $txn_id) . '&method=pagadito&amount=' . $amount);
                } else {

                    $data['msg'] = $response['status'];
                    $data['status'] = 0;
                    redirect(base_url('user_payment/payment_cancel/' . $u_info['username']));
                }
            else :
                $data['msg'] = 'Sorry transaction faild';
                $data['status'] = 0;

                redirect(base_url('user_payment/payment_cancel/' . $u_info['username']));
            endif;
        }
    }


    public  function pagadito($slug)
    {
        require_once(APPPATH . 'libraries/Pagadito.php');
        $shop = $this->admin_m->get_restaurant_info_slug($slug);
        if (!empty($shop['pagadito_config'])) :
            $pagadito =  json_decode($shop['pagadito_config']);
            $envData = [
                'slug' => $slug,
                'amount' => $_POST["precio1"],
                'currency' => $shop['currency_code'],
                "UID" => $pagadito->pagadito_uid,
                "WSK" => $pagadito->pagadito_wsk_key,
                "SANDBOX" => $pagadito->is_pagadito_live == 0 ? TRUE : FALSE,
            ];
            $this->session->set_tempdata('pagadito_data', $envData, 900);
            $_ENV = $this->session->userdata('pagadito_data');
        endif;
        if (isset($_POST["slug"]) && isset($_POST["amount"])) :
            $Pagadito = new Pagadito($_ENV['UID'], $_ENV['WSK']);
            if ($_ENV['SANDBOX']) {
                $Pagadito->mode_sandbox_on();
            }

            if ($Pagadito->connect()) {

                $Pagadito->currency($shop['currency_code']);

                $Pagadito->add_detail($_POST["cantidad1"], $_POST["descripcion1"], $_POST["precio1"], $_POST["url1"]);
                /*
                 * Then we go on to add the details
                 */
                // if ($_POST["cantidad1"] > 0) {
                //     $Pagadito->add_detail($_POST["cantidad1"], $_POST["descripcion1"], $_POST["precio1"], $_POST["url1"]);
                // }

                //Adding custom transaction fields
                $Pagadito->set_custom_param("param1", $slug);
                // $Pagadito->set_custom_param("param3", "Valor de param3");
                // $Pagadito->set_custom_param("param4", "Valor de param4");
                // $Pagadito->set_custom_param("param5", "Valor de param5");

                //Enables the receipt of pre-authorized payments for the collection order.
                $Pagadito->enable_pending_payments();

                /*
                 * Lo siguiente es ejecutar la transacción, enviandole el ern.
                 *
                 * A manera de ejemplo el ern es generado como un número
                 * aleatorio entre 1000 y 2000. Lo ideal es que sea una
                 * referencia almacenada por el Pagadito Comercio.
                 */
                $ern = random_string('alnum', 8);
                if (!$Pagadito->exec_trans($ern)) {
                    /*
                     * En caso de fallar la transacción, verificamos el error devuelto.
                     * Debido a que la API nos puede devolver diversos mensajes de
                     * respuesta, validamos el tipo de mensaje que nos devuelve.
                     */
                    switch ($Pagadito->get_rs_code()) {
                        case "PG2001":
                            /*Incomplete data*/
                        case "PG3002":
                            /*Error*/
                        case "PG3003":
                            /*Unregistered transaction*/
                        case "PG3004":
                            /*Match error*/
                        case "PG3005":
                            /*Disabled connection*/
                        default:
                            echo "
                        <SCRIPT>
                        alert(\"" . $Pagadito->get_rs_code() . ": " . $Pagadito->get_rs_message() . "\");
                        location.href = 'index.php';
                        </SCRIPT>
                        ";
                            break;
                    }
                }
            } else {
                /*
                 * En caso de fallar la conexión, verificamos el error devuelto.
                 * Debido a que la API nos puede devolver diversos mensajes de
                 * respuesta, validamos el tipo de mensaje que nos devuelve.
                 */
                switch ($Pagadito->get_rs_code()) {
                    case "PG2001":
                        /*Incomplete data*/
                    case "PG3001":
                        /*Problem connection*/
                    case "PG3002":
                        /*Error*/
                    case "PG3003":
                        /*Unregistered transaction*/
                    case "PG3005":
                        /*Disabled connection*/
                    case "PG3006":
                        /*Exceeded*/
                    default:
                        echo "
                    <SCRIPT>
                    alert(\"" . $Pagadito->get_rs_code() . ": " . $Pagadito->get_rs_message() . "\");
                    location.href = 'index.php';
                    </SCRIPT>
                    ";
                        break;
                }
            }

        else :
            echo "
            <script>
            alert('No ha llenado los campos adecuadamente.');
            location.href = 'index.php';
            </script>
            ";
        endif;
    }

    /**
     * Webhook para receber notificações do Mercado Pago PIX dinâmico
     *
     * @return void
     */
    public function mercado_pix_webhook()
    {
        // Log da requisição para debug
        $input = file_get_contents('php://input');
        log_message('info', 'Mercado PIX Webhook received: ' . $input);

        // Verificar se é uma requisição POST
        if ($this->input->method() !== 'post') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        try {
            // Decodificar dados do webhook
            $webhook_data = json_decode($input, true);

            if (empty($webhook_data)) {
                throw new Exception('Invalid webhook data');
            }

            // Verificar se é notificação de pagamento
            if (!isset($webhook_data['type']) || $webhook_data['type'] !== 'payment') {
                http_response_code(200);
                echo json_encode(['message' => 'Webhook type not supported']);
                return;
            }

            // Carregar model do Mercado PIX
            $this->load->model('mercado_pix_m');

            // Processar webhook
            $result = $this->mercado_pix_m->process_webhook($webhook_data);

            if ($result['success']) {
                http_response_code(200);
                echo json_encode(['message' => 'Webhook processed successfully']);
                log_message('info', 'Mercado PIX Webhook processed: ' . $result['message']);
            } else {
                http_response_code(400);
                echo json_encode(['error' => $result['error']]);
                log_message('error', 'Mercado PIX Webhook error: ' . $result['error']);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
            log_message('error', 'Mercado PIX Webhook exception: ' . $e->getMessage());
        }
    }
}
