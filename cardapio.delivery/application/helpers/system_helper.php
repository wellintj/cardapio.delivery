<?php

// admin config
if (!function_exists('__check')) {
    function __check($keys)
    {
        $ci = get_instance();
        if (is_array($keys) && sizeof($keys) > 0) {
            foreach ($keys as $key => $v) {
                if ($ci->admin_m->check_by_keys($key) == 1) {
                    $id = $ci->admin_m->update_by_keys($key, ['key' => $key, 'value' => $v]);
                } else {
                    $id = $ci->admin_m->insert(['key' => $key, 'value' => $v], 'admin_config');
                }
            }
            return $id;
        } else {
            if ($ci->admin_m->check_by_keys($keys) == 1) {
                return 1;
            } else {
                return 0;
            }
        }
    }
}


// get admin config value by key
if (!function_exists('__config')) {
    function __config($key)
    {
        $ci = get_instance();
        if ($ci->db->table_exists('admin_config')) :
            return $ci->admin_m->get_config_by_key($key);
        else :
            return [];
        endif;
    }
}


// get admin config value by key
if (!function_exists('__adminTax')) {
    function __adminTax()
    {
        $ci = get_instance();
        $tax = isset(st()->invoice_config) && isJson(st()->invoice_config) ? json_decode(st()->invoice_config) : '';
        return $tax;
    }
}




// update payment_info and affiliate 

if (!function_exists('__update_payment')) {
    function __update_payment($subscriber_id, $package_id, $price = '')
    {
        $ci = get_instance();
        $payment_info = $ci->admin_m->check_existing_pending_payment_by_subscriber($subscriber_id, $package_id);


        if (isset($payment_info->id) && !empty($payment_info->id)) {
            $ci->admin_m->update(['is_payment' => 1], $payment_info->id, 'payment_info');
        }
        if (__config('is_affiliate') == 1) :
            if (isset($payment_info->ref_id) && !empty($payment_info->ref_id)) {
                $ci->admin_m->update(['is_payment' => 1], $payment_info->ref_id, 'vendor_affiliate_list');
                if (isset($price) && !empty($price)) :
                    $ci->admin_m->update(['amount' => $price], $payment_info->ref_id, 'vendor_affiliate_list');
                endif;
            }
        endif;

        return true;
    }
}

// get _table details using table id

if (!function_exists('__table')) {
    function __table($table_id)
    {
        $ci = get_instance();
        return $ci->admin_m->get_table_details($table_id);
    }
}


// referal price and details

if (!function_exists('__refer_price')) {
    function __refer_price($price, $type = 'refer')
    {
        $ci = get_instance();
        if ($type == 'refer') :
            if (__config('commision_type') == "flat") {
                $commision_amount = __config('commision_rate');
                $commision_rate = '';
            } else {
                $percent = get_percent($price, __config('commision_rate'));
                $commision_amount = number_format($percent, 2);
                $commision_rate = __config('commision_rate') . '%';
            };
            return (object)['amount' => $commision_amount, 'commision_rate' => $commision_rate];
        else :
            if (__config('subscriber_commision_type') == "flat") {
                $commision_amount = __config('subscriber_commision_rate');
                $commision_rate = '';
            } else {
                $percent = get_percent($price, __config('subscriber_commision_rate'));
                $commision_amount = number_format($percent, 2);
                $commision_rate = __config('subscriber_commision_rate') . '%';
            };
            return (object)['amount' => $commision_amount, 'commision_rate' => $commision_rate];

        endif;
    }
}

//  referal details for invoice invoice 
if (!function_exists('__invoice_total')) {
    function __invoice_total($package_price = 0, $tax = 0, $ref_dicount = 0, $discount = 0)
    {

        if (!empty($tax)) {
            $tax_fee = get_percent($package_price, $tax);
        } else {
            $tax_fee = 0;
        }

        if ($ref_dicount != 0 && $ref_dicount != '') {
            $ref_discount = __refer_price($package_price, 'subscriber')->amount;
            $commision_rate = __refer_price($package_price, 'subscriber')->commision_rate;
        } else {
            $ref_discount = 0;
            $commision_rate = 0;
        }


        $total_amount =  ($package_price + $tax_fee) - ($ref_discount + $discount);
        $total_amount = number_format((float)$total_amount, 2, '.', '');


        return (object) ['subtotal' => $package_price, 'total' => $total_amount, 'commision_rate' => $commision_rate, 'referal_discount' => $ref_discount, 'discount_price' => $discount, 'tax_fee' => $tax_fee];
    }
}





