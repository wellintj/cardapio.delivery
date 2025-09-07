<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_m extends CI_Model
{
    protected $coupon_id = 0;
    public function __construct()
    {
        $this->db->query("SET sql_mode = ''");
        $this->load->library('cart');
        if (d_auth('is_discount') == true) {
            $this->coupon_id = !empty(d_auth('coupon_id')) ? d_auth('coupon_id') : 0;
        } else {
            $this->coupon_id = 0;
        }
    }

    public function get_cart_details()
    {
        $cartItems = $this->cart->contents();
        $get_shop_id = [];
        $taxDetails = [];

        foreach ($cartItems as $key => $shop_id) {
            $get_shop_id[] = $shop_id['shop_id'];
            if (isset($shop_id['tax_fee']) && !empty($shop_id['tax_fee'])) {
                $taxDetails[] = [
                    'percent' => $shop_id['tax_fee'],
                    'price' => __taxCalc($shop_id['price'], $shop_id['tax_fee'], $shop_id['tax_status']),
                    'tax_status' => $shop_id['tax_status'],
                    'qty' => $shop_id['qty']
                ];
            }
        }

        return [
            'shop_id' => $get_shop_id[0] ?? null,
            'items' => $cartItems,
            'tax_details' => $taxDetails
        ];
    }

    public function calculate_order_prices($cart_total, $shop_info, $taxDetails = [])
    {
        if ($shop_info['is_tax'] == 1) {
            $tax_fee = __tax($taxDetails)->total_tax_price;
            $price = $cart_total - $tax_fee;
            $is_item_tax = 1;
        } else {
            $price = $cart_total;
            $tax_fee = __numberFormat(__taxCalc($price, $shop_info['tax_fee'], $shop_info['tax_status']), $shop_info['shop_id']);
            $is_item_tax = 0;

            if (tax_type() == 'seperate') {
                $price = $price;
            } else {
                $price = $shop_info['tax_status'] == '+' ? $price - $tax_fee : $price;
            }
        }

        return [
            'price' => $price,
            'tax_fee' => $tax_fee,
            'is_item_tax' => $is_item_tax,
            'total' => $cart_total
        ];
    }


    public function calculate_delivery_charge($order_type, $shop_info, $shipping_id = null)
    {
        if ($order_type == 1) {
            if ($shop_info['is_area_delivery'] == 1 && !empty($shipping_id)) {
                $shipping = $this->common_m->delivery_area_by_shop_id($shipping_id, $shop_info['shop_id']);
                return $shipping['cost'] ?? 0;
            } else {
                return $shop_info['delivery_charge_in'];
            }
        }
        return 0;
    }


    public function get_customer_data($shop_info, $is_guest_login = false)
    {

        if ($is_guest_login) {
            return $this->get_guest_customer_data($shop_info);
        }

        if (in_array($shop_info['is_customer_login'], [1, 2, 3])) {

            return $this->get_logged_customer_data();
        }
        return $this->get_new_customer_data($shop_info);
    }


    /*----------------------------------------------
     CUSTOMER DETAILS 
    ----------------------------------------------*/
    public function get_guest_customer_data($shop_info)
    {
        $dial_code = $this->input->post('dial_code') ?? ltrim($shop_info['dial_code'], '+');
        $phone = $this->input->post('cod_phone') ?? '';

        $phone =  !empty($phone) ? $dial_code . $phone : '';

        return [
            'name' => '',
            'email' => '',
            'phone' => $phone,
            'customer_id' => 0,
            'is_guest' => 1
        ];
    }

    public function get_logged_customer_data()
    {
        $customer_id =  !empty(auth('customer_id')) ? auth('customer_id') : (!empty(auth('customer_id', 'customer_info')) ? auth('customer_id', 'customer_info') : 0);

        $customer_info = $this->admin_m->single_select_by_id($customer_id, 'customer_list');
        if (empty($customer_info)) return false;

        $country = s_id($customer_info['country_id'], 'country');
        return [
            'name' => $customer_info['customer_name'],
            'email' => $customer_info['email'] ?? '',
            'phone' => customer_phone($customer_info['phone'], $customer_info['dial_code'] ?? $country->dial_code ?? ''),
            'customer_id' => $customer_info['id'],
            'is_guest' => 0
        ];
    }

    public function get_new_customer_data($shop_info)
    {
        $phone = $this->input->post('phone', true);
        return [
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email') ?? '',
            'phone' => !empty($phone) ? ($this->input->post('dial_code') ?? ltrim($shop_info['dial_code'], '+')) . $phone : '',
            'customer_id' => 0,
            'is_guest' => 0
        ];
    }
    /*----------------------------------------------
     CUSTOMER DETAILS 
    ----------------------------------------------*/




    public function create_order($data)
    {
        $insert = $this->admin_m->insert($data, 'order_user_list');
        if ($insert) {
            $this->notify_new_order($data);
            return $insert;
        }
        return false;
    }





    public function notify_new_order($data)
    {
        $this->version_changes_m->pusher($data['shop_id'], 'new_order');
        if ($data['order_type'] == 6) {
            $this->version_changes_m->pusher($data['shop_id'], 'table_order');
        }
        $this->system_model->order_push($data['shop_id'], $data['uid'], 'new_order');
    }







    public function prepare_order_data($inputData, $shop_info, $prices, $customer_data)
    {
        $order_type = $inputData['order_type'];

        // Calculate delivery charge

        if (isset($inputData['shipping_id']) && !empty($inputData['shipping_id'])) {
            $shipping_id = $inputData['shipping_id'];
            $delivery_charge = $inputData['delivery_charge'] ?? 0;
        } else {
            $shipping_id =  $inputData['shipping_area'] ?? null;
            $delivery_charge = $this->calculate_delivery_charge($order_type, $shop_info, $shipping_id);
        }


        // Calculate service charge
        $service_charge = 0;
        if (isset($inputData['service_charge']) && !empty($inputData['service_charge'])) {
            $service_charge = $inputData['service_charge'];
        } else {
            if (temp('is_service_charge') == 1 || $inputData['is_service_charge'] == 1) {
                $service_charge = __service_charge($prices['price'], $shop_info['shop_id'])->price ?? 0;
            }
        }


        // Get coupon details
        $is_coupon = $inputData['is_coupon'] ?? 0;
        $coupon_percent = ($is_coupon == 1) ? $inputData['coupon_percent'] : 0;
        $coupon_id = ($is_coupon == 1) ? $inputData['coupon_id'] : 0;


        $tips = $inputData['tips'] ?? 0;
        if (isset($tips) && !empty($tips)) {
            $tips = $tips;
        } else {
            $tips = 0;
        }

        // $prices['price'] without tax // $prices['total'] cart price
        // Calculate total price
        $total_price = grand_total(
            $prices['price'],
            $delivery_charge,
            $shop_info['discount'],
            $prices['tax_fee'],
            $coupon_percent,
            $tips,
            $order_type,
            $shop_info['tax_status'],
            0,
            $prices['is_item_tax'] ?? 0,
            $service_charge
        );

        // Prepare base order data
        $order_data = [
            'uid' => isset($inputData['uid']) ? $inputData['uid'] : __orderId($shop_info['shop_id']),
            'shop_id' => $shop_info['id'] ?? $inputData['shop_id'],
            'order_type' => $order_type,
            'name' => $customer_data['name'],
            'email' => $customer_data['email'],
            'phone' => $customer_data['phone'],
            'customer_id' => $customer_data['customer_id'] ?? 0,
            'address' => $inputData['address'] ?? '',
            'delivery_area' => $inputData['delivery_area'] ?? '',
            'shipping_id' => $shipping_id ?? 0,
            'total' => $total_price ?? 0,
            'sub_total' => $prices['price'] ?? 0,
            'tax_fee' => $prices['tax_fee'] ?? 0,
            'delivery_charge' => $delivery_charge ?? 0,
            'discount' => $shop_info['discount'] ?? 0,
            'service_charge' => $service_charge ?? 0,
            'is_guest_login' => $customer_data['is_guest'],
            'is_item_tax' => $prices['is_item_tax'] ?? 0,
            'comments' => $inputData['comments'] ?? '',
            'is_coupon' => $is_coupon ?? 0,
            'coupon_percent' => $coupon_percent ?? 0,
            'coupon_id' => $coupon_id ?? 0,
            'tips' => $tips,
            'is_ring' => 1,
            'is_change' => $inputData['is_change'] ?? 0,
            'change_amount' => $inputData['change_amount'] ?? 0,
            'use_payment' => $inputData['use_payment'] ?? 0,
            'delivery_payment_method' => $inputData['delivery_payment_method'] ?? null,
            'is_confirm' => 0,
            //booking
            'total_person' => $inputData['total_person'] ?? 0,
            'reservation_date' => $inputData['reservation_date'] ?? '',
            //pickup
            'pickup_point' => $inputData['pickup_point_id'] ?? 0,
            'pickup_time' => $inputData['pickup_time'] ?? '',
            'pickup_date' => isset($inputData['today']) && $inputData['today'] == 1 ? today() : $inputData['pickup_date'] ?? '',

            //dine-in
            'table_no' => $inputData['table_no'] ?? 0,
            'total_person' => $inputData['person'] ?? 0,
            //room-service
            'room_number' => $inputData['room_number'] ?? 0,
            'hotel_id' => $inputData['hotel_id'] ?? 0,

            //check payment
            'is_payment' => $inputData['is_payment'] ?? 0,
            'payment_by' => $inputData['payment_by'] ?? '',
            'created_at' => d_time()
        ];

        return $order_data;
    }




    public function validate_order_form($shop_info, $guest_cod = false)
    {
        $order_type = $this->input->post('order_type', true);

        // Set common validation rules
        $this->form_validation->set_rules('order_type', lang('order_type'), 'trim|required|xss_clean');

        if ($guest_cod && $order_type == 1) {
            $this->guest_cod_order_rules();
        }

        if ($order_type == 1) {
            $validation_result = $this->validate_minimum_order_price($shop_info);
            if ($validation_result !== true) {
                return $validation_result;
            }
        }


        $order_type = Order::type($order_type);
        // Define a mapping of order types to their validation functions
        $order_validation_rules = [
            'cod' => 'set_delivery_rules',   // Delivery
            'booking' => 'set_booking_rules', // Reservation
            'pickup' => 'set_pickup_rules',      // Pickup
            'dine-in' => 'set_dinein_rules',      // Dine-in
            'room-service' => 'set_hotel_rules'        // Hotel
        ];

        // Call the appropriate validation function if it exists
        if (isset($order_validation_rules[$order_type])) {
            $this->{$order_validation_rules[$order_type]}($shop_info);
        }

        // Apply customer validation rules if guest login is not used and login is required
        if (!$this->input->post('is_guest_login') && empty($shop_info['is_customer_login'])) {
            $this->set_customer_rules($shop_info);
        }

        return $this->form_validation->run();
    }


    private function validate_minimum_order_price($shop_info)
    {
        $minPrice = $shop_info['min_order'] ?? 0;
        $subtotal = $this->cart->total();

        if ($minPrice > 0 && $subtotal < $minPrice) {
            $error_msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> 
                <div>
                <h4>' . lang('minimum_price_msg_for_cod') . '</h4>
                <p>' . lang('minimum_price') . ' : ' . currency_position($minPrice, $shop_info['shop_id']) . '</p>
                </div>
                </div>';

            echo json_encode(['st' => 0, 'msg' => $error_msg]);
            return false;
        }

        return true;
    }


    public function set_delivery_rules($shop_info)
    {
        $this->form_validation->set_rules('address', lang('address'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('delivery_area', 'Google Map link', 'trim|xss_clean');

        if ($shop_info['is_area_delivery'] == 1) {
            $this->form_validation->set_rules('shipping_area', lang('shipping_address'), 'trim|required|xss_clean');
        }
    }

    public function set_booking_rules()
    {
        $this->form_validation->set_rules('reservation_date', lang('booking_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('total_person', lang('person'), 'trim|required|xss_clean');
    }

    public function set_pickup_rules($shop_info)
    {
        $time = $this->common_m->get_single_appoinment(__week(), $shop_info['id']);
        if (empty($time)) {
            $this->form_validation->set_rules('pickup_time', lang('pickup_time'), 'trim|required|xss_clean');
        }
        $this->form_validation->set_rules('pickup_point_id', lang('pickup_area'), 'trim|required|xss_clean');
    }

    public function set_dinein_rules()
    {
        $this->form_validation->set_rules('table_no', lang('table_no'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('person', lang('person'), 'trim|required|xss_clean');
    }

    public function set_hotel_rules()
    {
        $this->form_validation->set_rules('hotel_id', lang('hotel_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('room_number', lang('room_numbers'), 'trim|required|xss_clean');
    }

    public function set_customer_rules($shop_info)
    {
        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('dial_code', lang('dial_code'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', lang('phone'), 'trim|required|xss_clean');

        if ($shop_info['is_checkout_mail'] == 1) {
            $this->form_validation->set_rules('email', lang('email'), 'trim|required|xss_clean');
        }
    }
    public function guest_cod_order_rules()
    {
        $this->form_validation->set_rules('dial_code', lang('dial_code'), 'trim|xss_clean', array('required' => !empty(lang('required_alert')) ? lang('required_alert') : "%s field is required"));

        $this->form_validation->set_rules('cod_phone', lang('phone'), 'trim|xss_clean|required', array('required' => !empty(lang('required_alert')) ? lang('required_alert') : "%s field is required"));
    }

    public function should_redirect_payment($order_data)
    {
        $is_payment = $this->input->post('is_payment', true);
        $use_payment = $this->input->post('use_payment', true);

        return ($is_payment == 1  || $use_payment == 1);
    }

    public function get_payment_redirect_url($shop_info, $order_data)
    {
        $this->session->set_userdata('payment', $order_data);

        if ($this->input->post('use_payment') == 1) {
            $method = $this->input->post('method');
            if (empty($method)) {
                $msg = $this->load->view('error_msg', ['msg' => lang('please_select_the_payment_method')], true);
                echo json_encode(['st' => 0, 'msg' => $msg]);
                exit();
            }

            // Verificar se é PIX Dinâmico - redirecionar diretamente para página de pagamento PIX
            if ($method === 'mercado_pix') {
                return base_url('payment-pix/' . $shop_info['username'] . '/' . $order_data['uid']);
            }

            return base_url('profile/payment/' . $shop_info['username'] . '?method=' . $method);
        }

        return base_url('profile/payment/' . $shop_info['username']);
    }



    public function order_info($insert, $info, $type = 1)
    {

        $insertItem = $this->cart_m->insert_order_item($insert);

        if ($insertItem == true) :
            if ($this->coupon_id != 0) {
                $this->admin_m->update_discount($this->coupon_id);
            }
            $this->cart->destroy();
        endif;
    }


    public function handleQrCode($order, $data)
    {
        $is_order_qr = $data['shop']['is_order_qr'] ?? 0;

        if ($is_order_qr != 1) {
            return '';
        }

        if (empty($order['qr_link'])) {
            return $this->upload_m->order_qr($order['phone'] ?? '', $data['order_id'], $order['shop_id']);
        }

        return $order['qr_link'];
    }

    public function checkWhatsappAvailability($order, $shop_info)
    {
        if (
            shop($order['shop_id'])->is_whatsapp != 1 ||
            !is_feature(shop($order['shop_id'])->user_id, 'whatsapp')
        ) {
            return 0;
        }

        $order_slug = $this->common_m->single_select_by_id($order['order_type'], 'order_types')['slug'];
        $whatsapp_enable_for = json_decode($shop_info['whatsapp_enable_for'] ?? '[]', true);

        return isset($whatsapp_enable_for[$order_slug]) && $whatsapp_enable_for[$order_slug] == 1 ? 1 : 0;
    }
}
