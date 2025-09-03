<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;

class Payment extends MY_Controller
{
    protected $client;
    function  __construct()
    {
        parent::__construct();
        $this->load->library('paypal_lib');
        $this->config->load('stripe_config');
        $this->load->model('payment_m');
        // is_login();
        $this->client = new Client();
    }

    public function total_amount()
    {
        $amount = temp('total_amount');
        return $amount;
    }



    public function index($slug, $account_slug)
    {
        $settings = settings();
        $data = array();
        $data['page_title'] = "Payment Method";
        $data['page'] = "Payment";
        $data['account_type'] = $account_slug;
        $data['account_slug'] = $account_slug;
        $data['slug'] = $slug;
        $data['st'] = (object) $settings;
        $data['u_info'] = get_all_user_info_slug($slug);
        $data['u'] = (object) $this->common_m->get_user_info_by_slug($slug);
        $data['admin'] = admin();
        $data['package'] = $this->admin_m->get_package_info_by_slug($account_slug);
        if (isset($data['u']->account_type, $data['package']['id']) && $data['u']->account_type == $data['package']['id']) :
            $data['invoice_info'] = $this->admin_m->get_subscribed_package($data['u']->id, $data['package']['id']);
        else :
            $data['invoice_info'] = $this->admin_m->get_invoice_details($data['u']->id, $data['package']['id']);
        endif;


        $data['tax'] = isset($data['st']->invoice_config) && isJson($data['st']->invoice_config) ? json_decode($data['st']->invoice_config) : '';

        if (isset($data['invoice_info']->referal_code) && !empty($data['invoice_info']->referal_code)) :
            $data['ref_info'] = $this->affiliate_m->get_affiliate_info_by_code($data['invoice_info']->referal_code, $data['u']->id);
        endif;

        $price = $data['package']['price'];

        $tax_percent = isset($data['tax']->tax_percent) && !empty($data['tax']->tax_percent) ? $data['tax']->tax_percent : 0;
        $tax_fee = get_percent($price, $tax_percent);

        $data['tax'] = isset($data['st']->invoice_config) && isJson($data['st']->invoice_config) ? json_decode($data['st']->invoice_config) : '';



        if ($settings['is_paytm'] == 1 && isset($_GET['method']) && $_GET['method'] == "paytm") :
            $paytm = $this->payment_m->paytm_init($slug, $account_slug, 'admin');
            $data['paytm_init'] = $paytm;
        endif;

        if ($settings['is_mercado'] == 1 && isset($_GET['method']) && $_GET['method'] == "mercado") :
            $mercado = $this->payment_m->mercado_init($slug, $account_slug);
            $data['init'] = $mercado['init'];
        endif;

        if ($settings['is_netseasy'] == 1 && isset($_GET['method']) && $_GET['method'] == "netseasy") :
            $netseasy = $this->payment_m->netseasy_init($slug, $account_slug);
            $data['init'] = $netseasy;
        endif;


        if ($settings['is_midtrans'] == 1 && isset($_GET['method']) && $_GET['method'] == "midtrans") :
            $midtrans = $this->payment_m->midtrans_init($slug, $account_slug);
            $data['token'] = $midtrans;
        endif;

        if ($settings['is_cashfree'] == 1 && isset($_GET['method']) && $_GET['method'] == "cashfree") :
            $cashfree = $this->payment_m->cashfree_init($slug, $account_slug);
            $data['payment_session_id'] = $cashfree['payment_session_id'];
        endif;

        if ($settings['is_myfatoorah'] == 1 && isset($_GET['method']) && $_GET['method'] == "myfatoorah") :
            $myfatoorah = $this->payment_m->myfatoorah_init($slug, $account_slug);
            $data['payment_link'] = $myfatoorah['payment_link'];
        endif;


        if ($settings['is_iyzico'] == 1 && isset($_GET['method']) && $_GET['method'] == "iyzico_payment") :
            $iyzico = $this->payment_m->iyzico_init($slug, $account_slug);
            $data['payment_link'] = $iyzico;
            $data['main_content'] = $this->load->view('backend/payments/inc/iyzico_payment', $data, TRUE);
            $this->load->view('backend/index', $data);
            return;

        endif;
        $data['main_content'] = $this->load->view('backend/payments/payment_gateway', $data, TRUE);
        $this->load->view('backend/index', $data);
    }



    public function iyzico($slug = null, $account_slug = null)
    {

        $this->security->csrf_verify = false;
        $postData = $this->input->get();
        if (isset($postData['token']) && empty($postData['token'])) {
            $this->session->set_flashdata('error', 'Token not found');
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        if (empty($slug) && empty($account_slug)) {
            $this->session->set_flashdata('error', 'User not found');
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        $settings = settings();

        $iyzico = isJson($settings['iyzico_config']) ? json_decode($settings['iyzico_config']) : '';
        $baseUrl = isset($iyzico->is_iyzico_live) && $iyzico->is_iyzico_live == 1 ? 'https://api.iyzipay.com' : 'https://sandbox-api.iyzipay.com';



        $checkoutFormToken = $postData['token'];



        $options = new \Iyzipay\Options();
        $options->setApiKey(isset($iyzico->iyzico_api_key) && !empty($iyzico->iyzico_api_key) ? $iyzico->iyzico_api_key : '');  // Use your sandbox key
        $options->setSecretKey(isset($iyzico->iyzico_secret_key) && !empty($iyzico->iyzico_secret_key) ? $iyzico->iyzico_secret_key : '');  // Use your sandbox secret
        $options->setBaseUrl($baseUrl);  // Sandbox URL for testing


        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);  
        $request->setConversationId(uniqid()); 
        $request->setToken($checkoutFormToken);  

        // Retrieve checkout form result
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);


        if ($checkoutForm->getStatus() === "success") {
            $paidAmount = $checkoutForm->getPaidPrice();
            $currency = $checkoutForm->getCurrency();
            $transactionId = $checkoutForm->getPaymentId();
            $data = [
                'amount' => $paidAmount,
                'currency' => $currency,
                'status' => 'success',
                'txn_id' => $transactionId,
                'payment_type' => 'izyico',
                'all_info' => json_encode($checkoutForm->getRawResult()),
            ];
            $this->send_success($slug, $account_slug, $data);
        } else {
            echo $checkoutForm->getErrorMessage();
            $this->send_failed($slug, $account_slug);
        }
    }