if (!function_exists('__tax')) {
    function __tax($data, $is_view = false)
    {
        $ci = get_instance();
        $aggregatedData = [];
        $total_tax_price = 0;
        foreach ($data as $item) {
            $percent = $item['percent'] ?? 0;
            $price = $item['price'] ?? 0;
            $status = $item['tax_status'] ?? '+';
            $qty = $item['qty'] ?? 1;
            if ($percent != 0) :
                if (!isset($aggregatedData[$percent])) {
                    $aggregatedData[$percent] = ['percent' => $percent, 'total_price' => 0, 'count' => 0, 'tax_status' => $status];
                }

                $aggregatedData[$percent]['total_price'] += $price * $qty;
                $aggregatedData[$percent]['count'] += $qty;
                $total_tax_price += $item['price'];
                $total_tax_price = $total_tax_price * $qty;
            endif;
        }

        return (object) ['details' => $aggregatedData, 'total_tax_price' => $total_tax_price];
    }
}

if (!function_exists('__order')) {
    function __order($order_info, $item_details)
    {
        $ci = get_instance();

        // Convert objects to arrays
        $order_info = is_object($order_info) ? (array) $order_info : $order_info;
        $item_details = is_object($item_details) ? (array) $item_details : $item_details;

        if (is_array($item_details)) {
            foreach ($item_details as $key => $item) {
                if (is_object($item)) {
                    $item_details[$key] = (array) $item;
                }
            }
        }

        // Get order info if numeric ID provided
        if (is_numeric($order_info)) {
            $order_info = $ci->admin_m->single_select_by_uid($order_info, 'order_user_list');
        }

        if (empty($order_info)) return [];

        if (!empty($order_info)) {
            $shop_id = $order_info['shop_id'];
            $shop = shop($shop_id);

            $qty = $subtotal = $net_total = 0;

            $taxDetails  = [];
            foreach ($item_details as $key => $row) {
                if ($row['is_package'] == 1 && !empty($row['package_tax_fee'])) {
                    $taxDetails[] = [
                        'item_type' => 'package',
                        'percent' => $row['package_tax_fee'],
                        'price' => __taxCalc($row['item_price'], $row['package_tax_fee'], $row['tax_status']),
                        'tax_status' => $row['package_tax_status'],
                        'qty' => $row['qty'],
                    ];
                } elseif (!empty($row['tax_fee'])) {
                    $taxDetails[] = [
                        'item_type' => 'item',
                        'percent' => $row['tax_fee'],
                        'price' => __taxCalc($row['item_price'], $row['tax_fee'], $row['tax_status']),
                        'tax_status' => $row['tax_status'],
                        'qty' => $row['qty'],
                    ];
                }
                $qty += $row['qty'];
                $net_total += $row['sub_total'];
            }


            if ($order_info['is_item_tax'] == 1) {
                if (!empty($taxDetails)) :
                    $tax_fee = __tax($taxDetails)->total_tax_price;
                    $tax_details = __tax($taxDetails)->details;
                else :
                    $tax_fee = 0;
                    $tax_details = [];
                endif;
                $subtotal = $net_total - $tax_fee;
            } else {

                $subtotal = $net_total;
                $tax_fee = __taxCalc($subtotal, $shop->tax_fee, $shop->tax_status);
                $tax_status = $shop->tax_status ?? '+';
                $tax_percent = $shop->tax_fee;
                if (tax_type() == 'seperate') {
                    $subtotal = $net_total;
                } else {
                    $subtotal = $tax_status == '+' ? $subtotal - $tax_fee : $subtotal;
                }

                $tax_details = [];
            }




            if ($order_info['is_pos'] == 1) {
                $discount = $order_info['discount'];
            } else {
                $discount = get_percent($subtotal, $order_info['discount'], $order_info['is_pos']);
            }


            $coupon_percent = $order_info['coupon_percent'];
            $coupon_discount = get_percent($subtotal, $order_info['coupon_percent']);

            $tips = $order_info['tips'] ?? 0;
            $service_charge = $order_info['service_charge'] ?? 0;
            $delivery_charge = $order_info['delivery_charge'] ?? 0;
            $tax_status = $shop->tax_status;
            $is_item_tax = $shop->is_tax;
            $tax_percent = $tax_percent ?? 0;


            if ($order_info['order_type'] == 1) {

                if ($is_item_tax == 1) {
                    $total = ($subtotal + $delivery_charge + $tax_fee + $tips + $service_charge) - ($discount + $coupon_discount);
                } else {
                    if ($tax_status == "+") :
                        $total = ($subtotal + $delivery_charge + $tax_fee + $tips + $service_charge) - ($discount + $coupon_discount);
                    elseif ($tax_status == '--') :
                        $total = ($subtotal + $delivery_charge + $tips + $service_charge) - ($discount + $coupon_discount);
                    else :
                        $total = ($subtotal + $delivery_charge + $tips + $service_charge + $tax_fee) - ($discount + $coupon_discount);
                    endif;
                }
            } else {

                if ($is_item_tax == 1) {
                    $total = ($subtotal + $tax_fee + $tips + $service_charge) - ($discount + $coupon_discount);
                } else {
                    if ($tax_status == "+") :
                        $total = ($subtotal + $tax_fee + $tips + $service_charge) - ($discount + $coupon_discount);
                    elseif ($tax_status == '--') :
                        $total = ($subtotal + $tips + $service_charge) - ($discount + $coupon_discount);
                    else :
                        $total = ($subtotal + $tips + $service_charge + $tax_fee) - ($discount + $coupon_discount);
                    endif;
                }
            } // check order type

            $data = [
                'grand_total' => $total,
                'subtotal' => $subtotal,
                'net_total' => $net_total,
                'qty' => $qty,
                'discount' => $discount,
                'coupon_percent' => $coupon_percent,
                'coupon_discount' => $coupon_discount,
                'tips' => $tips,
                'service_charge' => $service_charge,
                'shipping' => $delivery_charge,
                'tax_fee' => $tax_fee,
                'tax_details' => $tax_details ?? '',
                'tax_status' => $tax_status,
                'tax_percent' => $tax_percent,
                'order_type' => $order_info['order_type'],
                'is_pos' => $order_info['is_pos'],
                'shop_id' => $shop_id,
            ];

            return (object) $data;
        } else {
            return [];
        } //check order_details empty

    }


    if (!function_exists('__staff')) {
        function __staff($id)
        {
            $ci = get_instance();
            $data = $ci->admin_m->single_select_by_id_row($id, 'staff_list');
            return $data ?? [];
        }
    }

    if (!function_exists('__pushConfig')) {
        function __pushConfig($id, $type = 'order')
        {
            $ci = get_instance();
            $settings = $ci->common_m->get_user_settings(shop($id)->user_id);
            $notification = isJson($settings['onesignal_config']) ? json_decode($settings['onesignal_config']) : "";

            if (isset($notification->is_active_onsignal) && $notification->is_active_onsignal == 1 && isset($notification->user_id) && !empty($notification->user_id)) :
                return $notification;
            else :
                return 0;
            endif;
        }
    }

    if (!function_exists('__staffAction')) {
        function __staffAction($order_id, $staff_id, $action_type)
        {
            $ci = get_instance();
            $data = $ci->system_model->log_order_activity($order_id, $staff_id, $action_type);
            return $data;
        }
    }

    if (!function_exists('__language')) {
        function __language($data)
        {
            $ci = get_instance();
            if (isset($data) && !empty($data) && is_array($data)) :
                $data = $data;
            else :
                $data = ['language' => site_lang()];
            endif;

            if (isset($data['language']) && $data['language'] == site_lang()) {
                $site_ln = site_lang();
            } else {
                $site_ln = site_lang();
            }

            return lang_slug($site_ln);
        }
    }

    if (!function_exists('__languageField')) {
        function __languageField($col = 'col-md-12', $shop_id = null)
        {
            $ci = get_instance();
            return $ci->load->view('common/language_form', ['col' => $col, 'shop_id' => $shop_id]);
        }
    }

    if (!function_exists('__service_charge')) {
        function __service_charge($amount, $shop_id)
        {
            $ci = get_instance();
            $shop_info = $ci->admin_m->get_shop_info($shop_id);
            $service_config =  isJson($shop_info->tips_config) ? json_decode($shop_info->tips_config) : '';

            if (isset($service_config->is_service_charge) && $service_config->is_service_charge == 1) {
                if ($service_config->service_charge_type == 'percent') {
                    $price = get_percent($amount, $service_config->service_charge ?? 0);
                    $details = "({$service_config->service_charge} %)";
                } else {
                    $price = $service_config->service_charge ?? 0;
                    $details = "";
                }
            } else {
                $price = 0;
                $details = "";
            }



            return (object)['price' => $price, 'details' => $details];
        }
    }

    if (!function_exists('__request')) {
        function __request($msg = '', $status = 0, $url = '')
        {
            $ci = get_instance();
            $isAjax = $ci->input->is_ajax_request();



            if ($isAjax == true) {

                if ($status == 1) {
                    $customMsg = !empty($msg) ? $msg : lang('success_text');

                    $msg = '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>' . lang('success') . ' </strong> ' . $customMsg . '
                </div>';
                } else {

                    $customMsg = !empty($msg) ? $msg : lang('error_text');
                    $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                ' . $customMsg . '
                </div>';
                }
                echo json_encode(['st' => $status, 'msg' => $msg, 'url' => $url]);
                exit();
            } else {
                if ($status == 1) {
                    $ci->session->set_flashdata('success', !empty($msg) ? $msg : lang('success_text'));
                    if (!empty($url)) {
                        redirect($url);
                    } else {
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {

                    $ci->session->set_flashdata('error', !empty($msg) ? $msg : lang('error_text'));
                    if (!empty($url)) {
                        redirect($url);
                    } else {
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }
        }
    }
}

if (!function_exists('__cartShopID')) {
    function __cartShopID()
    {
        $ci = get_instance();
        $shop_id = 0;
        foreach ($ci->cart->contents() as $key => $row) :
            $shop_id = $row['shop_id'][0];
        endforeach;

        return $shop_id;
    }
}
if (!function_exists('__response')) {
    function __response($response)
    {
        $ci = get_instance();

        $ci->output->set_status_header(200);
        $ci->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        return;
    }
}


if (!function_exists('__report')) {
    function __report($data)
    {
        $ci = get_instance();
        if (isset($data['order_details']) && !empty($data['order_details'])) :
            $total = $subtotal = $tax = $discount  = $coupon_discount = $tips = $service_charge = $total_with_out_tax = $shipping = $cash_payment = $without_cash = $without_payment = 0;
            $cash_type = ['cash', 'restaurant', 'vendor', 'staff', 'admin', ''];
            $payment_by_cash = $payment_without_cash = [];
            foreach ($data['order_details'] as $key => $row) :

                $coupon_discount +=  (float)isset($row->coupon_percent) && !empty($row->coupon_percent) ? get_percent($row->sub_total, $row->coupon_percent ?? 0) : 0;


                if ($row->is_payment == 1) {
                    if (in_array($row->payment_by, $cash_type)) :
                        $cash_payment += (float)$row->total;
                        $payment_by_cash[$key] = $row->payment_by;
                    else :
                        $without_cash += (float)$row->total;
                        $payment_without_cash[$key] = $row->payment_by;
                    endif;
                } else {
                    $without_payment += (float)$row->total;
                }

                $total += (float)$row->total ?? 0;
                $subtotal += (float)$row->sub_total ?? 0;
                if (isset($row->is_item_tax) && $row->is_item_tax == 1) {
                    $tax += (float)$row->tax_fee ?? 0;
                } else {
                    $tax += $row->tax_fee ?? 0;
                }



                $discount += (float)$row->discount ?? 0;
                $coupon_discount = (float)$coupon_discount ?? 0;
                $tips += (float)$row->tips ?? 0;
                $service_charge += (float)$row->service_charge ?? 0;
                $shipping += (float)$row->delivery_charge ?? 0;

            endforeach;

            if (sizeof($data['item_list']) > 0) :
                $total_qty = $total_item_price = $total_item_sub_price = 0;
                foreach ($data['item_list'] as  $key => $item) :
                    $total_qty += $item->total_item;
                    $total_item_sub_price += $item->sub_total;
                    $total_item_price += $item->item_price;
                endforeach;
            endif;
            $grand_total = get_total($subtotal, $shipping, $discount, $tax, $coupon_discount, $tips, $tax_status = '+', $service_charge);

            $data = (object)[
                'total' => $total,
                'grand_total' => $grand_total,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'coupon_discount' => $coupon_discount,
                'tips' => $tips,
                'service_charge' => $service_charge,
                'shipping' => $shipping,
                'cash' => $cash_payment,
                'online_payment' => $without_cash,
                'payment_without_cash' => $payment_without_cash,
                'payment_by_cash' => $payment_by_cash,
                'without_payment' => $without_payment,
                'qty' => $total_qty ?? 0,
                'total_item_price' => $total_item_price ?? 0,
                'total_item_sub_price' => $total_item_sub_price ?? 0,
            ];

            return $data;
        endif;
    }
}


if (!function_exists('__daterange')) {
    function __daterange($columnName)
    {
        $ci = get_instance();

        $today = today();
        $sql = '';
        if (!empty($ci->input->get('daterange', TRUE))) {
            $date_arr = explode('-', xss_clean($ci->input->get('daterange', TRUE)));
            $newDate1 = date("Y-m-d", strtotime($date_arr[0]));
            if (isset($date_arr[1])) :
                $newDate2 = date("Y-m-d", strtotime($date_arr[1]));
            else :
                $newDate2 = $today;
            endif;

            $sql = "DATE_FORMAT({$columnName},'%Y-%m-%d') BETWEEN '{$newDate1}' AND '{$newDate2}'";
        } else {
            $sql = "DATE_FORMAT({$columnName},'%Y-%m-%d')  =  '{$today}'";
        }

        return $sql;
    }
}


if (!function_exists('__env')) {
    function __env()
    {
        $ci = get_instance();
        $envFilePath = FCPATH . 'ci-env';
        // Check if the .env file exists
        if (file_exists($envFilePath)) {
            $envContent = file_get_contents($envFilePath);
            $envVariables = parse_ini_string($envContent);
            // Set environment variables
            $ENVDATA = [];
            foreach ($envVariables as $key => $value) {
                $ENVDATA[$key] = $value;
            }
            return (object)$ENVDATA;
        } else {
            $defaultEnvContent = "is_development=false\n";
            file_put_contents($envFilePath, $defaultEnvContent);
        }
    }
}
if (!function_exists('__isFeature')) {
    function __isFeature($featureName)
    {
        $ci = get_instance();
        if (is_feature(auth('id'), $featureName) == 0) :
            redirect(base_url('admin/dashboard'));
            exit();
        endif;
    }
}


if (!function_exists('__taxCalc')) {
    function __taxCalc($gross_amout, $tax_rate = 0, $included = '+', $is_item_based = 0)
    {
        $ci = get_instance();
        $tax = 0;
        if (!empty($tax_rate)) :
            if (tax_type() == 'default') :
                $tax = calculateTax($gross_amout, $tax_rate, $included);
            else :
                $tax = ($gross_amout * $tax_rate) / 100;
            endif;
        endif;

        return $tax;
    }
}


function calculateTax($amount, $taxRate = 15, $isIncluded = '+')
{
    if ($isIncluded == '+') {
        $subtotal = $amount / (1 + ($taxRate / 100));
        $taxAmount = $amount - $subtotal;
        $total = $amount;
    } else {
        $subtotal = $amount;
        $taxAmount = $subtotal * ($taxRate / 100);
        $total = $subtotal + $taxAmount;
    }
    return $taxAmount;
    // return [
    //     'subtotal' => number_format($subtotal, 2),
    //     'tax_rate' => $taxRate,
    //     'tax_amount' => number_format($taxAmount, 2),
    //     'total' => number_format($total, 2)
    // ];
}






if (!function_exists('tax_type')) {
    function tax_type()
    {
        $settings = settings();
        return isset($settings['tax_system']) && !empty($settings['tax_system']) ? $settings['tax_system'] : 'default'; //percent /default / seperate

    }
}



if (!function_exists('__taxPercent')) {
    function __taxPercent($amount, $taxFee)
    {
        if ($taxFee == 0) {
            $percentage = 0;
        } elseif ($amount == 0) {
            $percentage = 0;
        } else {
            $percentage = ($taxFee / $amount) * 100;
        }

        return round($percentage);
    }
}


if (!function_exists('__numberFormat')) {
    function __numberFormat($amount, $id)
    {
        $ci = get_instance();
        $shop = shop($id);
        $type = $shop->number_formats ?? 0;
        if ($type == 0) {
            return round((float)$amount);
        } else {
            return number_format((float)$amount, 2, '.', '');
        }
    }
}

if (!function_exists('__discount')) {
    function __discount($amount, $discount = 0)
    {
        $ci = get_instance();
        if ($discount != 0 && !empty($discount)) {
            $amount = get_percent_price($amount, $discount);
        }
        return $amount;
    }
}




if (!function_exists('__deleteBtn')) {
    function __deleteBtn($id, $table, $withText = false)
    {
        $ci = get_instance();
        $url = base_url("delete-item/{$id}/{$table}");
        if ($withText == true) {
            $text = lang('delete');
        } else {
            $text = '';
        }
        $msg = lang("are_you_sure");

        return "<a href='{$url}' class='btn btn-danger btn-sm action_btn' data-msg='{$msg}'> <i class='fa fa-trash'></i>  {$text}</a>";
    }
}


if (!function_exists('__menu')) {
    function __menu($id, $class = "", $is_quick = false, $is_sidebar = false)
    {
        $ci = get_instance();
        $menuList = $ci->admin_m->get_vendor_menu($id, $is_quick);
        $load = $ci->load->view('common_layouts/__navMenu', ['menuList' => $menuList, 'class' => $class, 'is_quick' => $is_quick, 'is_sidebar' => $is_sidebar]);
        return $load;
    }
}


if (!function_exists('__week')) {
    function __week()
    {
        $ci = get_instance();
        $date = new DateTime('now', new DateTimezone(time_zone()));
        $dayOfWeek = $date->format('w');
        return $dayOfWeek;
    }
}


if (!function_exists('__isPayment')) {
    function __isPayment($order_type, $shop_id)
    {
        $ci = get_instance();
        $order_types = $ci->admin_m->get_order_type_by_type_id($order_type, $shop_id);
        if (!empty($order_types) && $order_types->is_payment == 1 && $order_types->is_admin_enable == 1) {
            return true;
        }
    }
}

if (!function_exists('__')) {
    function __($data)
    {
        $ci = get_instance();
        $data = strtolower($data);
        return lang($data);
    }
}

if (!function_exists('__posTax')) {
    function __posTax($is_tax, $tax_fee, $tax_status)
    {
        $ci = get_instance();
        if ($is_tax == 1 && !empty($tax_fee)) :
            return " <p class='tax_status'>" . tax($tax_fee, $tax_status) . "</p>";
        endif;
    }
}


if (!function_exists('__date_range')) {
    function __date_range($date)
    {
        try {
            $ci = get_instance();
            if (isset($date) && !empty($date) && strpos($date, '-') !== false) {
                $datetime_parts = explode('-', $date);
                if ((isset($datetime_parts[0]) && !empty($datetime_parts[0])) && (isset($datetime_parts[1]) && !empty($datetime_parts[1])) && count($datetime_parts) == 2) {
                    $date1 = trim($datetime_parts[0]);
                    $date2 = trim($datetime_parts[1]);
                    
                    // Tenta converter a data para o formato Y-m-d
                    $newDate1 = date("Y-m-d", strtotime($date1));
                    $newDate2 = date("Y-m-d", strtotime($date2));
                    
                    // Verifica se as datas são válidas
                    if ($newDate1 != '1970-01-01' && $newDate2 != '1970-01-01') {
                        $datarange = (object) ['newDate1' => $newDate1, 'newDate2' => $newDate2];
                        return $datarange;
                    }
                }
            }
            return null; // Retorna null se a data não for válida
        } catch (Exception $e) {
            log_message('error', 'Erro em __date_range: ' . $e->getMessage());
            return null;
        }
    }
}


if (!function_exists('__taxStatus')) {
    function __taxStatus($is_tax, $row)
    {
        $ci = get_instance();

        if (isset($is_tax) && $is_tax == 1) :
            if (!empty($row) && is_array($row)) {
                $row = (object) $row;
                if (isset($row->is_package) && $row->is_package == 1) {
                    if (isset($row->package_tax_fee, $row->package_tax_status) && !empty($row->package_tax_fee) && !empty($row->package_tax_status)) :
                        return " <p class='tax_status'>" . tax($row->package_tax_fee, $row->package_tax_status) . "</p>";
                    endif;
                } else {
                    if (isset($row->tax_fee, $row->tax_status) && !empty($row->tax_fee) && !empty($row->tax_status)) :
                        return " <p class='tax_status'>" . tax($row->tax_fee, $row->tax_status) . "</p>";
                    endif;
                }
            }

        endif;
    }
}


if (!function_exists('__price')) {
    function __price($row, $shop_id, $class = 'currentPrice', $discount = 0)
    {
        $ci = get_instance();
        $html = '';
        if (!empty($row) && is_array($row)) {
            $row = (object) $row;
            $html .= '<div class="priceGroup">';
            if (isset($row->is_size) && $row->is_size == 1) :
                $price = isJson($row->price) ? json_decode($row->price) : '';
                if (isset($price->variant_options[0]->price) && !empty($price->variant_options[0]->price)) {

                    if (isset($discount) && $discount != 0) {
                        $html .=  " <span class='{$class}'>" . currency_position(get_percent_price($price->variant_options[0]->price, $discount), $shop_id) . "</span>";
                        $html .=  " <span class='previous_price'>" . currency_position($price->variant_options[0]->price, $shop_id) . "</span>";
                    } else {
                        $html .=  " <span class='{$class}'>" . currency_position($price->variant_options[0]->price, $shop_id) . "</span>";
                    }
                };
            else :

                if (isset($row->price) && !empty($row->price)) {
                    if (isset($discount) && $discount != 0 && !empty($discount)) {
                        $html .=  " <span class='{$class} '>" . currency_position(get_percent_price($row->price, $discount), $shop_id) . "</span>";
                        $html .=  " <span class='previous_price offerPrice'> " . currency_position($row->price, $shop_id) . "</span>";
                    } else {
                        $html .=  " <span class='{$class}'>" . currency_position($row->price, $shop_id) . "</span>";
                        if (isset($row->previous_price) && !empty($row->previous_price) && trim($row->previous_price) != 0) {
                            $html .=  " <span class='previous_price'>" . currency_position($row->previous_price, $shop_id) . "</span>";
                        }
                    }
                }

            endif;
            $html .= '</div>';
        }

        return $html;
    }
}



if (!function_exists('__sub')) {
    function __sub($id = '')
    {
        $ci = get_instance();
        return 0;
    }
}

if (!function_exists('__jsonDecode')) {
    function __jsonDecode($data, $to_array = true)
    {
        $ci = get_instance();

        if (is_string($data)) {
            $data = json_decode($data);
        }

        // Check current type and convert if needed
        if ($to_array) {
            return is_object($data) ? (array)$data : $data;
        } else {
            return is_array($data) ? (object)$data : $data;
        }
    }
}




if (!function_exists('generate_otp')) {
    function generate_otp($customer_id, $phone = null, $table = 'customer_list')
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->load->helper('string');

        $minutes = 5;
        $daily_max_attempts = 3;
        $max_otp_attempts = 10;
        $expiration_time = time() + ($minutes * 60);
        $current_time = date('Y-m-d H:i:s');

        // Check daily attempts
        $customer = $ci->db->select('attempts, last_attempt_at')->where('id', $customer_id)->get($table)->row();

        if ($customer) {
            if (empty($customer->last_attempt_at)) {
                $attempts = 0;
                $ci->db->where('id', $customer_id)->update($table, ['last_attempt_at' => $current_time]);
            } else {
                $attempts = (strtotime($customer->last_attempt_at) > strtotime('-24 hours')) ? $customer->attempts : 0;
            }
        } else {
            return ['error' => 'Customer not found.'];
        }

        if ($attempts >= $daily_max_attempts) {
            return ['error' => 'maximum_otp_requests_exceeded'];
        }
        $otp = null;
        $otp_attempts = 0;
        do {
            $otp = random_string('numeric', 4);
            $is_unique = $ci->db->where('otp', $otp)
                ->where('otp_expire_time >', $current_time)
                ->get($table)
                ->num_rows() === 0;
            $otp_attempts++;
        } while (!$is_unique && $otp_attempts < $max_otp_attempts);

        if (!$is_unique) {
            return ['error' => 'Failed to generate unique OTP. Please try again.'];
        }

        $update_result = $ci->db->where('id', $customer_id)->update($table, [
            'otp' => $otp,
            'created_at' => $current_time,
            'otp_expire_time' => date('Y-m-d H:i:s', $expiration_time),
            'attempts' => $attempts + 1,
            'last_attempt_at' => $current_time
        ]);

        if (!$update_result) {
            return ['error' => 'Failed to update customer data.'];
        }



        $ci->session->set_tempdata('otp_data', [
            'otp_id' => $customer_id,
            'created_time' => time(),
            'otp_expire_time' => $expiration_time,
            'remaining_time' => $expiration_time - time(),
            'phone' => $phone ?: '',
            'email' => $phone ?: '',
        ], 60 * ($minutes + 1));




        return ['success' => true, 'otp' => $otp];
    }
}


if (!function_exists('verify_otp')) {
    function verify_otp($customer_id, $otp, $table = 'customer_list')
    {
        $ci = &get_instance();
        $current_time = date('Y-m-d H:i:s');
        $customer = $ci->db->where('id', $customer_id)
            ->get($table)
            ->row();

        if (!$customer) {
            $ci->session->unset_tempdata('otp_data');
            return ['error' => 'Customer not found.'];
        }

        if ($customer->otp !== $otp) {
            return ['error' => 'Invalid OTP.'];
        }

        if (strtotime($customer->otp_expire_time) < strtotime($current_time)) {
            return ['error' => 'OTP has expired.'];
        }

        $update_data = [
            'otp' => null,
            'otp_expire_time' => null,
            'attempts' => 0,
        ];

        $ci->db->where('id', $customer_id)->update($table, $update_data);

        $ci->session->unset_tempdata('otp_data');
        return ['success' => true, 'message' => 'OTP verified successfully.'];
    }
}


if (!function_exists('get_phone')) {
    function get_phone($phone)
    {
        $ci = get_instance();

        if (strpos($phone, '+') !== false) {
            $phone = str_replace('+', '', $phone);
        }
        return $phone;
    }
}


if (!function_exists('is_unique')) {
    function is_unique($value, $params)
    {
        $CI = &get_instance();
        $CI->load->database();

        if (empty($value)) {
            return TRUE;
        }


        list($table, $field, $current_id) = explode('.', $params);
        $query = $CI->db->select($field)
            ->from($table)
            ->where($field, $value)
            ->where_not_in('id', [$current_id])
            ->get();

        return $query->num_rows() === 0;
    }
}


if (!function_exists('__hidden')) {
    function __hidden($name, $value)
    {
        $ci = get_instance();
        return $data = "<input type='hidden' name='{$name}' value='{$value}' />";
    }
}


if (!function_exists('__phone')) {
    function __phone($data = [])
    {
        $ci = get_instance();
        return $ci->load->view('frontend/inc/common/phone', $data);
    }
}
