<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_m extends CI_Model
{
    public function __construct()
    {
        $this->db->query("SET sql_mode = ''");
        $this->load->library('cart');
    }

    public function __cart($id = 0, $type = 'item', $is_pos = 0)
    {
        $data = array();
        if ($id == 0) {

            $id = $this->input->post('item_id');
            $item_comments = isset($_POST['item_comments']) ? $this->security->xss_clean(trim($_POST['item_comments'])) : '';
            $item = $this->common_m->get_single_cart_items($id);


            $is_extra = $this->admin_m->check_extra_by_item_id($id);

            if (isset($_POST['extras']) && sizeof($_POST['extras']) > 0) {
                $extra_ids = json_encode($_POST['extras']);
                $is_extras = 1;
            } else {
                $extra_ids = [];
                $is_extras = 0;
            }




            if (isset($_POST['is_variants']) && $_POST['is_variants'] == 1) {
                $is_variants = 1;
                $item_size = $this->input->post('item_size');
            } else {
                $is_variants = 0;
                $item_size = 0;
            }

            // if modify from html then it will be checked item size
            if (isset($item['is_size']) && $item['is_size'] == 1) {
                $price = json_decode($item['price']);

                if (isset($price->variant_options) && is_array($price->variant_options)) {
                    $is_variants = 1;
                    $item_size = $this->input->post('item_size');
                    $is_size = 1;
                } else {
                    $is_variants = 0;
                    $item_size = 0;
                    $is_size = 0;
                }
            } else {
                $is_size = 0;
            }


            if ($is_extra['check'] == 1 && $is_extras == 1) {

                $title =  $item['title'];
                $ids =  $id . '-' . $item_size . random_string('numeric', 4);
                $exqty = [];
                if (isset($_POST['extra_qty']) && is_array($_POST['extra_qty'])) :
                    foreach ($_POST['extra_qty'] as $key => $qt) {
                        if (!empty($qt) && $qt > 0) {
                            $exqty[] = ['extra_id' => $key, 'ex_qty' => $qt];
                            $extraIds[] = $key;
                        }
                    }

                    $extra_qty = json_encode($exqty);
                    $extra_ids = json_encode($extraIds);
                else :
                    $extra_qty = '';
                endif;
            } else {
                $extra_ids = '';
                $title =  $item['title'] ?? '';
                $ids = $id . '-' . $item_size ?? 0 . '-1';
                $extra_qty = '';
            }
        } else {
            $ids = $id;
        }




        $cart_data = array();
        if ($type == 'package') :
            $package = $this->common_m->get_single_package_by_id($id);
            foreach ($package as $item) {
                $cart_data = array(
                    'id'      => $id,
                    'item_id' => $id,
                    'qty'     => 1,
                    'thumb'   => $item['thumb'],
                    'img_type'   => $item['img_type'],
                    'img_url'   => $item['img_url'],
                    'price'   => $item['final_price'],
                    'item_price'   => isset($_POST['item_price']) ? $_POST['item_price'] : $item['final_price'],
                    'name'    => $item['package_name'],
                    'tax_fee'    => isset($item['package_tax_fee']) ? $item['package_tax_fee'] : 0,
                    'tax_status' => isset($item['package_tax_status']) ? isset($item['package_tax_status']) : '+',
                    'is_package' => 1,
                    'is_size' => 0,
                    'is_pos' => $is_pos ?? 0,
                    'shop_id' => $item['shop_id'],
                    'options' => array('veg' => '',)
                );
            }
        else :

            $item = $this->common_m->get_single_cart_items($id);


            if (isset($_POST['price']) && !empty($_POST['price'])) {
                $price = $_POST['price'];
            } else {
                if ((isset($is_extra['check']) && $is_extra['check'] == 1) || (isset($is_variants) && $is_variants == 1) || (isset($is_size) && $is_size == 1)) {
                    $price = $this->input->post('item_price');
                } else {
                    $price = $item['price'];
                }
            }

            $qty = isset($_POST['qty']) ? $_POST['qty'] : 1;

            if ($qty > 1) {
                $price = $price / $qty;
            }



            $item_price = isset($_POST['item_price']) ? $_POST['item_price'] : $price;


            $cart_data = array(
                'id'      => $ids,
                'item_id' => $id,
                'qty'     => isset($_POST['qty']) ? $_POST['qty'] : 1,
                'thumb'   => $item['thumb'],
                'img_url'   => $item['img_url'],
                'img_type'   => $item['img_type'],
                'price'   => $price ?? 0,
                'item_price'   => $item_price ?? 0,
                'name'    => $item['title'],
                'tax_fee'    => $item['tax_fee'] ?? 0,
                'tax_status'    => $item['tax_status'] ?? 0,
                'is_package' => 0,
                'is_size' => $is_size ?? 0,
                'is_extras' => $is_extras ?? 0,
                'extra_id' => $extra_ids ?? '',
                'extra_qty' => $extra_qty ?? '',
                'shop_id' => $item['shop_id'],
                'is_pos' => $is_pos ?? 0,
                'item_comments' => isset($item_comments) ? $item_comments : '',
                'sizes' => ['size_slug' => $item_size ?? ''],
                'options' => array('veg' => $item['veg_type']),
                'is_variants' => $is_variants ?? 0,
            );
        endif;
        return $this->__insert($cart_data);
    }



    protected function __insert($cart_data)
    {
        $data = [];

        $shop_info = $this->admin_m->get_shop_info($cart_data['shop_id']);

        //if is not from pos then no need to check shop open time and close time
        if (isset($cart_data['is_pos']) && $cart_data['is_pos'] == 0) {
            if ($this->is_shop_open($cart_data['shop_id']) == 0) {
                return json_encode(['st' => 2, 'msg' => 'shop is closed now']);
                exit();
                //check shop available time
            }
            $is_cart = $this->check_existing_shop($cart_data['shop_id']);
        } else {
            $is_cart = 1;
        }



        $this->cart->insert($cart_data);
        $data['name'] = $cart_data['name'];

        $price = currency_position($this->cart->total(), $cart_data['shop_id']);

        if (isset($is_cart) && $is_cart == 1) :
            $count = $this->cartInfo($cart_data['shop_id']); // cart floating icon 
        else :
            $count = 0;
        endif;

        $data['qty'] = $this->cart->total_items();
        $data['shop_id'] = $cart_data['shop_id'];
        $data['total_item'] = $this->cart->total_items();
        $data['slug'] = $shop_info->username ?? '';
        $item = $this->load->view('layouts/ajax_cart_item', $data, true);
        $notify = $this->load->view('layouts/ajax_add_to_cart_notify', $data, true);
        $load_qty = $this->load->view('common_layouts/cartCount', $data, true);
        return json_encode(['st' => 1, 'load_data' => $item, 'notify' => $notify, 'total_item' => $count, 'total_price' => $price, 'qty' => $load_qty]);
    }



    protected function is_shop_open($id)
    {
        if ($id == 0) {
            return 0;
        } else {
            return check_shop_open_status($id);
        }
    }




    public function check_existing_shop($shop_id)
    {
        $data = [];
        $cartItems = $this->cart->contents();
        if (!empty($cartItems)) :
            $get_shop_id = [];
            foreach ($cartItems as $key => $shop_ids) {
                $get_shop_id[] = $shop_ids['shop_id'] ?? 0;
            }
            $cartShop = $get_shop_id[0];
            if ($shop_id != $cartShop) {
                $shop_info = shop($cartShop);
                $data['shop_name'] = isset($shop_info->name) && !empty($shop_info->name) ? $shop_info->name : $shop_info->username;
                $result =  $this->load->view('common_layouts/cart_conflict_modal', $data, true);
                echo json_encode(['st' => 0, 'is_conflict' => 1, 'load_data' => $result]);
                exit();
            } else {
                return 1;
            }
        else :
            return 1;
        endif;
    }

    protected function cartInfo($id)
    {
        if ($id == 0) {
            return 0;
        } else {
            $data = [];
            $s = shop($id);
            $data['slug'] = $s->username;
            $data['shop_id'] = $id;
            $data['u_info'] = get_user_info_by_slug($s->username);
            return $this->load->view('common_layouts/cart_floating_icon', $data, true);
        }
    }


    public function insert_order_item($insertId)
    {
        $this->is__order();

        $cartItems = $this->cart->contents();
        // Cart items
        $ordItemData = array();
        $i = 0;
        foreach ($cartItems as $item) {
            if (isset($item['is_size']) && $item['is_size'] == 1) {
                $id = $item['item_id'];
                $is_size = 1;
                $size_slug = $item['sizes']['size_slug'];
            } else {
                $id = $item['item_id'];
                $is_size = 0;
                $size_slug = '';
            }

            if (isset($item['is_extras']) && $item['is_extras'] == 1) :
                $is_extras = 1;
                $extra_id = $item['extra_id'];
                $extra_qty = $item['extra_qty'];
            else :
                $is_extras = 0;
                $extra_id = '';
                $extra_qty = '';
            endif;

            $ordItemData[$i]['order_id']     = $insertId;
            $ordItemData[$i]['shop_id']     = $item['shop_id'];
            $ordItemData[$i]['item_id']     = $id;
            $ordItemData[$i]['qty']     = $item['qty'];
            $ordItemData[$i]['package_id']     = $item['is_package'] == 0 ? 0 : $item['id'];
            $ordItemData[$i]['is_package']     = $item['is_package'];
            $ordItemData[$i]['sub_total'] = $item["subtotal"];
            $ordItemData[$i]['item_price'] = $item["price"];
            $ordItemData[$i]['is_size'] = $is_size;
            $ordItemData[$i]['size_slug'] = $size_slug;
            $ordItemData[$i]['is_extras'] = $is_extras;
            $ordItemData[$i]['extra_id'] = $extra_id;
            $ordItemData[$i]['extra_qty'] = $extra_qty;
            $ordItemData[$i]['is_merge'] = !empty(auth('is_merge')) ? auth('is_merge') : 0;
            $ordItemData[$i]['merge_id'] = !empty(auth('merge_id')) ? auth('merge_id') : 0;
            $ordItemData[$i]['item_comments'] = !empty($item["item_comments"]) ? $item["item_comments"] : '';
            $ordItemData[$i]['status'] = 0;
            $ordItemData[$i]['created_at'] = d_time();

            $check_settings = shop($item['shop_id'])->stock_status;

            if (isset($check_settings) && $check_settings == 1) :
                if ($item['is_package'] == 1) :
                    $info = single_select_by_id($id, 'item_packages');
                    $up_data = ['remaining' => $info['remaining'] + $item['qty']];
                    $this->admin_m->update($up_data, $id, 'item_packages');
                else :
                    $info = single_select_by_id($id, 'items');
                    $up_data = ['remaining' => $info['remaining'] + $item['qty']];
                    $this->admin_m->update($up_data, $id, 'items');
                endif;
            endif;

            $i++;
        }
        $insert = $this->admin_m->insert_all($ordItemData, 'order_item_list');
        if ($insert) {
           
            return true;
        } else {
            return false;
        }
    }

    public function is__order()
    {
        if ($this->common_m->is_order() == 0) {
            return true;
            exit();
        }
    }

    public function error_msg($status, $msg)
    {
        if ($status == 1  || $status == 'success') {
            $msg = '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-smile"></i> ' . lang("sorry") . ' </strong> ' .  $msg . '
                </div>';
            echo json_encode(['st' => 1, 'msg' => $msg]);
            exit();
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' .  $msg . '
                </div>';
            echo json_encode(['st' => 0, 'msg' => $msg]);
            exit();
        }
    }
}