    public function iyzico_callback()
    {

        $transaction_id = $this->input->get('transaction_id');
        $slug = $this->input->get('slug');
        $account_slug = $this->input->get('account_slug');


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

        $postData = $this->input->post();


        if (!isset($postData['token']) || empty($postData['token'])) {
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        if (empty($slug) || empty($account_slug)) {
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }


        redirect(base_url("payment/iyzico/{$slug}/{$account_slug}?token=" . $postData['token']));
        exit();
    }




    private function log_callback_data($context, $data = null)
    {
        $logFile = APPPATH . 'logs/iyzico_callback.log'; 

 
        $logMessage = date('Y-m-d H:i:s') . " - $context\n";
        if ($data !== null) {
            $logMessage .= print_r($data, true) . "\n";
        }

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }




    public function myfatoorah()
    {
        $get = $this->input->get();


        $payment_id = $get['paymentId'];
        $order_id = $get['Id'];
        $slug = $get['slug'];
        $account_slug = $get['account_slug'];

        if (empty($payment_id) && empty($slug)) {
            $this->session->set_flashdata('error', __('error_msg'));
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        $keyId   = $payment_id;
        $KeyType = 'paymentId';

        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
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
                $data = array(
                    'amount' => $result->focusTransaction->PaidCurrencyValue,
                    'currency' => $result->focusTransaction->Currency,
                    'status' => 'success',
                    'txn_id' => $result->focusTransaction->TrackId,
                    'payment_type' => 'myfatoorah',
                    'all_info' => json_encode($result),
                );
                $this->send_success($slug, $account_slug, $data);
            } else {
                $this->send_failed($slug, $account_slug);
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
        $account_slug = $this->input->get('account_slug', true);

        if (empty($orderId) && empty($slug)) {
            $this->session->set_flashdata('error', __('error_msg'));
            redirect(base_url("admin/auth/subscriptions"));
            exit();
        }

        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $cashfree = isJson($settings['cashfree_config']) ? json_decode($settings['cashfree_config']) : '';

        // Replace with your actual Cashfree API credentials
        $apiKey = isset($cashfree->cashfree_app_id) ? $cashfree->cashfree_app_id : '';
        $apiSecret = isset($cashfree->cashfree_secret_key) ? $cashfree->cashfree_secret_key : '';

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
                $data = array(
                    'amount' => $result->order_amount,
                    'currency' => $result->order_currency,
                    'status' => 'success',
                    'txn_id' => $result->order_id,
                    'payment_type' => 'cashfree',
                    'all_info' => json_encode($result),
                );
                $this->send_success($slug, $account_slug, $data);
            } else {
                $this->send_failed($slug, $account_slug);
            }
        } catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }

    public function midtrans()
    {
        $order_id = $this->input->get('order_id');
        $slug = $this->input->get('slug');
        $account_slug = $this->input->get('account_slug');

        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $midtrans = isJson($settings['midtrans_config']) ? json_decode($settings['midtrans_config']) : '';


        \Midtrans\Config::$serverKey = isset($midtrans->server_key) ? $midtrans->server_key : '';
        \Midtrans\Config::$isProduction = isset($midtrans->is_midtrans_live) && $midtrans->is_midtrans_live == 1 ? true : false; // Set to true for production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        try {

            $status = \Midtrans\Transaction::status($order_id);
            $status = (object) $status;



            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $data = array(
                    'amount' => $status->gross_amount,
                    'currency' => $status->currency,
                    'status' => 'success',
                    'txn_id' => $status->transaction_id,
                    'payment_type' => 'midtrans',
                    'all_info' => json_encode($status),
                );
                $this->send_success($slug, $account_slug, $data);
            } elseif ($status->transaction_status == 'pending') {
                echo "Payment pending for order: " . $order_id;
            } else {
                echo "Payment failed for order: " . $order_id;
            }
        } catch (\Exception $e) {
            log_message('error', 'Midtrans Error: ' . $e->getMessage());
            echo "Error checking payment status: " . $e->getMessage();
        }
    }

    public function moyasar_callback($slug, $account_slug)
    {
        if (isset($_GET['id'], $_GET['amount']) && !empty($_GET['id']) && !empty($_GET['amount'])) :

            if ($_GET['status'] == 'failed') {
                $this->session->set_flashdata('error', 'Payment Failed');
                $this->send_failed($slug, $account_slug, $data = []);
            } else {

                $moyasar = isJson($this->settings['moyasar_config']) ? json_decode($this->settings['moyasar_config']) : '';
                $apiKey = isset($moyasar->moyasar_secret_key) && !empty($moyasar->moyasar_secret_key) ? $moyasar->moyasar_secret_key : ''; // 'sk_test_RpRLngrEnaXpkn4zwThM2Q72aECtzT5d2UCAnn3S';

                $paymentId = $_GET['id']; // Replace with the actual payment ID

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
                        $data = array(
                            'currency' => $responseData->currency,
                            'amount' => $responseData->amount / 100,
                            'txn_id' => $responseData->id,
                            'status' => 'success',
                            'payment_type' => 'moyasar',
                            'all_info' => json_encode($responseData),
                        );
                        $this->send_success($slug, $account_slug, $data);
                    else :
                        $this->send_failed($slug, $account_slug, $data = []);
                    endif;
                } catch (GuzzleHttp\Exception\RequestException $e) {
                    // Handle request exceptions (e.g., connection issues, timeouts)
                    echo 'Request failed: ' . $e->getMessage();
                } catch (Exception $e) {
                    // Handle general exceptions
                    echo 'Error: ' . $e->getMessage();
                }
            }
        else :
            $this->send_failed($slug, $account_slug, $data = []);
        endif;
    }
    public function netseasy($slug, $account_slug)
    {
        $data = [];
        $data['page_title'] = 'Netseasy';
        $data['account_slug'] = $account_slug;
        $data['slug'] = $slug;
        $data['settings'] = settings();;
        $data['paymentId'] = isset($_GET['paymentId']) ? $_GET['paymentId'] : '';
        $this->load->view('backend/payments/netseasy_payment', $data);
    }

    public function netseasy_verify($slug, $account_slug)
    {
        $data = [];
        $data['account_slug'] = $account_slug;
        $data['slug'] = $slug;
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $netseasy = isJson($this->settings['netseasy_config']) ? json_decode($this->settings['netseasy_config']) : '';
        $paymentId = $_GET['paymentId'];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://test.api.dibspayment.eu/v1/payments/{$paymentId}",
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
                    'currency' => $netseasy->orderDetails->currency,
                    'amount' => $netseasy->orderDetails->amount / 100,
                    'txn_id' => $netseasy->paymentId,
                    'status' => 'success',
                    'payment_type' => 'netseasy',
                    'all_info' => json_encode($netseasy),
                );
                $this->send_success($slug, $account_slug, $data);
            else :
                $this->send_failed($slug, $account_slug, $data = []);
            endif;
        }
    }




    function success($slug, $account_slug)
    {
        $data = array();
        $statusMsg = '';
        //get payment data from paypal url
        $paypalInfo = $this->input->get();

        $settings = settings();
        $package_info = get_package_info_by_slug($account_slug); //get package info by slug
        $u_info = get_all_user_info_slug($slug); //get user info by id from paypal url

        if (!empty($paypalInfo["amt"])) {
            $data = array(
                'currency' => $paypalInfo["cc"],
                'amount' => $paypalInfo["amt"],
                'txn_id' => $paypalInfo["tx"],
                'status' => $paypalInfo["st"],
                'payment_type' => 'paypal',
                'all_info' => json_encode([]),
            );

            $this->send_success($slug, $account_slug, $data);
        } else {
            $this->send_failed($slug, $account_slug);
        }
    }


    //paypal payment cancel
    function cancel($slug = '')
    {
        if (isset($_GET['slug'])) {
            $slug = $_GET['slug'];
        } else {
            $slug = $slug;
        }
        $this->session->set_flashdata('payment_error', 'Payment cancel');
        redirect(base_url('stripe-payment-success/' . $slug));
    }


    /* *******  Razorpay payment method **********
================================================== */
    function razorpay_payment()
    {
        $statusMsg = '';
        $data = array();

        if (!empty($this->input->post('razorpay_payment_id'))) {
            //get payment data from paypal url
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $package_id = $this->input->post('product_id');
            $settings = settings();
            $package_info = get_package_info_by_id($package_id); //get package info by id
            $u_info = get_all_user_info_slug($this->input->post('username')); //get user info by id from paypal url


            $amount = $this->input->post('totalAmount');

            $keys = array(
                'key_id' => $settings['razorpay_key_id'],
                'secret_key' => $settings['razorpay_key'],
            );


            $data = array(
                'amount' => $amount * 100,
                'currency' => get_currency('currency_code'),
            );

            $success = false;
            $error = '';

            try {
                $ch = $this->curl_handler($razorpay_payment_id, $data, $keys);
                //execute post
                $result = curl_exec($ch);

                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: ' . curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                    //Check success response
                    if ($http_status === 200 and isset($response_array['error']) === false) {
                        $success = true;
                    } else {
                        $success = false;
                        if (!empty($response_array['error']['code'])) {
                            $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                        } else {
                            $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                        }
                    }
                }
                //close curl connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'Request to Razorpay Failed';
                echo json_encode(['st' => 0, 'msg' => $$error]);
            }

            if ($success === true) {
                $payment_data = array(
                    'user_id' => $u_info['user_id'],
                    'account_type' => $package_info['id'],
                    'price' => $amount,
                    'currency_code' => 'INR',
                    'txn_id' => $razorpay_payment_id,
                    'status' => 'Authorized',
                    'payment_type' => 'razorpay',
                    'created_at' => d_time(),
                );
                $insert = $this->common_m->insert($payment_data, 'payment_info');

                if ($insert) :
                    $statusMsg .= '<h4>' . lang("thank_you_for_your_payment") . '</h4>';
                    $statusMsg .= '<h5>' . lang("the_transaction_was_successfull") . '</h5>';
                    $statusMsg .= "<p>" . lang('package') . ": {$package_info['package_name']}</p>";
                    $statusMsg .= "<p>" . lang('transaction_id') . ": {$razorpay_payment_id}</p>";
                    $statusMsg .= "<p>" . lang('total') . ": {$amount} INR</p>";


                    $this->common_m->update(array('is_payment' => 1, 'is_expired' => 0, 'is_request' => 0, 'start_date' => d_time(), 'end_date' => add_year($package_info['package_type'], $package_info['duration'], $package_info['duration_period']), 'account_type' => $package_info['id']), $u_info['user_id'], 'users');

                    $this->session->set_flashdata('payment_msg', $statusMsg);
                    $data['status'] = 1;
                    $data['msg'] = $statusMsg;
                    echo json_encode($data);
                endif;
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


    /* ************* Start stripe Payment
    ================================================== */
    public function stripe_payment($slug, $account_slug)
    {
        $data = array();
        $data['page_title'] = "Stripe Payment";
        $data['page'] = "Payment";
        $data['slug'] = $slug;
        if (empty($slug)) {
            redirect(base_url('404'));
        }
        $data['account_type'] = $account_slug;
        $data['u_info'] = get_all_user_info_slug($slug);
        $data['total_amount'] = $this->total_amount();

        $data['package'] = $this->admin_m->get_package_info_by_slug($account_slug);
        $data['main_content'] = $this->load->view('backend/payments/stripe_payment_form', $data, TRUE);
        $this->load->view('backend/index', $data);
    }


    public function stripe_success($slug)
    {
        $data = array();
        $data['page_title'] = "Payment success";
        $data['page'] = "Payment";
        $data['slug'] = $slug;
        $data['msg'] = $this->session->flashdata('payment_msg') ? $this->session->flashdata('payment_msg') : '';
        $data['u_info'] = get_all_user_info_slug($slug);
        $data['main_content'] = $this->load->view('backend/payments/payment_success', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    public function payment()
    {
        $data = array();
        $statusMsg = '';

        if (!empty($this->input->post('stripeToken'))) {
            $amount = $this->input->post('amount');
            $package_id = $this->input->post('package_id');
            $username = $this->input->post('username');
            $name = $this->input->post('stripe_name');
            $email = $this->input->post('stripe_email');

            $u_info = get_all_user_info_slug($username);
            $package_info = $this->admin_m->get_package_info_by_id($package_id);

            $params = array(
                'amount' => $amount * 100,
                'currency' => CURRENCY_CODE,
                'description' => 'Charge for ' . $this->settings['site_name'] . ' Registrations',
                'source' => $this->input->post('stripeToken'),
                'metadata' => array(
                    'product_id' => $package_id,
                    'shipping' => 'express'
                )
            );
            $jsonData = $this->get_curl_handle($params);
            $resultJson = json_decode($jsonData, true);

            if (!empty($resultJson['error'])) :
                echo "<pre>";
                print_r($resultJson['error']);
                exit();
            else :

                if ($resultJson['amount_refunded'] == 0 && empty($resultJson['failure_code']) && $resultJson['paid'] == 1 && $resultJson['captured'] == 1) {
                    // Order details  
                    $transactionID = $resultJson['balance_transaction'];
                    $currency = $resultJson['currency'];
                    $payment_status = $resultJson['status'];
                    $amount_captured = $resultJson['amount_captured'] / 100;

                    // If the order is successful 
                    if ($payment_status == 'succeeded') {

                        $data = array(
                            'currency' => $currency,
                            'amount' => $amount_captured,
                            'txn_id' => $transactionID,
                            'status' => $payment_status,
                            'payment_type' => 'stripe',
                            'all_info' => json_encode(['receipt_url' => $resultJson['receipt_url']]),
                        );

                        $this->send_success($u_info['username'], $package_info['slug'], $data);
                    } else {
                        $msg = "Your Payment has Failed!";
                        $this->send_failed($u_info['username'], $package_info['slug'], $data, $msg);
                    }
                } else {
                    $msg = isset($resultJson['message']) ? $resultJson['message'] : "Transaction has been failed!";
                    $this->send_failed($u_info['username'], $package_info['slug'], $data, $msg);
                }
            endif;
        } else {
            $statusMsg = "Error on form submission.";
            $this->send_failed('', '', $data, $msg = '');
        }
    }

    // get curl handle method
    private function get_curl_handle($data)
    {
        $url = 'https://api.stripe.com/v1/charges';
        $key_secret = $this->config->item('secret_key');
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


    /* end stripe payment
    ================================================== */



    /*********  Offline Payment
    ================================================== */

    public function offline_payment($slug, $account_slug)
    {
        $statusMsg = '';
        $data = array();
        $data['page_title'] = "Offline Payment";
        $data['slug'] = $slug;
        $data['page'] = 'Payment';
        $txn_id = 'op-' . random_string('alnum', 4) . '-' . random_string('numeric', 4);
        $currency = CURRENCY_CODE;

        $u_info = get_all_user_info_slug($slug);
        $package_info = get_package_info_by_slug($account_slug);
        $send = $this->offline_payment_request_mail($u_info, $package_info, $txn_id);

        if ($send) {
            $off_data = array(
                'txn_id' => $txn_id,
                'username' => $slug,
                'user_id' => $u_info['user_id'],
                'email' => $u_info['email'],
                'package' => $package_info['package_name'],
                'price' => $package_info['price'],
                'status' => 0,
                'created_at' => d_time(),
            );
            $this->admin_m->insert($off_data, 'offline_payment');


            //update payment info
            __update_payment($u_info['user_id'], $package_info['id']);



            $user_data = array(
                'is_request' => 1,
                'is_payment' => 0,
                'account_type' => $package_info['id'],
            );
            $this->admin_m->update($user_data, $u_info['user_id'], 'users');

            $statusMsg .= '<h4>Thanks for your Payment Request!</h4>';
            $statusMsg .= '<h5>Payement Request details are given below:</h5>';
            $statusMsg .= "<p>" . lang('package') . ": {$package_info['package_name']}</p>";
            $statusMsg .= "<p>Request ID: {$txn_id}</p>";
            $statusMsg .= "<p>" . lang('total') . ": {$package_info['price']} {$currency}</p>";
            $this->session->set_flashdata('success_msg', $statusMsg);
            redirect(base_url('payment/successMsg/' . $u_info['username']));
            exit();
        } else {
            $statusMsg = 'Somethings Were Wrong!! Try again';
            $this->session->set_flashdata('payment_error', $statusMsg);
        }
        redirect(base_url('payment/successMsg/' . $u_info['username']));
    }

    public function offline_payment_request($slug, $account_slug)
    {
        is_test();
        $is_required = $_POST['is_txn_required'];
        $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|required');
        $this->form_validation->set_rules('package_slug', 'Package Slug', 'trim|xss_clean|required');

        if (isset($is_required) && $is_required == 1) :
            $this->form_validation->set_rules('transaction_id', lang('transaction_id'), 'trim|xss_clean|required');
        endif;

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $statusMsg = '';
            $u_info = get_all_user_info_slug($slug);
            $package_info = get_package_info_by_slug($account_slug);
            $off_data = array(
                'txn_id' => $_POST['transaction_id'],
                'username' => $slug,
                'user_id' => $u_info['user_id'],
                'email' => $u_info['email'],
                'package' => $package_info['package_name'],
                'price' => $package_info['price'],
                'status' => 0,
                'created_at' => d_time(),
            );
            $insert = $this->admin_m->insert($off_data, 'offline_payment');


            $user_data = array(
                'is_request' => 1,
                'is_payment' => 0,
                'account_type' => $package_info['id'],
            );
            $this->admin_m->update($user_data, $u_info['user_id'], 'users');

            if ($insert) {
                $send = @$this->offline_payment_request_mail($u_info, $account_slug, $_POST['transaction_id']);
                $statusMsg .= '<h4>' . lang("thank_you_for_your_payment") . '</h4>';
                $statusMsg .= '<h5>' . lang("payment_request_details") . '</h5>';
                $statusMsg .= "<p>" . lang('package') . ": {$package_info['package_name']}</p>";
                $statusMsg .= "<p>" . lang('request_id') . ": {$off_data['txn_id']}</p>";
                $statusMsg .= "<p>" . lang('total') . ": {$package_info['price']}</p>";
                $this->session->set_flashdata('success_msg', $statusMsg);
                redirect(base_url('payment/successMsg/' . $u_info['username']));
                exit();
            } else {
                $statusMsg = 'Somethings Were Wrong!! Try again';
                $this->session->set_flashdata('payment_error', $statusMsg);
            }
            redirect(base_url('payment/successMsg/' . $u_info['username']));
        }
    }

    public function text_email_verification()
    {
        $data = [
            'username' => 'phplime',
            'email' => 'phplime.envato@gmail.com',
            'package_name' => 'basic',
            'price' => '50',
            'expire_date' => '10-10-2023',
            'user_id' => '8' ?? '',
            'txnid' => '1234LKIF55LO' ?? '',
        ];
        $package = ['package_name' => 'basic', 'price' => '50.00'];
        $txn_id = '1234LKIF55LO';
        $password = '1234';
        $send = $this->email_m->send_payment_verified_email($data, 'Paypal');
        // $send = $this->offline_payment_request_mail($data,$package,$txn_id);
        echo "<pre>";
        print_r($send);
        exit();
    }

    protected function offline_payment_request_mail($u_info, $package_info, $txn_id)
    {
        if (isset($this->settings['is_dynamic_mail']) && $this->settings['is_dynamic_mail'] == 1) :
            $mailData =  [
                'site_name' => $this->settings['site_name'],
                'username' => $u_info['username'] ?? '',
                'package_name' => $package_info['package_name'] ?? '',
                'email' => $u_info['email'] ?? '',
                'txnid' => $txn_id ?? '',
                'price' => $package_info['price'] ?? '',
            ];
            $send = @$this->email_m->send_global_mail($mailData, $this->settings['smtp_mail'], 'offline_payment_request_mail');
        else :
            $send = @$this->email_m->offline_payment_request_mail($u_info['username'], $package_info['slug'], $txn_id);
        endif;

        return $send;
    }

    /*----------------------------------------------
  			Payment success method
----------------------------------------------*/

    public function send_success($slug, $account_slug, $data)
    {
        $statusMsg = '';
        $package_info = get_package_info_by_slug($account_slug); //get package info by slug
        $u_info = get_all_user_info_slug($slug);


        $check = $this->affiliate_m->check_existing_payment_by_subscriber($u_info['user_id'], $package_info['id'], $data['txn_id']);

        $this->admin_m->update_by_user_id(['is_running' => 0], $u_info['user_id'], 'payment_info');

        if (!empty($check)) {
            $ref_id = $check->ref_id;
            $package_price = !empty($check->package_price) ? $check->package_price : $check->price;
            $id = $check->id;
        } else {
            $ref_id = 0;
            $id = 0;
            $package_price = $package_info['price'];
        }



        $data_info = array(
            'user_id' => $u_info['user_id'],
            'account_type' => $package_info['id'],
            'price' => $data['amount'],
            'package_price' => $package_price,
            'currency_code' => $data['currency'],
            'status' => $data['status'],
            'txn_id' => $data['txn_id'],
            'payment_type' => $data['payment_type'],
            'all_info' => json_encode($data['all_info']),
            'created_at' => d_time(),
            'expire_date' => add_year($package_info['package_type'], $package_info['duration'], $package_info['duration_period']),
            'is_running' => 1,
            'is_self' => 1,
        );

        if ($id == 0) {
            $insert = $this->common_m->insert($data_info, 'payment_info');
        } else {
            $insert = $this->common_m->update($data_info, $id, 'payment_info');
        }
        if ($insert) :

            __update_payment($data_info['user_id'], $data_info['account_type'], $data_info['price']);



            $statusMsg .= '<h4>' . lang("thank_you_for_your_payment") . '</h4>';
            $statusMsg .= '<h5>' . lang("the_transaction_was_successfull") . '</h5>';
            $statusMsg .= "<p" . lang('package') . " {$package_info['package_name']}</p>";
            $statusMsg .= "<p>" . lang('transaction_id') . ": {$data['txn_id']}</p>";
            $statusMsg .= "<p>" . lang('total') . ": {$data['amount']} {$data['currency']}</p>";

            $this->session->set_flashdata('success_msg', $statusMsg);


            $this->common_m->update(array('is_payment' => 1, 'is_expired' => 0, 'is_request' => 0, 'start_date' => d_time(), 'end_date' => add_year($package_info['package_type'], $package_info['duration'], $package_info['duration_period']), 'account_type' => $package_info['id']), $u_info['user_id'], 'users');

            if (isLocalHost() == false):
                $this->email_m->send_payment_verified_email($data_info, $data['payment_type']); // send payment transaction succesfull mail with transaction_id
            endif;


            redirect(base_url('payment/successMsg/' . $u_info['username']));
        endif;
    }

    public function successMsg($slug)
    {
        $data = array();
        $data['page_title'] = "Payment success";
        $data['page'] = "Payment";
        $data['slug'] = $slug;
        $statusMsg = '';
        if (!empty($this->session->flashdata('success_msg'))) {
            $statusMsg .= '<h4>' . lang("thank_you_for_your_payment") . '</h4>';
            $statusMsg .= '<h5>The transaction was successful. </h5>';
            $data['msg'] = $statusMsg;
        } else {

            $data['msg'] = $this->session->flashdata('success_msg') ? $this->session->flashdata('success_msg') : '';
        }
        $data['u_info'] = get_all_user_info_slug($slug);

        $data['main_content'] = $this->load->view('backend/payments/success_msg', $data, TRUE);
        $this->load->view('backend/index', $data);
    }





    public function send_failed($slug = '', $account_slug = '', $data = [], $msg = '')
    {
    
        $statusMsg = '';
        if (!empty($data) && !empty($account_slug)) :
            $package_info = get_package_info_by_slug($account_slug); //get package info by slug
            $u_info = get_all_user_info_slug($slug);
            $data_info = array(
                'user_id' => $u_info['user_id'],
                'account_type' => $package_info['id'],
                'price' => !empty($data['amount']) ? $data['amount'] : $package_info['price'],
                'currency_code' => !empty($data['currency']) ? $data['currency'] : get_currency('currency_code'),
                'status' => 'failed',
                'txn_id' => $data['txn_id'],
                'payment_type' => $data['payment_type'],
                'all_info' => json_encode($data['all_info']),
                'created_at' => d_time(),
            );
            $msg = isset($msg) && !empty($msg) ? "<p>Error: {$data['msg']}</p>" : '';
            $insert = $this->common_m->insert($data_info, 'payment_info');
            if ($insert) :
                $statusMsg .= '<h4>Sorry Payment Failed</h4>';
                $statusMsg .= '<h5>The transaction was unsuccessful. Transaction details are given below:</h5>';
                $statusMsg .= "<p>" . lang('package') . ": {$package_info['package_name']}</p>";
                $statusMsg .= "<p>" . lang('transaction_id') . ": {$data['txn_id']}</p>";
                $statusMsg .= "<p>" . lang('total') . ": {$data['amount']} {$data['currency']}</p>";
                $statusMsg .= $msg;
                $this->session->set_flashdata('payment_error', $statusMsg);
                redirect(base_url('stripe-payment-success/' . $u_info['username']));
            endif;
        else :
            $statusMsg .= '<h4>Sorry Payment Failed</h4>';
            $statusMsg .= '<h5>The transaction was unsuccessful.</h5>';
            $statusMsg .= $msg;
            $this->session->set_flashdata('payment_error', $statusMsg);
            redirect(base_url('stripe-payment-success/' . $slug));
        endif;
    }

    public function paytm_verify()
    {
        $mkey = $_GET['key'];
        require_once("vendor/paytm/paytmchecksum/PaytmChecksum.php");
        $checksum = (!empty($_POST['CHECKSUMHASH'])) ? $_POST['CHECKSUMHASH'] : '';
        unset($_POST['CHECKSUMHASH']);
        $verifySignature = PaytmChecksum::verifySignature($_POST, $mkey, $checksum);
        if ($verifySignature) {
            $data = array(
                'currency' => $_POST['CURRENCY'],
                'amount' => $_POST['TXNAMOUNT'],
                'txn_id' => $_POST['TXNID'],
                'status' => $_POST['STATUS'],
                'payment_type' => 'paytm',
                'all_info' => json_encode(['bank_name' => $_POST['BANKNAME'], 'bank_txn_id' => $_POST['BANKTXNID'], 'gateway' => $_POST['GATEWAYNAME'], 'payment_mode' => $_POST['PAYMENTMODE']]),
            );
            $this->send_success($_GET['slug'], $_GET['account_slug'], $data);
        } else {
            $this->send_failed($_GET['slug'], $_GET['account_slug'], $data);
        }
    }


    public function stripe_fpx()
    {
        $settings = settings();
        $stripe_fpx = json_decode($settings['fpx_config']);
        $stripe = $this->input->get();
        \Stripe\Stripe::setApiKey($stripe_fpx->fpx_secret_key);

        $intent = \Stripe\PaymentIntent::retrieve($stripe['payment_intent']); //PAYMENT_INTENT_ID
        $charges = $intent->charges->data;
        if ($stripe['redirect_status'] == "succeeded") :
            $bank_name = $charges[0]->payment_method_details->fpx->bank;
            $bank_txn = $charges[0]->payment_method_details->fpx->transaction_id;
            $data = array(
                'currency' => $charges[0]->currency,
                'amount' => $charges[0]->amount_captured / 100,
                'txn_id' => $charges[0]->balance_transaction,
                'status' => $charges[0]->status,
                'payment_type' => 'stripe_fpx',
                'all_info' => json_encode(['bank_name' => $bank_name, 'bank_txn_id' => $bank_txn]),
            );
            $this->send_success($stripe['slug'], $stripe['account_slug'], $data);
        elseif ($stripe['redirect_status'] == "failed") :
            $this->send_failed($_GET['slug'], $_GET['account_slug'], $data = []);
        endif;
    }

    public function mercado()
    {
        $settings = settings();
        $mercado = !empty($settings['mercado_config']) ? json_decode($settings['mercado_config']) : '';

        if ($_GET['payment_id'] != "null" && $_GET['merchant_order_id'] != "null") :
            $respuesta = array(
                'Payment' => $_GET['payment_id'],
                'Status' => $_GET['status'],
                'MerchantOrder' => $_GET['merchant_order_id']
            );
            MercadoPago\SDK::setAccessToken($mercado->access_token);
            $merchant_order = $_GET['payment_id'];

            $payment = MercadoPago\Payment::find_by_id($merchant_order);
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);

            $data = array(
                'currency' => $payment->currency_id,
                'amount' => $payment->transaction_details->total_paid_amount,
                'txn_id' => $_GET['preference_id'],
                'status' => $payment->status,
                'payment_type' => 'mercadopago',
                'all_info' => $merchant_order->payments,
            );
            $this->send_success($_GET['slug'], $_GET['account_slug'], $data);
            exit();
        else :
            $paymentData = array(
                'currency' => get_currency('currency_code'),
                'amount' => '',
                'txn_id' => '1254879287',
                'status' => 'error',
                'payment_type' => 'mercadopago',
                'all_info' => json_encode([]),
            );
            $this->send_failed($_GET['slug'], $_GET['account_slug'], $paymentData);
            exit();
        endif;

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
            'redirect_url' => base_url("payment/flutterwave_payment_status/?slug={$post['slug']}&account_slug={$post['account_slug']}"),
            'payment_plan' => $post['payment_plan'],
            'csrf_test_name' => $this->security->get_csrf_hash(),
            'slug' => $post['slug'],
            'account_slug' => $post['account_slug'],
        );
        $this->response = $this->payment_m->create_flutterwave_payment($data);

        if (!empty($this->response) || $this->response != '') {
            $this->response = json_decode($this->response, 1);
            if (isset($this->response['status']) && $this->response['status'] == 'success') {
                redirect($this->response['data']['link']);
            } else {
                $this->session->set_flashdata('message_type', 'danger');
                $this->session->set_flashdata('message', 'API returned error >> ' . $this->response['message']);
                redirect(base_url('flutterwave/'));
            }
        }
    }
    public function flutterwave_payment_status()
    {

        $settings = settings();

        if (!empty($settings['flutterwave_config'])) :
            $flutterwave = json_decode($settings['flutterwave_config']);
            $_ENV = [
                "PUBLIC_KEY" => $flutterwave->fw_public_key, // can be gotten from the dashboard
                "SECRET_KEY" => $flutterwave->fw_secret_key, // can be gotten from the dashboard
                "ENCRYPTION_KEY" => $flutterwave->encryption_key,
                "ENV" => $flutterwave->is_flutterwave_live == 0 ? "development" : "production",
            ];
        endif;


        $params = $this->input->get();
        if (empty($params)) {
            $paymentData = array(
                'currency' => get_currency('currency_code'),
                'amount' => '',
                'txn_id' => '1254879287',
                'status' => 'error',
                'payment_type' => 'flutterwave',
                'all_info' => json_encode([]),
            );

            $this->send_failed($_GET['slug'], $_GET['account_slug'], $paymentData);
        } elseif (isset($params['tx_ref']) && !empty($params['tx_ref'])) {
            $response = $this->payment_m->verify_flutterwave($params);
            if (!empty($response)) {
                if ($response['status'] == 'success' && isset($response['data']['charged_amount']) && (!$response['data']['charged_amount'] == '00' || !$response['data']['charged_amount'] == '0')) {


                    $data['customer_email']         = $response['data']['customer']['email'];
                    $data['txn_id']         = $response['data']['flw_ref'];
                    $data['amount']    = $response['data']['amount'];
                    $data['currency_code']  = $response['data']['currency'];
                    $data['status']         = $response['data']['status'];
                    $data['message']        = $response['message'];
                    $data['full_data']      = $response;
                    $paymentData = array(
                        'currency' => $response['data']['currency'],
                        'amount' => $response['data']['amount'],
                        'txn_id' => $response['data']['flw_ref'],
                        'status' => $response['data']['status'],
                        'payment_type' => 'flutterwave',
                        'all_info' => json_encode(['customer_email' => $data['customer_email'], 'ip' => $data['customer_email'], 'txid' => $data['txn_id']]),
                    );
                    $this->send_success($_GET['slug'], $_GET['account_slug'], $paymentData);
                } elseif ((isset($params['cancelled']) && $params['cancelled'] == true)) {
                    $paymentData = array(
                        'currency' => get_currency('currency_code'),
                        'amount' => '',
                        'txn_id' => '1254879287',
                        'status' => 'cancelled',
                        'payment_type' => 'flutterwave',
                        'all_info' => json_encode([]),
                    );
                    $this->send_failed($_GET['slug'], $_GET['account_slug'], $paymentData);
                } elseif ($response['status'] == 'error') {
                    $paymentData = array(
                        'currency' => $response['data']['currency'],
                        'amount' => $response['data']['amount'],
                        'txn_id' => $response['data']['tx_ref'],
                        'status' => $response['data']['status'],
                        'payment_type' => 'flutterwave',
                        'all_info' => json_encode(['customer_email' => $response['data']['custemail'], 'narration' => $response['data']['narration'], 'ip' => $response['data']['custemail'], 'txid' => $response['data']['custemail']]),
                    );
                    $this->send_failed($_GET['slug'], $_GET['account_slug'], $paymentData);
                    $this->load->view('flutterwave/payment_status', $data = []);
                }
            } else {
                $paymentData = array(
                    'currency' => get_currency('currency_code'),
                    'amount' => '',
                    'txn_id' => '1254879287',
                    'status' => 'error',
                    'payment_type' => 'flutterwave',
                    'all_info' => json_encode([]),
                );

                $this->send_failed($_GET['slug'], $_GET['account_slug'], $paymentData);
            }
        }
    }


    /*----------------------------------------------
                      Paystack Payment gateways
    ----------------------------------------------*/


    public function verify_payment($ref)
    {


        $result = array();
        $slug = isset($_GET['user']) ? $_GET['user'] : '';
        $account_slug = isset($_GET['package']) ? $_GET['package'] : '';
        $settings = settings();
        $paystack = !empty($settings['paystack_config']) ? json_decode($settings['paystack_config']) : '';
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
                        $this->paystack_success($ref, $slug, $account_slug, 'success');
                    } else {
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        $this->paystack_success($ref, $slug, $account_slug, 'fail');
                    }
                } else {

                    //echo $result['message'];
                    $this->paystack_success($ref, $slug, $account_slug, 'fail');
                }
            } else {
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                $this->paystack_success($ref, $slug, $account_slug, 'fail');
            }
        } else {
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            $this->paystack_success($ref, $slug, $account_slug, 'fail');
        }
    }

    public function paystack_success($ref, $slug, $account_slug, $type = 'success')
    {
        $data = array();
        $settings = settings();
        $paystack = !empty($settings['paystack_config']) ? json_decode($settings['paystack_config']) : '';
        $paystack_secret_key = !empty($paystack->paystack_secret_key) ? $paystack->paystack_secret_key : '';
        if ($type == "success") :
            $info = $this->getPaymentInfo($ref, $paystack_secret_key);
            $data = [
                'amount' => $info['amount'] / 100,
                'currency' => $info['currency'],
                'status' => $info["status"],
                'txn_id' => $info["reference"],
                'payment_type' => 'paystack',
                'all_info' => $info,
            ];

            $this->send_success($slug, $account_slug, $data);
        else :
            $data = [
                'amount' => 0,
                'currency' => 0,
                'status' => 'Failed',
                'txn_id' => '1254879287',
                'payment_type' => 'paystack',
                'all_info' => '',
            ];

            $this->send_failed($slug, $account_slug, $data);
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
                Pagadito Payment Gateway
    ----------------------------------------------*/

    public function pagadito_success()
    {
        $_ENV = $this->session->userdata('pagadito_data');
        if (isset($_GET)) {
            $u_info = get_all_user_info_slug(pagadito('slug'));
            $package_info = get_package_info_by_slug(pagadito('account_slug'));
            $response = $this->payment_m->pagadito_verify($_GET);
            if (!empty($response)) :
                if ($response['status'] == 'success') {
                    $currency = $response['details']->currency;
                    $amount = $response['details']->response->value->amount;
                    $txn_id = $response['details']->response->value->reference;

                    $data = array(
                        'currency' => $currency,
                        'amount' => $amount,
                        'txn_id' => $txn_id,
                        'status' => $response['status'],
                        'payment_type' => 'pagadito',
                        'all_info' => json_encode(['details' => $response['details']]),
                    );

                    $this->send_success($u_info['username'], $package_info['slug'], $data);
                } else {
                    $msg = $response['status'];
                    $this->send_failed($u_info['username'], $package_info['slug'], $data = [], $msg);
                }
            else :
                $msg = "Sorry transaction faild";
                $this->send_failed($u_info['username'], $package_info['slug'], $data = [], $msg);
            endif;
        }
    }

    // Pagadito inital
    public  function pagadito($slug, $account_slug)
    {
        require_once(APPPATH . 'libraries/Pagadito.php');
        $settings = settings();
        if (!empty($settings['pagadito_config'])) :
            $pagadito =  json_decode($settings['pagadito_config']);
            $envData = [
                'slug' => $slug,
                'account_slug' => $account_slug,
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

                $Pagadito->currency(get_currency('currency_code'));

                $Pagadito->add_detail($_POST["cantidad1"], $_POST["descripcion1"], $_POST["precio1"], $_POST["url1"]);
                /*
             * Then we go on to add the details
             */
                // if ($_POST["cantidad1"] > 0) {
                //     $Pagadito->add_detail($_POST["cantidad1"], $_POST["descripcion1"], $_POST["precio1"], $_POST["url1"]);
                // }

                //Adding custom transaction fields
                $Pagadito->set_custom_param("param1", $_POST['slug']);
                $Pagadito->set_custom_param("param2", $_POST['account_slug']);
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
                $ern = random_string('alnum', 4);
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





    /*----------------------------------------------
                      End Pagodito
    ----------------------------------------------*/
}
