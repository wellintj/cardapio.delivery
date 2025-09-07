<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . "/vendor/flutterwavedev/flutterwave-v3/library/Transactions.php";

use Flutterwave\Transactions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

use MyFatoorah\Library\API\Payment\MyFatoorahPayment;



class Payment_m extends CI_Model
{

    public function paytm_init($slug = '', $account_slug = '', $type = 'admin')
    {
        $data = [];
        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $paytm = json_decode($settings['paytm_config']);
        $data['order_id'] = 'order_12389' . time();

        $is_paytm_live = 0;

        $environment = $paytm->is_paytm_live;
        if ($environment == 0) {
            $data['url'] = 'https://securegw-stage.paytm.in';
        } else {
            $data['url'] = 'https://securegw.paytm.in';
        }

        if ($type == 'admin') {
            $callback_url = base_url('payment/paytm_verify/?slug=' . $u_info['username'] . '&account_slug=' . $package['slug'] . '&key=' . $paytm->merchant_key);
        } else {
            $callback_url = "";
        }

        $params = array(
            'order_id' => $data['order_id'],
            'mid' => $paytm->merchant_id,
            'mik' => $paytm->merchant_key,
            'is_paytm_live' => $environment,
            'username' => $slug,
            'account_slug' => $account_slug,
            'callback_url' => $callback_url,
            'price' => temp('total_amount') ?? $package['price'],
        );
        $token = $this->token($params);
        $data['token'] = isset($token) ? $token['body']['txnToken'] : '';
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

    public function mercado_init($slug, $account_slug)
    {
        $data = [];
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $settings = settings();
        $mercado = !empty($settings['mercado_config']) ? json_decode($settings['mercado_config']) : '';

        MercadoPago\SDK::setAccessToken($mercado->access_token);
        $preference = new MercadoPago\Preference();

        // Create a preference item
        $item = new MercadoPago\Item();
        $item->title = $package['package_name'];
        $item->quantity = 1;
        $item->unit_price = temp('total_amount') ?? $package['price'];
        $item->currency_id = get_currency('currency_code');
        $preference->items = array($item);
        $preference->back_urls = array(
            "success" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}"),
            "failure" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}"),
            "pending" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}")
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

