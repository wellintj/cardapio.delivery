<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User_email_m extends CI_Model
{
    public $env;
    public function __construct()
    {
        // parent::__construct();
        $this->env =  isset(__env()->is_development) ? __env()->is_development : 0;
    }
    protected function send_mail($id, $data)
    {
        $settings = $this->common_m->get_user_settings($id);
        $smtp = !empty($settings['smtp_config']) ? json_decode(@$settings['smtp_config']) : '';

        $mail_type = !empty($settings['email_type']) ? $settings['email_type'] : 1;

        $sendgrid = !empty($settings['sendgrid_api_key']) ? $settings['sendgrid_api_key'] : '';
        $mailtrap_api_key = isset($smtp->mailtrap_api_key) && !empty($smtp->mailtrap_api_key) ? $smtp->mailtrap_api_key : '';
        $mail_from = $settings['smtp_mail'];

        $shop = $this->admin_m->my_restaurant_info($id);
        $site_name = !empty($shop->name) ? $shop->name : $shop->username;
        $mail_to = $data['mail_to'];
        if ($mail_type == 2) :
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  //Enable verbose debug output
                $mail->isSMTP();                         //Send using SMTP
                $mail->Host       = !empty($smtp->smtp_host) ? $smtp->smtp_host : 'smtp.gmail.com'; //Set the SMTP server to send through
                $mail->SMTPAuth   = true; //Enable SMTP authentication
                $mail->Username   = $mail_from; //SMTP username
                $mail->Password   = base64_decode($smtp->smtp_password); //SMTP password
                $mail->SMTPSecure = $smtp->smtp_port == 465 || $smtp->smtp_port == 25 ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption

                $mail->Port       = !empty($smtp->smtp_port) ? $smtp->smtp_port : 465;
                //587 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($mail_from, $site_name);

                if ($data['type'] == 2) :
                    foreach (array_unique($mail_to) as $key => $value) {
                        $mail->addAddress($value, $site_name);
                    }

                else :
                    $mail->addAddress($mail_to, $site_name);
                endif;


                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                //Content
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body    = $data['msg'];
                $mail->AltBody = '';
                $mail->CharSet = 'UTF-8';
                if (!empty($data['msg'])) :
                    $mail->send();
                endif;
                return true;
            } catch (Exception $e) {
                if ($this->env == 1) :
                    return $e->getMessage();
                endif;
                return false;
            }

        elseif ($mail_type == 3) :
            require 'vendor/autoload.php';

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($mail_from, $site_name);
            $email->setSubject($data['subject']);

            if ($data['type'] == 2) :
                foreach (array_unique($mail_to) as $key => $value) {
                    $email->addTo($value, $site_name);
                }
            else :
                $email->addTo($mail_to, $site_name);
            endif;



            $email->addContent("text/html", $data['msg']);
            $sendgrid = new \SendGrid($sendgrid);

            try {
                $response = $sendgrid->send($email);
                if ($response->statusCode() == 202) {
                    return true;
                } else {
                    if ($this->env == 1) :
                        print $response->statusCode() . "\n" . "<br/>";
                        print_r($response->headers());
                        print $response->body() . "\n" . "<br/>";
                        exit();
                    endif;
                    return false;
                }
            } catch (Exception $e) {
                echo "<pre>";
                print_r($e);
                exit();
            }

        else :

            $config = array(
                'protocol' => 'mail',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );
            $this->email->initialize($config);
            $this->email->from('demotestnm@gmail.com', 'Your Name'); // Change to your email and name
            $this->email->to('phplime.envato@gmail.com'); // Change to the recipient's email
            $this->email->subject('Test Email');
            $this->email->message('<p>This is a test email sent using PHP\'s mail() function in CodeIgniter 3.</p>');

            // Send the email
            if ($this->email->send()) {
                echo 'Email sent successfully!';
            } else {
                echo 'Failed to send email.';
                echo $this->email->print_debugger();
            }
        endif;
    }


    public function test_mail($id)
    {
        $settings = $this->admin_m->get_user_settings($id);
        $smtp = !empty($settings['smtp_config']) ? json_decode(@$settings['smtp_config']) : '';
        $mail_type = !empty($settings['email_type']) ? $settings['email_type'] : 1;
        $sendgrid = !empty($settings['sendgrid_api_key']) ? $settings['sendgrid_api_key'] : '';
        $mailtrap_api_key = isset($smtp->mailtrap_api_key) && !empty($smtp->mailtrap_api_key) ? $smtp->mailtrap_api_key : '';


        $mail_from = $settings['smtp_mail'];
        $shop = $this->admin_m->my_restaurant_info($id);
        $site_name = !empty($shop->name) ? $shop->name : $shop->username;
        $mail_to = $mail_from;

        if ($mail_type == 2) :
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings

                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = !empty($smtp->smtp_host) ? $smtp->smtp_host : 'smtp.gmail.com';                      //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $mail_from;                     //SMTP username
                $mail->Password   = base64_decode($smtp->smtp_password);                               //SMTP password
                $mail->SMTPSecure = $smtp->smtp_port == 465 || $smtp->smtp_port == 25 ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;;            //Enable implicit TLS encryption
                $mail->Port       = !empty($smtp->smtp_port) ? $smtp->smtp_port : 465;
                //587 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($mail_from, $site_name);
                $mail->addAddress($mail_to, $site_name);

                //Add a recipient
                // $mail->addAddress('ellen@example.com');               //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Test Mail';
                $mail->Body    = 'Mail testing.... Mail working fine';
                $mail->AltBody = '';

                $mail->send();
                echo '<h4 style="margin-top:20px; color:green;">Message has been sent & working fine</h4>';
            } catch (Exception $e) {
                echo "<h4 style='margin-top:20px; color:red;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </h4>";
            }

        elseif ($mail_type == 3) :
            require 'vendor/autoload.php';

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($mail_from, $site_name);
            $email->setSubject("Text mail using SendGrid");
            $email->addTo($mail_from, $site_name);
            $email->addContent("text/html", "Text mail using SendGrid welcome to {$site_name} script");
            $sendgrid = new \SendGrid($sendgrid);

            try {
                $response = $sendgrid->send($email);
                print $response->statusCode() . "\n" . "<br/>";
                print_r($response->headers());
                print $response->body() . "\n" . "<br/>";
            } catch (Exception $e) {
                echo "<pre>";
                print_r($e);
                exit();
            }
        else :
            $config = array(
                'protocol' => 'mail',
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );
            $this->email->initialize($config);
            $this->email->from('demotestnm@gmail.com', 'Your Name'); // Change to your email and name
            $this->email->to('phplime.envato@gmail.com'); // Change to the recipient's email
            $this->email->subject('Test Email');
            $this->email->message('<p>This is a test email sent using PHP\'s mail() function in CodeIgniter 3.</p>');

            // Send the email
            if ($this->email->send()) {
                echo 'Email sent successfully!';
            } else {
                echo 'Failed to send email.';
                echo $this->email->print_debugger();
            }
        endif;
    }

    public function send_reservation_mail($order_id, $status = 1)
    {
        $order_details = $this->admin_m->single_select_by_uid_row($order_id, 'order_user_list');
        $shop_info = $this->common_m->get_restaurant_info_by_id($order_details->shop_id);
        $settings = $this->common_m->get_user_settings($shop_info['user_id']);


        $shop_id = $shop_info['shop_id'];

        $mail_config = isJson($settings['order_mail_config']) ? json_decode(@$settings['order_mail_config']) : '';
        if (isset($mail_config->is_order_mail) && $mail_config->is_order_mail == 1) :


            $data = '';

            $data .= '
        <style rel="stylesheet">
        body{
            margin: 0 auto;
        }
        ul.itemList {
            padding: 0;
            margin: 0;
            list-style: none;
            border-bottom: 1px dashed;
        }

        ul.itemList li {
            padding: 5px;
            margin-bottom: 2px;
            margin-left:0;
        }

        ul.toatalArea {
            padding: 0;
            list-style: none;
            text-transform: capitalize;
        }

        ul.toatalArea li {
            padding: 3px 5px;
            margin-left:0;
        }
        .gs li{
            margin-left:0;
        }
        </style>

        ';
            if ($order_details->is_table == 1) {
                $is_table = lang('yes');
            } else {
                $is_table = lang('no');
            }
            $reservationType = single($order_details->reservation_type, 'reservation_types')->name ?? "";
            $data .= '<ul class="itemList" style="list-style:none;padding:0;margin:0;text-transform: capitalize;">';
            $i = 1;
            $data .= "<li>" . lang('name') . " : \t " . "<strong>" . $order_details->name . " </strong> </li>";
            $data .= "<li>" . lang('email') . " : \t " . "<strong>" . $order_details->email . " </strong> </li>";
            $data .= "<li>" . lang('phone') . " : \t " . "<strong>" . $order_details->phone . " </strong> </li>";

            $data .= "<li>" . lang('reservation_type') . " : \t " . "<strong>" . $reservationType . " </strong> </li>";

            $data .= "<li>" . lang('reservation_date') . " : \t " . "<strong>" . full_date($order_details->reservation_date) . " </strong> </li>";

            $data .= "<li>" . lang('table_reservation') . " : \t " . "<strong>" . $is_table . " </strong> </li>";


            $data .= "<li>" . lang('number_of_guest') . " : \t " . "<strong>" . $order_details->total_person . " </strong> </li>";
            if (!empty($order_details->comments)) {
                $data .= "<li>" . lang('any_special_request') . " : \t " . "<strong>" . $order_details->comments . " </strong> </li>";
            }
            $data .= '</ul>';

            $data .= '<ul class="toatalArea" style="list-style:none;padding:0;text-transform: capitalize;">';
            $data .= "\n -------------------------------------------- \n";
            if ($order_details->status == 0) :
                if ($order_details->is_confirm == 1) {
                    $data .= "<li>" . lang('status') . " : \t " . "<strong>" . lang('confirmed') . " </strong> </li>";
                } else {
                    $data .= "<li>" . lang('status') . " : \t " . "<strong>" . lang('reservation_placed_successfully') . " </strong> </li>";
                }
            elseif ($order_details->status == 1) :
                $data .= "<li>" . lang('status') . " : \t " . "<strong>" . lang('accepted') . " </strong> </li>";
            elseif ($order_details->status == 2) :
                $data .= "<li>" . lang('status') . " : \t " . "<strong>" . lang('completed') . " </strong> </li>";
            elseif ($order_details->status == 3) :
                $data .= "<li>" . lang('status') . " : \t " . "<strong>" . lang('cancled') . " </strong> </li>";
            endif;
            $data .= '</ul>';



            $replace_data = array(
                '{CUSTOMER_NAME}' => $order_details->name,
                '{ORDER_ID}' => $order_id,
                '{RESERVATION_DETAILS}' => $data,
                '{SHOP_NAME}' => $shop_info['shop_name'],
                '{SHOP_ADDRESS}' => $shop_info['address'],
            );

            $accept_message = json_decode(@$mail_config->reservation_message);
            $msg = create_msg($replace_data, $accept_message);


            if ($status == 0) :
                if (isset($mail_config->is_rev_owner_mail) && $mail_config->is_rev_owner_mail == 1) :
                    $mail_info = ['msg' => $msg, 'subject' => @$mail_config->rev_subject ?? '', 'type' => 1, 'mail_to' => $mail_config->order_receiver_mail];
                    $send = $this->send_mail($shop_info['user_id'], $mail_info);
                endif;

                //welcome mail
                $welcome_message = json_decode(@$mail_config->welcome_reservation_message);
                $welcomeMsg = create_msg($replace_data, $welcome_message);

                if (isset($mail_config->is_rev_customer_mail)  && $mail_config->is_rev_customer_mail == 1) :
                    if (isset($order_details->email) && !empty($order_details->email)) :
                        $mail_info = ['msg' => $welcomeMsg, 'subject' => @$mail_config->rev_subject ?? '', 'type' => 3, 'mail_to' => $order_details->email];
                        $send = $this->send_mail($shop_info['user_id'], $mail_info);
                    endif;
                endif;

            endif;

            if ($status != 0) :
                if (isset($mail_config->is_rev_customer_mail) && $mail_config->is_rev_customer_mail == 1) :
                    if (isset($order_details->email) && !empty($order_details->email)) :
                        $mail_info = ['msg' => $msg, 'subject' => @$mail_config->rev_subject ?? '', 'type' => 3, 'mail_to' => $order_details->email];
                        $send = $this->send_mail($shop_info['user_id'], $mail_info);
                    endif;
                endif;

            endif;



            if (isset($send) && $send == TRUE) {
                return true;
            } else {
                return false;
            }
        else :
            return true;
        endif;
    }


    public function custom_mail($id, $data = [])
    {
        $settings = $this->common_m->get_user_settings($id);

        $mail_info = [
            'msg' => $data['message'] ?? '',
            'subject' => $data['subject'] ?? '',
            'type' => 1,
            'mail_to' => $data['email'],
        ];

        $send = $this->send_mail($id, $mail_info);
        echo '<pre>';
        print_r($send);
        exit();
        if (isset($send) && $send == TRUE) {
            return true;
        } else {
            return false;
        }
    }







    public function send_order_mail($order_id, $status = 1)
    {
        $order_details = $this->admin_m->single_select_by_uid_row($order_id, 'order_user_list');
        $shop_info = $this->common_m->get_restaurant_info_by_id($order_details->shop_id);
        $settings = $this->common_m->get_user_settings($shop_info['user_id']);
        $order_list = $this->common_m->get_order_item($order_details->id, $shop_info['shop_id']);

        $mail_config = isJson($settings['order_mail_config']) ? json_decode(@$settings['order_mail_config']) : '';

        if (isset($mail_config->is_order_mail) && $mail_config->is_order_mail == 1) :

            $p =  __order((array)$order_details, (array)$order_list);
            $shop_id = $shop_info['shop_id'];



            if ($shop_info['is_area_delivery'] == 1) :
                $delivery_charge = $p->shipping;
            else :
                if ($shop_info['delivery_charge_in'] != 0) {
                    $delivery_charge = $p->shipping;
                } else {
                    $delivery_charge = lang('free');
                };
            endif;




            $data = '';

            $data .= '
        <style rel="stylesheet">
        body{
            margin: 0 auto;
        }
        ul.itemList {
            padding: 0;
            margin: 0;
            list-style: none;
            border-bottom: 1px dashed;
        }

        ul.itemList li {
            padding: 5px;
            margin-bottom: 2px;
            margin-left:0;
        }

        ul.toatalArea {
            padding: 0;
            list-style: none;
            text-transform: capitalize;
        }

        ul.toatalArea li {
            padding: 3px 5px;
            margin-left:0;
        }
        .gs li{
            margin-left:0;
        }
        </style>

        ';

            $data .= '<ul class="itemList" style="list-style:none;padding:0;margin:0;text-transform: capitalize;">';
            $i = 1;
            foreach ($order_list as $key => $row) :
                if ($row['is_package'] == 1) :
                    $data .= '<li>' . $i . ". {$row['package_name']} ------------- {$row['qty']} x " . wh_currency_position($row['item_price'], $shop_id) . "</li>";

                else :

                    $data .= '<li>' . $i . ". {$row['name']} ----------- {$row['qty']} x " . wh_currency_position($row['item_price'], $shop_id) . "</li>";

                endif;


                $i++;
            endforeach;
            $data .= '</ul>';

            $data .= '<ul class="toatalArea" style="list-style:none;padding:0;text-transform: capitalize;">';

            $data .= "<li>" . lang('sub_total') . "\t : " . wh_currency_position($p->subtotal, $shop_id) . "</li>";

            if ($order_details->order_type == 1) :
                $data .= "<li>" . lang('shipping') . "\t : " . wh_currency_position($delivery_charge, $shop_id) . "</li>";
            endif;



            if (!empty($p->tax_details)) :
                foreach ($p->tax_details as  $key => $tax) :
                    $data .= "<li>" . lang("tax") . " " . tax($tax['percent'], $tax['tax_status']) . " \t \t: " . wh_currency_position($tax['total_price'], $shop_id) . "</li>";
                endforeach;
            else :
                if (!empty($p->tax_fee)) :
                    $data .= "<li>" . lang('tax') . " \t \t: " . wh_currency_position($p->tax_fee, $shop_id) . "</li>";
                endif;
            endif;

            if ($p->tips != 0) :
                $data .= "<li>" . lang('tips') . "\t : " . wh_currency_position($p->tips, $shop_id) . "</li>";
            endif;


            if ($p->discount != 0) :
                $data .= "<li>" . lang('discount') . "\t : " . wh_currency_position($p->discount, $shop_id) . "</li>";
            endif;

            if ($p->coupon_discount != 0) :
                $data .= "<li>" . lang('coupon_discount') . "\t : " . wh_currency_position($p->coupon_discount, $shop_id) . "</li>";
            endif;


            $data .= "<li class='grand_total'>";
            $data .= "<strong>" . lang('total') . " : \t " . "" . wh_currency_position($p->grand_total, $shop_id) . " </strong>";
            $data .= "</li>";

            if ($order_details->is_payment == 1 && !empty($order_details->payment_by)) :
                $data .= "<li>" . lang('payment_by') . " : \t " . "" . $order_details->payment_by . " </li>";
            endif;

            $data .= "\n -------------------------------------------- \n";
            if ($order_details->status == 0) :
                $data .= "<li>" . lang('order_status') . " : \t " . "<strong>" . lang('order_placed_successfully') . " </strong> </li>";
            elseif ($order_details->status == 1) :
                $data .= "<li>" . lang('order_status') . " : \t " . "<strong>" . lang('accepted') . " </strong> </li>";
            elseif ($order_details->status == 2) :
                $data .= "<li>" . lang('order_status') . " : \t " . "<strong>" . lang('completed') . " </strong> </li>";
            elseif ($order_details->status == 3) :
                $data .= "<li>" . lang('order_status') . " : \t " . "<strong>" . lang('cancled') . " </strong> </li>";
            endif;
            $data .= '</ul>';

            $invoice_link = url('invoice/' . $shop_info['username'] . '/' . $order_details->uid);
            $data .= "<a href='{$invoice_link}'>" . lang('invoice') . "</a>";

            if (isset($mail_config->is_customer_mail) && $mail_config->is_customer_mail == 1) :
                $track_url = base_url('my-orders/' . $shop_info['username'] . '?phone=' . $order_details->phone . '&orderId=' . $order_id);
            else :
                $track_url = '#';
            endif;

            $replace_data = array(
                '{CUSTOMER_NAME}' => $order_details->name,
                '{ORDER_ID}' => $order_id,
                '{ITEM_LIST}' => $data,
                '{SHOP_NAME}' => $shop_info['shop_name'],
                '{SHOP_ADDRESS}' => $shop_info['address'],
                '{TRACK_URL}' => $track_url,
            );

            if (!empty($mail_config->message)) {
                $accept_message =  json_decode($mail_config->message);
                $msg = create_msg($replace_data, $accept_message);
            } else {
                $msg = '';
            }

            if (!empty($mail_config->welcome_mail)) {
                $welcome_message =  json_decode($mail_config->welcome_mail);
                $welcomeMsg = create_msg($replace_data, $welcome_message);
            } else {
                $welcomeMsg = '';
            }



            if (in_array($status, [0, 1, 2, 3])) :

                if ($status == 0) :
                    if (isset($mail_config->is_owner_mail) && $mail_config->is_owner_mail == 1) :
                        $mail_info = ['msg' => $msg, 'subject' => @$mail_config->subject, 'type' => 1, 'mail_to' => $mail_config->order_receiver_mail];

                        $send = $this->send_mail($shop_info['user_id'], $mail_info);
                    endif;

                    if (isset($mail_config->is_customer_mail, $mail_config->is_welcome_msg) && $mail_config->is_customer_mail == 1 && $mail_config->is_welcome_msg == 1) :

                        if (isset($order_details->email) && !empty($order_details->email)) :

                            $mail_info = ['msg' => $welcomeMsg, 'subject' => @$mail_config->subject, 'type' => 3, 'mail_to' => $order_details->email];
                            $send = $this->send_mail($shop_info['user_id'], $mail_info);
                        endif;
                    endif;
                endif;




                if ($status != 0) :
                    if (isset($mail_config->is_customer_mail) && $mail_config->is_customer_mail == 1) :
                        if (isset($order_details->email) && !empty($order_details->email)) :
                            $mail_info = ['msg' => $msg, 'subject' => @$mail_config->subject, 'type' => 3, 'mail_to' => $order_details->email];

                            $send = $this->send_mail($shop_info['user_id'], $mail_info);
                        endif;
                    endif;
                endif;



            endif;


            // type 2 for delivery staff
            if ($status == 2) :
                if (isset($order_details->order_type) && $order_details->order_type == 1) {
                    if (isset($mail_config->is_dboy_mail) && $mail_config->is_dboy_mail == 1) :
                        $getDb = $this->admin_m->get_my_active_all_dboy($shop_info['user_id']);
                        $dbMail = [];
                        foreach ($getDb as $key => $db) {
                            $dbMail[] = $db['email'];
                        }
                        $mail_info = ['msg' => $msg, 'subject' => @$mail_config->subject, 'type' => 2, 'mail_to' => $dbMail];
                        $send = $this->send_mail($shop_info['user_id'], $mail_info);
                    endif;
                }
            endif;

            if (isset($send) && $send == TRUE) {
                return true;
            } else {
                return false;
            }
        else :
            return true;
        endif;
    }

    public function customer_forget_password($id, $data)
    {
        return $this->send_mail($id, $data);
    }

    public function promotion_mail($id, $email, $subject, $message)
    {
        $data = [
            'mail_to' => $email,
            'subject' => $subject,
            'msg' => $message,
            'type' => 1, // type 2 for multiple recipients
        ];

        return $this->send_mail($id, $data);
    }

    public function send_otp_mail($id, $email, $otp)
    {
        $validityMinutes = 5;
        $message = '';
        $appName =  restaurant($id)->name ?? restaurant($id)->username;
        $settings = $this->common_m->get_user_settings($id);
        $mail_config = !empty($settings['order_mail_config']) && isJson($settings['order_mail_config']) ? json_decode(@$settings['order_mail_config']) : '';


        $replace_data = array(
            '{EMAIL}' => $email,
            '{OTP}' => $otp,
            '{SHOP_NAME}' => $appName,
        );

        if (isset($mail_config->otp_mail) && !empty($mail_config->otp_mail)):
            $otpMsg =  json_decode($mail_config->otp_mail);
            $message = create_msg($replace_data, $otpMsg);
        endif;


        $data = [
            'msg' => $message,
            'subject' => 'One-Time Password (OTP)',
            'type' => 1,
            'mail_to' => $email,
        ];

        $send = $this->send_mail($id, $data);

        return $send;
    }
}
