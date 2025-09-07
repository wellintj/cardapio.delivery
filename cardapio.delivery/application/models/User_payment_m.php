<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require FCPATH."/vendor/flutterwavedev/flutterwave-v3/library/Transactions.php";
use Flutterwave\Transactions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use MyFatoorah\Library\API\Payment\MyFatoorahPayment;

class User_payment_m extends CI_Model
{
    protected $client;
    function  __construct()
    {
        $this->client = new Client();
    }


    public function midtrans_init($slug = '')
    {


        $data = [];
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);
        $midtrans = isJson($u_info['midtrans_config']) ? json_decode($u_info['midtrans_config']) : '';

        $payment = auth('payment');
        $price = round($payment['total']);
        $currency = $u_info['currency_code'] ?? "IDR";


        \Midtrans\Config::$serverKey = isset($midtrans->server_key) ? $midtrans->server_key : '';
        \Midtrans\Config::$isProduction = isset($midtrans->is_midtrans_live) && $midtrans->is_midtrans_live == 1 ? true : false; // Set to true for production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;


        $order_id = $slug . '_' . time();

        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => $price, // Amount in cents
            'currency' => $currency, // Specify the currency
        );

        $items = array(
            array(
                'id' => random_string(),
                'price' => $price,
                'quantity' => 1,
                'name' => $slug,
            )
        );

        $customer_details = array(
            'first_name' => $u_info['username'] ?? '',
            'last_name' => $u_info['username'] ?? '',
            'email' => !empty($payment['email']) ? $payment['email'] : $u_info['email'],
            'phone' => !empty($payment['phone']) ? $payment['phone'] : $u_info['phone'] ?? '',
        );

        $transaction = array(
            'transaction_details' => $transaction_details,
            'item_details' => $items,
            'customer_details' => $customer_details
        );

        // This is where you set the finish_redirect_url
        $transaction['custom_field1'] = base_url("user_payment/midtrans/{$slug}/{$order_id}");
        $transaction['custom_field2'] = $order_id;
        $transaction['slug'] = $slug;

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            return  $snapToken;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }



    public function cashfree_init($slug = '')
    {
        $data = [];
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);
        $cashfree = isJson($u_info['cashfree_config']) ? json_decode($u_info['cashfree_config']) : '';

        $payment = auth('payment');
        $price = $payment['total'];
        $currency = $u_info['currency_code'] ?? "INR";

        try {
            if (isset($cashfree->is_cashfree_live) && $cashfree->is_cashfree_live == 1) {
                $apiEndpoint =   'https://api.cashfree.com/pg/orders';
            } else {
                $apiEndpoint = "https://sandbox.cashfree.com/pg/orders";
            }

            $appId = isset($cashfree->cashfree_app_id) && !empty($cashfree->cashfree_app_id) ? $cashfree->cashfree_app_id : '';
            $secret_key = isset($cashfree->cashfree_secret_key) && !empty($cashfree->cashfree_secret_key) ? $cashfree->cashfree_secret_key : '';

            $client = new Client();

            $orderData = [
                'order_id' => 'order_' . time(),
                'order_amount' => $price,
                'order_currency' => $currency,
                'customer_details' => [
                    'customer_id' => 'cust_' . time(),
                    'customer_email' => !empty($payment['email']) ? $payment['email'] : $u_info['email'],
                    'customer_phone' => !empty($payment['phone']) ? $payment['phone'] : '9999999999',
                ],
                'order_meta' => [
                    'return_url' => base_url("user_payment/cashfree?order_id={order_id}&slug={$slug}"),
                ]
            ];

            $response = $client->request('POST', $apiEndpoint, [
                'json' => $orderData,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-api-version' => '2022-09-01',
                    'x-client-id' => $appId,
                    'x-client-secret' => $secret_key
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['payment_session_id'])) {
                $data['payment_session_id'] = $result['payment_session_id'];
                $data['app_id'] = $appId;
                return $data;
            } else {
                // Handle error
                echo json_encode($result);
            }
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
    }




    public function paytm_init($slug = '')
    {
        $data = [];
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);
        $paytm = json_decode($u_info['paytm_config']);
        $data['order_id'] = 'order_12389' . time();
        $environment = $paytm->is_paytm_live;
        if ($environment == 0) {
            $data['url'] = 'https://securegw-stage.paytm.in';
        } else {
            $data['url'] = 'https://securegw.paytm.in';
        }


        $callback_url = base_url('user_payment/paytm_verify?slug=' . $u_info['username'] . '&key=' . $paytm->merchant_key);


        $params = array(
            'order_id' => $data['order_id'],
            'mid' => $paytm->merchant_id,
            'mik' => $paytm->merchant_key,
            'is_paytm_live' => $environment,
            'username' => $slug,
            'callback_url' => $callback_url,
            'price' => round(auth('payment')['total']),
        );
        $token = $this->token($params);
        $data['token'] = $token['body']['txnToken'];
        return $data;
    }

    public function token($data)
    {

        /*
    * import checksum generation utility
    * You can get this utility from https://developer.paytm.com/docs/checksum/
    */
        require_once("vendor/paytm/paytmchecksum/PaytmChecksum.php");

        $paytmParams = array();

        $paytmParams["body"] = array(
            "requestType"  => "Payment",
            "mid"  => $data['mid'],
            "websiteName"  => "WEBSTAGING",
            "orderId"  => $data['order_id'],
            "callbackUrl"  => $data['callback_url'],
            "txnAmount"   => array(
                "value"   => $data['price'],
                "currency" => "INR",
            ),
            "userInfo"   => array(
                "custId"  => "CUST_001",
            ),
        );


        /*
    * Generate checksum by parameters we have in body
    * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
    */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $data['mik']);

        $paytmParams["head"] = array(
            "signature" => $checksum
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
        if ($data['is_paytm_live'] == 0):
            /* for Staging */
            $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid={$data['mid']}&orderId={$data['order_id']}";
        else:
            /* for Production */
            $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid={$data['mid']}&orderId={$data['order_id']}";
        endif;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

        $response = curl_exec($ch);
        return json_decode($response, true);
    }

    /*----------------------------------------------
		MERCADOPAGO
----------------------------------------------*/

    public function mercado_init($slug)
    {
        $data = [];
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);

        $settings = settings();
        $mercado = !empty($u_info['mercado_config']) ? json_decode($u_info['mercado_config']) : '';

        MercadoPago\SDK::setAccessToken($mercado->access_token);
        $preference = new MercadoPago\Preference();
        // Create a preference item
        $item = new MercadoPago\Item();
        $item->title = auth('payment')['name'];
        $item->quantity = 1;
        $item->unit_price = auth('payment')['total'];
        $item->currency_id = $u_info['currency_code'];
        $preference->items = array($item);

        $preference->back_urls = array(
            "success" => base_url("user_payment/mercado?slug={$slug}"),
            "failure" => base_url("user_payment/mercado?slug={$slug}"),
            "pending" => base_url("user_payment/mercado?slug={$slug}")
        );
        $preference->auto_return = "approved";

        $preference->save();
        $data['f_id'] = $preference->id;
        $data['init'] = $preference->init_point;
        return $data;
    }

    /*----------------------------------------------
    FLUTTERWAVE
----------------------------------------------*/
    public function flutterwave_init($slug)
    {

        $u_info = $this->admin_m->get_restaurant_info_slug($slug);
        $flutterwave = json_decode($u_info['flutterwave_config']);
        $data = [];
        $data['sandbox'] = $flutterwave->is_flutterwave_live == 1 ? FALSE : TRUE; //TRUE for Sandbox - FALSE for live environment

        // Flutter Wave API endpoints for Sandbox & Live
        $data['payment_endpoint'] = ($data['sandbox']) ? 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/hosted/pay' : 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay';
        $data['verify_endpoint'] = ($data['sandbox']) ? 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify' : 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify';

        /* datauration stars from here */
        // Flutter Wave Credentials 
        $data['PBFPubKey'] = ($data['sandbox']) ? $flutterwave->fw_public_key : $flutterwave->fw_public_key; /* Public Key for Sandbox : Live */
        $data['SECKEY'] = ($data['sandbox']) ? $flutterwave->fw_secret_key : $flutterwave->fw_secret_key; /* Secret Key for Sandbox : Live */
        $data['encryption_key'] = ($data['sandbox']) ? $flutterwave->encryption_key  : $flutterwave->encryption_key; /* Encryption Key for Sandbox : Live */

        // Webhook Secret Hash 
        $data['secret_hash'] = ($data['sandbox']) ? 'TEST_SECRET_HASH' : 'LIVE_SECRET_HASH$'; /* Secret HASH for Sandbox : Live */

        // What is the default currency?
        // $data['currency'] = 'USD';  /* Store Currency Code */
        $data['currency'] = !empty($u_info['currency_code']) ? $u_info['currency_code'] : 'NGN';  /* Store Currency Code */

        // Transaction Prefix if any
        $data['txn_prefix'] = 'TXN_PREFIX';  /* Transaction ID Prefix if any */

        $data['payment_url'] = $data['payment_endpoint'];
        $data['verify_url'] = $data['verify_endpoint'];
        $data['PBFPubKey'] = $data['PBFPubKey'];
        $data['SECKEY'] = $data['SECKEY'];
        $data['currency'] = $data['currency'];
        $data['txn_prefix'] = $data['txn_prefix'];


        return $data;
    }



    public function verify_flutterwave()
    {
        $data = $_GET;

        if (count($data) == 0) {
            echo __('error_msg');
        };
        if (isset($data['transaction_id']) || isset($data['tx_ref'])) {
            $transactionId = $data['transaction_id'] ?? null;
            $tx_ref = $data['tx_ref'] ?? null;

            try {

                $history = new Transactions();
                $data = array("id" => $transactionId);
                $verifyTransaction = $history->verifyTransaction($transactionId);
                return $verifyTransaction;
            } catch (\Exception $e) {

                return $e->getMessage();;
            }
        }
    }

    public function netseasy_init($slug, $amount)
    {
        $data = [];
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);
        $netseasy = isJson($u_info['netseasy_config']) ? json_decode($u_info['netseasy_config']) : '';
        $ref = 'netseasy_124' . time();
        $price = $amount * 100;
        $currency = $u_info['currency_code'];
        $checkout = json_encode([
            'checkout' => [
                "integrationType" => "EmbeddedCheckout",
                'url' => base_url('payment/netseasy'),
                // 'returnUrl' => 'https://qmenu.thinincode.net/checkout',
                'termsUrl' => base_url("terms-conditions"), // Your terms
            ],
            'order' => [
                'currency' => $currency,
                'reference' => $ref,            // A unique reference for this specific order
                'amount' => $price,              // Total order amount in cents
                'slug' => $slug,
                'items' => [
                    [
                        'reference' => $ref . date('Y'),        // A unique reference for this specific item
                        'name' => $u_info['username'],
                        'quantity' => 1,
                        'unit' => 'pcs',
                        // 'unitPrice' => 5000,        // Price per unit except tax in cents
                        // 'taxRate' => 25000 ,         // Taxrate (e.g 25.0 in this case),
                        // 'taxAmount' => 2000   ,      // The total tax amount for this item in cents,
                        'grossTotalAmount' => $price, // Total for this item with tax in cents,
                        'netTotalAmount' => $price,   // Total for this item without tax in cents
                    ]
                ],
            ]
        ]);

        $payload = $checkout;
        assert(json_decode($payload) && json_last_error() == JSON_ERROR_NONE);
        $url = netseasyUrl($netseasy->is_netseasy_live)->url;
        $ch = curl_init("{$url}/v1/payments");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization:' . $netseasy->netseasy_secret_key
        ));

        $result = curl_exec($ch);
        $result = json_decode($result);
        return $result;
    }


    public function myfatoorah_init($slug = '')
    {
        $data = [];
        $settings = settings();
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);


        $myfatoorah = isJson($u_info['myfatoorah_config']) ? json_decode($u_info['myfatoorah_config']) : '';

        $payment = auth('payment');
        $price = $payment['total'];
        $currency = $u_info['currency_code'] ?? "KWD";

        $mfConfig = [
            'apiKey'      => isset($myfatoorah->myfatoorah_api_key) && !empty($myfatoorah->myfatoorah_api_key) ? $myfatoorah->myfatoorah_api_key : '',
            'vcCode' => isset($myfatoorah->vccode) && !empty($myfatoorah->vccode) ? $myfatoorah->vccode : 'KWT',
            'isTest'      => isset($myfatoorah->is_myfatoorah_live) && $myfatoorah->is_myfatoorah_live == 1 ? false : true,
        ];
        $invoiceValue       = $price;
        $displayCurrencyIso = $currency ?? "KWD";


        $postFields = [
            //Fill required data
            'InvoiceValue'       => $invoiceValue,
            'CustomerName'       => !empty($u_info['name']) ? $u_info['name'] : $u_info['username'] . ' ' . $u_info['username'],
            'NotificationOption' => 'LNK', //'SMS', 'EML', or 'ALL'
            'DisplayCurrencyIso' => $displayCurrencyIso,
            'CustomerEmail'      => !empty($payment['email']) ? $payment['email'] : $u_info['email'],
            'CallBackUrl'        => base_url('user_payment/myfatoorah/' . $slug),
            'ErrorUrl'           => base_url('user_payment/myfatoorah/' . $slug),
            'Language'           => 'en', //or 'ar'
            'CustomerReference'  => 'orderId',
        ];

        try {
            $mfObj = new MyFatoorahPayment($mfConfig);
            $data  = $mfObj->sendPayment($postFields);

            $invoiceId   = $data->InvoiceId;
            $paymentLink = $data->InvoiceURL;

            return ['payment_link' => $paymentLink, 'invoice_id' => $invoiceId];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function iyzico_init($slug = '')
    {
        $u_info = $this->admin_m->get_restaurant_info_slug($slug);


        $iyzico = isJson($u_info['iyzico_config']) ? json_decode($u_info['iyzico_config']) : '';
        $baseUrl = isset($iyzico->is_iyzico_live) && $iyzico->is_iyzico_live == 1 ? 'https://api.iyzipay.com' : 'https://sandbox-api.iyzipay.com';
        $payment = auth('payment');
        $price = $payment['total'];
        $currency = $u_info['currency_code'] ?? "TR";

        try {
            // Set Iyzipay API options
            $options = new \Iyzipay\Options();
            $options->setApiKey(isset($iyzico->iyzico_api_key) && !empty($iyzico->iyzico_api_key) ? $iyzico->iyzico_api_key : ''); // Use your sandbox API key
            $options->setSecretKey(isset($iyzico->iyzico_secret_key) && !empty($iyzico->iyzico_secret_key) ? $iyzico->iyzico_secret_key : ''); // Use your sandbox secret key
            $options->setBaseUrl($baseUrl);

            // Create a request for the Checkout Form initialization
            $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
            $request->setLocale(\Iyzipay\Model\Locale::TR);
            $request->setConversationId("123456789");
            $request->setPrice($price);
            $request->setPaidPrice($price);
            $request->setCurrency(\Iyzipay\Model\Currency::TL);
            $request->setBasketId(uniqid());
            $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);


            $session_data = $this->session->all_userdata();


            $csrf_token = $this->security->get_csrf_hash();
            $session_data['csrf_token'] = $csrf_token;

            // Encode session data
            $encoded_session_data = base64_encode(json_encode($session_data));

            $transaction_id = uniqid('user_trans_');

            $temp_dir = APPPATH . 'temp/';
            if (!file_exists($temp_dir)) {
                mkdir($temp_dir, 0755, true);
            }
            $temp_file = $temp_dir . $transaction_id . '.tmp';
            file_put_contents($temp_file, $encoded_session_data);


            $request->setCallbackUrl(base_url('user_payment/iyzico_callback?slug=' . $slug . '&transaction_id=' . $transaction_id)); // Replace with your callback URL

            // Set buyer information
            $buyer = new \Iyzipay\Model\Buyer();
            $buyer->setId(uniqid());
            $buyer->setName($u_info['username']);
            $buyer->setSurname($u_info['username']);
            $buyer->setGsmNumber("+905350000000");
            $buyer->setEmail($u_info['email']);
            $buyer->setIdentityNumber("74300864791");
            $buyer->setLastLoginDate("2015-10-05 12:43:35");
            $buyer->setRegistrationDate("2013-04-21 15:12:09");
            $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $buyer->setIp($this->input->ip_address());
            $buyer->setCity("Istanbul");
            $buyer->setCountry("Turkey");
            $buyer->setZipCode("34732");
            $request->setBuyer($buyer);

            // Set shipping address
            $shippingAddress = new \Iyzipay\Model\Address();
            $shippingAddress->setContactName("Jane Doe");
            $shippingAddress->setCity("Istanbul");
            $shippingAddress->setCountry("Turkey");
            $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $shippingAddress->setZipCode("34742");
            $request->setShippingAddress($shippingAddress);

            // Set billing address
            $billingAddress = new \Iyzipay\Model\Address();
            $billingAddress->setContactName("Jane Doe");
            $billingAddress->setCity("Istanbul");
            $billingAddress->setCountry("Turkey");
            $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $billingAddress->setZipCode("34742");
            $request->setBillingAddress($billingAddress);

            // Set basket items
            $basketItems = [];
            $firstBasketItem = new \Iyzipay\Model\BasketItem();
            $firstBasketItem->setId(random_string('numeric', 6));
            $firstBasketItem->setName("subscription");
            $firstBasketItem->setCategory1("subscription");
            $firstBasketItem->setCategory2("subscription");
            $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $firstBasketItem->setPrice($price);
            $basketItems[0] = $firstBasketItem;

            $request->setBasketItems($basketItems);

            $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $options);

            $checkoutFormContent = $checkoutFormInitialize->getCheckoutFormContent();

            return $checkoutFormContent;
        } catch (\Iyzipay\Exception\IyzipayException $e) {
            echo "Iyzipay Error: " . $e->getMessage();
        } catch (\Exception $e) {
            // Handle general PHP exceptions here
            echo "Error: " . $e->getMessage();
        }
    }
}

/* End of file Payment_m.php */
/* Location: ./application/models/Payment_m.php */