    public function verify_flutterwave()
    {
        $data = $_GET;


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

    public function pagadito_verify($env_data)
    {
        require_once(APPPATH . 'libraries/Pagadito.php');
        if (isset($_GET["token"]) && $_GET["token"] != "") {
            /*
         * Lo primero es crear el objeto Pagadito, al que se le pasa como
         * parámetros el UID y el WSK definidos en config.php
         */
            $Pagadito = new Pagadito($_ENV['UID'], $_ENV['WSK']);

            /*
         * Si se está realizando pruebas, necesita conectarse con Pagadito SandBox. Para ello llamamos
         * a la función mode_sandbox_on(). De lo contrario omitir la siguiente linea.
         */
            if ($_ENV['SANDBOX']) {
                $Pagadito->mode_sandbox_on();
            }


            /*
         * Validamos la conexión llamando a la función connect(). Retorna
         * true si la conexión es exitosa. De lo contrario retorna false
         */
            if ($Pagadito->connect()) {
                /*
             * Solicitamos el estado de la transacción llamando a la función
             * get_status(). Le pasamos como parámetro el token recibido vía
             * GET en nuestra URL de retorno.
             */
                if ($Pagadito->get_status($_GET["token"])) {
                    /*
                 * Luego validamos el estado de la transacción, consultando el
                 * estado devuelto por la API.
                 */
                    switch ($Pagadito->get_rs_status()) {


                        case "COMPLETED":
                            /*
                         * Tratamiento para una transacción exitosa.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $status = 'success';
                            $msgPrincipal = "Your purchase was successful";
                            $msg = "Paid Approval Number {$Pagadito->get_rs_reference()}";
                            $msgSecundario = '
                        Thank you for shopping with Pagadito.<br />
                        NAP (Paid Approval Number): <label class="respuesta">' . $Pagadito->get_rs_reference() . '</label><br />
                        Fecha Respuesta: <label class="respuesta">' . $Pagadito->get_rs_date_trans() . '</label><br /><br />';
                            return ['status' => $status, 'msg' => $msg, 'details' => $Pagadito];
                            break;

                        case "REGISTERED":

                            /*
                         * Tratamiento para una transacción aún en
                         * proceso.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $msgPrincipal = "Attention";
                            $msgSecundario = "The transaction was canceled.<br /><br />";
                            $status = 'cancled';
                            $msg = "The transaction was canceled";
                            return ['status' => $status, 'msg' => $msg];
                            break;

                        case "VERIFYING":

                            /*
                         * La transacción ha sido procesada en Pagadito, pero ha quedado en verificación.
                         * En este punto el cobro xha quedado en validación administrativa.
                         * Posteriormente, la transacción puede marcarse como válida o denegada;
                         * por lo que se debe monitorear mediante esta función hasta que su estado cambie a COMPLETED o REVOKED.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $msgPrincipal = "Atenci&oacute;n";
                            $msgSecundario = '
                            Your payment is ready. in validation.<br />
                            NAP (Paid Approval Number): <label class="respuesta">' . $Pagadito->get_rs_reference() . '</label><br />
                            Fecha Respuesta: <label class="respuesta">' . $Pagadito->get_rs_date_trans() . '</label><br /><br />';
                            $status = 'pending';
                            $msg = "Your payment is ready. in validation";
                            return ['status' => $status, 'msg' => $msg];
                            break;

                        case "REVOKED":

                            /*
                         * La transacción en estado VERIFYING ha sido denegada por Pagadito.
                         * En este punto el cobro ya ha sido cancelado.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $msgPrincipal = "Atenci&oacute;n";
                            $msgSecundario = "La transacci&oacute;n fue denegada.<br /><br />";
                            return ['status' => 'revoked', 'msg' => $msgSecundario];
                            break;

                        case "FAILED":
                            /*
                         * Tratamiento para una transacción fallida.
                         */
                            return ['status' => 'failed', 'msg' => 'Transaction Failed'];
                        default:

                            /*
                         * Por ser un ejemplo, se muestra un mensaje
                         * de error fijo.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $msgPrincipal = "Atenci&oacute;n";
                            $msgSecundario = "La transacci&oacute;n no fue realizada.<br /><br />";
                            return ['status' => 'failed', 'msg' => 'La transacci&oacute;n no fue realizada'];
                            break;
                    }
                } else {
                    /*
                 * En caso de fallar la petición, verificamos el error devuelto.
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
                        default:
                            /*
                         * Por ser un ejemplo, se muestra un mensaje
                         * de error fijo.
                         */ ///////////////////////////////////////////////////////////////////////////////////////////////////////
                            $msgPrincipal = "Error en la transacci&oacute;n";
                            $msgSecundario = "La transacci&oacute;n no fue completada.<br /><br />";
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
                        /*
                     * Aqui se muestra el código y mensaje de la respuesta del WSPG
                     */
                        $msgPrincipal = "Respuesta de Pagadito API";
                        $msgSecundario = "
                    COD: " . $Pagadito->get_rs_code() . "<br />
                    MSG: " . $Pagadito->get_rs_message() . "<br /><br />";
                        break;
                }
            }
        } else {
            /*
         * Aqui se muestra el mensaje de error al no haber recibido el token por medio de la URL.
         */
            $msgPrincipal = "Atenci&oacute;n";
            $msgSecundario = "No se recibieron los datos correctamente.<br /> La transacci&oacute;n no fue completada.<br /><br />";
        }
    }

    public function netseasy_init($slug = '', $account_slug = '', $type = 'admin')
    {
        $data = [];
        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $netseasy = isJson($settings['netseasy_config']) ? json_decode($settings['netseasy_config']) : '';
        $ref = 'netseasy_123' . time();
        $price = temp('total_amount') ?? $package['price'] * 100;
        $currency = get_currency('currency_code');
        $checkout = json_encode([
            'checkout' => [
                "integrationType" => "EmbeddedCheckout",
                'url' => base_url('payment/netseasy'),
                'termsUrl' => base_url("terms-conditions"), // Your terms
            ],
            'order' => [
                'currency' => $currency,
                'reference' => $ref,            // A unique reference for this specific order
                'amount' => $price,
                'items' => [
                    [
                        'reference' => $ref . date('Y'),        // A unique reference for this specific item
                        'name' => $settings['site_name'],
                        'quantity' => 1,
                        'unit' => 'pcs',
                        'grossTotalAmount' => $price, // Total for this item with tax in cents,
                        'netTotalAmount' => $price,   // Total for this item without tax in cents
                    ]
                ],
            ]
        ]);



        $curl = curl_init();
        $url = netseasyUrl($netseasy->is_netseasy_live)->url;
        curl_setopt_array($curl, [
            CURLOPT_URL => "{$url}/v1/payments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $checkout,
            CURLOPT_FAILONERROR => true,
            CURLOPT_HTTPHEADER => [
                "Authorization:{$netseasy->netseasy_secret_key}",
                "CommercePlatformTag: testfsdfasdfsfasf54612315656",
                "content-type: application/*+json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

    public function midtrans_init($slug = '', $account_slug = '', $type = 'admin')
    {


        $data = [];
        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $midtrans = isJson($settings['midtrans_config']) ? json_decode($settings['midtrans_config']) : '';

        $price = temp('total_amount') ?? $package['price'];
        $currency = get_currency('currency_code');


        \Midtrans\Config::$serverKey = isset($midtrans->server_key) ? $midtrans->server_key : '';
        \Midtrans\Config::$isProduction = isset($midtrans->is_midtrans_live) && $midtrans->is_midtrans_live == 1 ? true : false; // Set to true for production
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;


        $order_id = 'ORDER-' . time();

        $transaction_details = array(
            'order_id' => $order_id,
            'gross_amount' => round($price), // Amount in cents
            'currency' => $currency ?? 'IDR' // Specify the currency
        );

        $items = array(
            array(
                'id' => $package['id'],
                'price' => round($price),
                'quantity' => 1,
                'name' => $package['package_name'] ?? '',
            )
        );

        $customer_details = array(
            'first_name' => $u_info['username'] ?? '',
            'last_name' => $u_info['username'] ?? '',
            'email' => $u_info['email'] ?? '',
            'phone' => $u_info['phone'] ?? ''
        );

        $transaction = array(
            'transaction_details' => $transaction_details,
            'item_details' => $items,
            'customer_details' => $customer_details
        );

        // This is where you set the finish_redirect_url
        $transaction['custom_field1'] = base_url("payment/midtrans/{$slug}/{$account_slug}/{$order_id}");
        $transaction['custom_field2'] = $order_id;
        $transaction['package_slug'] = $account_slug;
        $transaction['slug'] = $slug;

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            return  $snapToken;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function cashfree_init($slug = '', $account_slug = '', $type = 'admin')
    {
        $data = [];
        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $cashfree = isJson($settings['cashfree_config']) ? json_decode($settings['cashfree_config']) : '';

        $price = temp('total_amount') ?? $package['price'];
        $currency = get_currency('currency_code');

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
                    'customer_email' => 'customer@example.com',
                    'customer_phone' => '9999999999'
                ],
                'order_meta' => [
                    'return_url' => base_url("payment/cashfree?order_id={order_id}&slug={$slug}&account_slug={$account_slug}"),
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


    public function myfatoorah_init($slug = '', $account_slug = '', $type = 'admin')
    {
        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $myfatoorah = isJson($settings['myfatoorah_config']) ? json_decode($settings['myfatoorah_config']) : '';

        $price = temp('total_amount') ?? $package['price'];
        $currency = get_currency('currency_code');
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
            'CustomerEmail'      => !empty($u_info['email']) ? $u_info['email'] : 'email@example.com',
            'CallBackUrl'        => base_url('payment/myfatoorah/?slug=' . $slug . '&account_slug=' . $account_slug),
            'ErrorUrl'           => base_url('payment/myfatoorah/?slug=' . $slug . '&account_slug=' . $account_slug),
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
            die;
        }
    }

    public function iyzico_init($slug = '', $account_slug = '', $type = 'admin')
    {
        $settings = settings();
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);
        $iyzico = isJson($settings['iyzico_config']) ? json_decode($settings['iyzico_config']) : '';

        $baseUrl = isset($iyzico->is_iyzico_live) && $iyzico->is_iyzico_live == 1 ? 'https://api.iyzipay.com' : 'https://sandbox-api.iyzipay.com';

        $price = temp('total_amount') ?? $package['price'];
        $currency = get_currency('currency_code');

        try {
            // Set Iyzipay API options
            $options = new \Iyzipay\Options();
            $options->setApiKey(isset($iyzico->iyzico_api_key) && !empty($iyzico->iyzico_api_key) ? $iyzico->iyzico_api_key : '');
            $options->setSecretKey(isset($iyzico->iyzico_secret_key) && !empty($iyzico->iyzico_secret_key) ? $iyzico->iyzico_secret_key : '');
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
            $session_data['use_payment'] = 0;
            $session_data['payment'] = [];

            // Encode session data
            $encoded_session_data = base64_encode(json_encode($session_data));

            $transaction_id = uniqid('trans_');

            $temp_dir = APPPATH . 'temp/';
            if (!file_exists($temp_dir)) {
                mkdir($temp_dir, 0755, true);
            }
            $temp_file = $temp_dir . $transaction_id . '.tmp';
            file_put_contents($temp_file, $encoded_session_data);


            $callback_url = base_url('payment/iyzico_callback?slug=' . $slug . '&account_slug=' . $account_slug . '&transaction_id=' . $transaction_id);
            $request->setCallbackUrl($callback_url);


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
            log_message('error', "Iyzipay Error: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            log_message('error', "Error: " . $e->getMessage());
            return false;
        }
    }
}
