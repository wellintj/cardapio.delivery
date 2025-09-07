<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
    protected $coupon_id;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('cart');
        if (d_auth('is_discount') == true) {
            $this->coupon_id = !empty(d_auth('coupon_id')) ? d_auth('coupon_id') : 0;
        } else {
            $this->coupon_id = 0;
        }
    }


    public function push()
    {
        $this->load->model('sms_m');
        $this->sms_m->send_smg();
        exit();
        $this->input->set_cookie('is_ring', '1', 300);
    }

    public function index($slug = '')
    {

        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['_title'] = lang('home');
        $data['page_title'] = "Profile";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_share'] = 1;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }


        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['item_limit'] = product_limit($id);

        //set language

        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        shop_default_language($id);



        $multiLang = isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang'] == 1 ? 1 : 0;
        $data['packages'] = $this->common_m->get_all_home_menu_packages($id, $limit = 3, $lang);
        $data['specialties'] = $this->common_m->get_home_specilities($id, $limit = 8, $lang);



        if (isset($data['user']['home_page_style']) && $data['user']['home_page_style'] == 2) {
            if (isset($multiLang) && $multiLang == 1) {
                $data['all_items'] = $this->admin_m->get_all_items_by_user_ln($id, $limit = 0, product_limit($id), $isHome = 1, $lang);
                $data['categories'] = $this->common_m->get_my_categories($id, $lang, $packageItem_limit = 0);
            } else {
                $data['all_items'] = $this->common_m->get_all_items_by_user($id, $limit = 0, product_limit($id), $isHome = 1);
                $data['categories'] = $this->admin_m->get_my_menu_type($id, $packageItem_limit = 0);
            };
        } else {
            $data['item_list'] = $this->common_m->get_featured_items($data['shop_id'], $lang);
            $data['popular_items'] = $this->common_m->get_popular_items($data['shop_id'], $lang);
            $data['categories'] = $this->common_m->get_categories($id, $lang);
        }


        if (isset($_GET['table']) && !empty($_GET['table'])) {
            $s_array = ['is_table' => 1, 'table_no' => $_GET['table'], 'shop_id' => $id];
            $this->session->set_tempdata('temp_data', $s_array, 700);
        }



        if (is_feature($id, 'welcome') == 1 && is_active($id, 'welcome')) :
            $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/home', $data, true);
            $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
        else :
            redirect(base_url('menu/' . $slug));
        endif;

        if (!empty($id)) {
            $this->load->helper('cookie');
            $this->common_m->count_post_hit($id, 'users');
        }
    }


    public function menu($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['_title'] = lang('menu');
        $data['page_title'] = "Menus";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_share'] = 1;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        //set language
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;

        shop_default_language($id);


        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['item_limit'] = product_limit($id);

        $multiLang = isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang'] == 1 ? 1 : 0;


        if (isset($multiLang) && $multiLang == 1) {
            $data['all_items'] = $this->admin_m->get_all_items_by_user_ln($id, $packageItem_limit = 0, product_limit($id), $lang);
            $data['cat_list'] = $this->common_m->get_my_categories($id, $lang, $packageItem_limit = 0);
        } else {
            $data['all_items'] = $this->admin_m->get_all_items_by_user($id, $packageItem_limit = 0, product_limit($id));
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, $packageItem_limit = 0);
        }

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/single_menu', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }


    public function packages($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();

        $data['_title'] = lang('package');
        $data['page_title'] = "Packages";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        //set language
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        shop_default_language($id);


        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['packages'] = $this->common_m->get_all_menu_packages($id, $packageItem_limit = 0, $lang);
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/single_packages', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function specialities($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('specialiaties');
        $data['page_title'] = "Specialties";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }


        //set language
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        shop_default_language($id);


        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['specialties'] = $this->common_m->get_specilities($id, $packageItem_limit = 0, $lang);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/single_special', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function single($slug = '', $cat_id = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['_title'] = lang('menu');
        $data['page_title'] = "Item";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['cat_id'] = $cat_id;
        $data['is_search'] = true;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        //set language
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        shop_default_language($id);


        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $multiLang = isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang'] == 1 ? 1 : 0;

        if (isset($multiLang) && $multiLang == 1) :
            $data['cat_info'] = $this->common_m->get_cat_info_by_id_ln($id, $cat_id, $lang);
        else :
            $data['cat_info'] = $this->common_m->get_cat_info_by_id($id, $cat_id);
        endif;
        // pagination
        $config = [];
        $this->load->library('pagination');

        $per_page = $this->per_page($id);
        if (isset($multiLang) && $multiLang == 1) :
            $total = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, $packageItem_limit = 0, 0, 0, $is_total = 1, $lang);
        else :
            $total = $this->common_m->get_item_by_cat_id($id, $cat_id, $packageItem_limit = 0, 0, 0, $is_total = 1);
        endif;

        $config['base_url'] = base_url('profile/ajax_pagination/' . $slug . '/' . $cat_id);
        $config['total_rows'] = $total;
        $config['per_page'] =  $per_page;
        $this->pagination->initialize($config);

        if (!empty($data['cat_info'])) :
            if (isset($multiLang) && $multiLang == 1) :
                $data['item_list'] = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, $packageItem_limit = 0, $per_page, 0, 0, $lang);
            else :
                $data['item_list'] = $this->common_m->get_item_by_cat_id($id, $cat_id, $packageItem_limit = 0, $per_page, 0, 0);

            endif;
            if (__sub($id) == 1) :
                $data['sub_category_list'] = $this->admin_m->get_subcategories_by_cat_id($data['cat_info']['category_id'], $data['shop_id'], $lang);
            endif;
        else :
            $data['item_list'] = [];
            $data['sub_category_list'] = [];
        endif;

        if (isset($multiLang) && $multiLang == 1) {
            $data['cat_list'] = $this->common_m->get_my_categories($id, $lang, $packageItem_limit = 0);
        } else {
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, $packageItem_limit = 0);
        }
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/single_category', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }



    public function subcategory($slug = '', $sub_category_id = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Item";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['sub_category_id'] = $sub_category_id;
        $data['is_search'] = TRUE;
        $data['is_footer'] = TRUE;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $lang =  $this->load_restaurant_language($id);
        $data['lang'] = $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], TRUE);

        if (__sub($id) == 0) {
            redirect(base_url($slug));
        }

        $multiLang = isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang'] == 1 ? 1 : 0;


        $sub_cat_info = $this->common_m->sub_category_details($id, $sub_category_id, $is_md5 = true, $lang);

        if (empty($sub_cat_info)) {
            redirect(base_url('error-404'));
        }

        $cat_id = md5($sub_cat_info->category_id);
        $data['cat_id'] = $cat_id;

        if (isset($multiLang) && $multiLang == 1) :
            $data['cat_info'] = $this->common_m->get_cat_info_by_id_ln($id, $cat_id, $lang);
        else :
            $data['cat_info'] = $this->common_m->get_cat_info_by_id($id, $cat_id);
        endif;


        // pagination
        $config = [];
        $this->load->library('pagination');



        $per_page = $this->per_page($id);
        $total = $this->common_m->get_item_by_sub_cat_id($id, $cat_id, $sub_category_id, limit($id, 1), 0, 0, $is_total = 1, $lang);
        $config['base_url'] = base_url('profile/ajax_pagination/' . $slug . '/' . $cat_id);
        $config['total_rows'] = $total;
        $config['per_page'] =  $per_page;
        $this->pagination->initialize($config);

        if (!empty($data['cat_info'])) :
            $data['sub_category_list'] = $this->admin_m->get_subcategories_by_cat_id($data['cat_info']['category_id'], $data['shop_id'], $lang);
            $data['item_list'] = $this->common_m->get_item_by_sub_cat_id($id, $cat_id, $sub_category_id, limit($id, 1), $per_page, 0, 0, $lang);
        else :
            $data['sub_category_list'] = [];
            $data['item_list'] = [];
        endif;

        if (isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang'] == 1) {
            $data['cat_list'] = $this->common_m->get_my_categories($id, $lang, limit($id, 1));
        } else {
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, limit($id, 1));
        }
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/single_category', $data, TRUE);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }


    public function ajax_pagination($slug = '', $cat_id = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['slug'] = $slug;
        $data['cat_id'] = $cat_id;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;

        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['cat_info'] = $this->common_m->get_cat_info_by_id($id, $cat_id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $multiLang = isset($data['shop']['is_multi_lang']) && $data['shop']['is_multi_lang'] == 1 ? 1 : 0;

        //pagination
        $config = [];
        $this->load->library('pagination');
        $per_page = $this->per_page($id);;

        $page = $this->input->get('page');
        if (empty($page)) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }
        $offset = ceil($page * $per_page);



        if (isset($multiLang) && $multiLang == 1) {
            $total = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, $packageItem_limit = 0, 0, 0, $is_total = 1, $lang);
        } else {
            $total = $this->common_m->get_item_by_cat_id($id, $cat_id, $packageItem_limit = 0, 0, 0, $is_total = 1);
        }
        $config['base_url'] = base_url('profile/ajax_pagination/' . $slug . '/' . $cat_id);
        $config['total_rows'] = $total;
        $config['per_page'] =  $per_page;
        $this->pagination->initialize($config);




        if (isset($multiLang) && $multiLang == 1) {
            $data['item_list'] = $this->common_m->get_item_by_cat_id_ln($id, $cat_id, $packageItem_limit = 0, $per_page, $offset, 0, $lang);
            $data['cat_list'] = $this->common_m->get_my_categories($id, $lang, $packageItem_limit = 0);
        } else {
            $data['cat_list'] = $this->admin_m->get_my_menu_type($id, $packageItem_limit = 0);
            $data['item_list'] = $this->common_m->get_item_by_cat_id($id, $cat_id, $packageItem_limit = 0, $per_page, $offset, 0);
        }


        $result = $this->load->view(get_view_layouts_by_slug($slug) . '/include/ajax_single_item_list', $data, true);
        echo json_encode(array('st' => 1, 'result' => $result));
    }


    public function item_details($id, $type = 'item')
    {
        $data = array();
        if ($type == 'item') :
            $data['discount_offer'] = isset($_GET['d']) ? $_GET['d'] : 0;
            $data['item'] = $this->common_m->get_single_items($id);
            if (!empty($data['item']->shop_id)) :
                $data['shop_info'] = $this->admin_m->get_shop_info($data['item']->shop_id);
                $data['shop_id'] = $data['item']->shop_id;
                $data['url'] =  base_url('profile/add_to_cart_form');
                $data['class'] = 'cart_form';
            else :
                $data['shop_info'] = [];
                $data['shop_id'] = '';
                $data['url'] =  base_url('profile/add_to_cart_form');
                $data['class'] = 'cart_form';
            endif;
            $data['extrasList'] = $this->admin_m->get_my_addons($id, $data['shop_id']);

            if (empty($data['extrasList'])) {
                $data['extras'] = $this->common_m->get_extras($id);
            }

            $item = $this->load->view('layouts/ajax_item_details_modal', $data, true);
        else :
            $data['item'] = $this->common_m->get_single_package_specilities($id)[0];
            $item = $this->load->view('layouts/ajax_package_special_details_modal', $data, true);
        endif;

        echo json_encode(['st' => 1, 'load_data' => $item]);
    }

    public function single_item($id, $type = 'item')
    {
        $data = [];
        $data['_title'] = lang('item');
        $data['page_title'] = 'Single Item';
        $data = array();
        // $id = $this->common_m->get_id_by_uid($uid, 'items');
        if ($type == 'item') :
            $data['item'] = $this->common_m->get_single_items($id);
            if (!empty($data['item']->shop_id)) :
                $lang = @$this->load_restaurant_language($data['item']->user_id ?? 0);
                $data['shop_info'] = $this->admin_m->get_shop_info($data['item']->shop_id);
                $data['shop_id'] = $data['item']->shop_id;
                $slug = $data['shop_info']->username;
                $data['url'] =  base_url('profile/add_to_cart_form');
                $data['class'] = 'cart_form';
            else :
                $data['shop_info'] = [];
                $data['shop_id'] = '';
                $slug = '';
                $data['url'] =  base_url('profile/add_to_cart_form');
                $data['class'] = 'cart_form';
            endif;
            $data['extrasList'] = $this->admin_m->get_my_addons($id, $data['shop_id']);
            if (empty($data['extrasList'])) {
                $data['extras'] = $this->common_m->get_extras($id);
            }

        endif;

        $data['slug'] = $slug;
        $data['is_share'] = 0;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($data['slug']) && empty($data['item'])) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['main_content'] =  $this->load->view('layouts/item_details', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function check_existing_shop($shop_id)
    {
        $data = [];
        $cartItems = $this->cart->contents();
        if (!empty($cartItems)) :
            $get_shop_id = [];
            foreach ($cartItems as $key => $shop_ids) {
                $get_shop_id[] = $shop_ids['shop_id'];
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
    protected function is_shop_open($id)
    {
        if ($id == 0) {
            return 0;
        } else {
            return check_shop_open_status($id);
        }
    }

    public function add_to_cart($id, $type = '')
    {
        $this->load->model('cart_m');
        $response =  $this->cart_m->__cart($id, $type);
        echo $response;
        exit();
    }

    // only extras / non variants
    public function add_to_cart_item_form()
    {
        $this->load->model('cart_m');
        $response =  $this->cart_m->__cart();
        echo $response;
        exit();
    }


    // variants form
    public function add_to_cart_form()
    {
        $this->load->model('cart_m');
        $response =  $this->cart_m->__cart();
        echo $response;
        exit();
    }

    public function update_cart_item($rowid, $qty)
    {
        $data =  array();
        $data = array(
            'rowid' => $rowid,
            'qty' => $qty
        );
        $update = $this->cart->update($data);;

        if ($update) {
            $data['shop_id'] = __cartShopID();
            $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
            $data['lang'] = $lang;
            $data['qty'] = $this->cart->total_items();
            $count = $this->cartInfo(__cart()->shop_id); // cart floating icon 
            $price = $this->cart->format_number($this->cart->total());
            $item = $this->load->view('layouts/ajax_cart_item', $data, true);
            $order_item = $this->load->view('layouts/ajax_checkout_order_modal', $data, true);
            $checkout_items = $this->load->view('layouts/checkout_content', $data, true);
            $load_qty = $this->load->view('common_layouts/cartCount', $data, true);
            $notify = $this->load->view('layouts/ajax_add_to_cart_notify', $data, true);
            echo json_encode(['st' => 1, 'load_data' => $item, 'order_item' => $order_item, 'total_item' => $count, 'total_price' => $price, 'checkout_items' => $checkout_items, 'qty' => $load_qty, 'notify' => $notify]);
        }
    }


    public function show_order_modal()
    {
        if (ACTIVATE == 0) {
            return false;
            exit();
        }
        $data = array();
        $price = $this->cart->format_number($this->cart->total());
        $count = $this->cart->total_items();
        $item = $this->load->view('layouts/ajax_checkout_order_modal', $data, true);

        echo json_encode(['st' => 1, 'load_data' => $item, 'total_item' => $count, 'total_price' => $price]);
    }

    function remove_cart_item($id)
    {
        $data = array(
            'rowid' => $id,
            'qty' => 0,
        );
        $this->cart->update($data);
        $data['shop_id'] = __cartShopID();
        $data['qty'] = $this->cart->total_items();
        $count = $this->cartInfo(__cart()->shop_id);
        $price = $this->cart->format_number($this->cart->total());
        $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
        $data['lang'] = $lang;
        $item = $this->load->view('layouts/ajax_cart_item', $data, true);
        $order_item = $this->load->view('layouts/ajax_checkout_order_modal', $data, true);
        $checkout_items = $this->load->view('layouts/checkout_content', $data, true);
        $load_qty = $this->load->view('common_layouts/cartCount', $data, true);
        $notify = $this->load->view('layouts/ajax_add_to_cart_notify', $data, true);
        echo json_encode(['st' => 1, 'load_data' => $item, 'order_item' => $order_item, 'total_item' => $count, 'total_price' => $price, 'checkout_items' => $checkout_items, 'qty' => $load_qty, 'notify' => $notify]);
    }

    public function payment($slug = '')
    {
        $slug = custom_domain($this->url, $slug);

        $data = array();

        $data['_title'] = lang('checkout');
        $data['page_title'] = "Payment Gateway";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        if (isset($_GET['paymentID']) && !empty($_GET['paymentID'])) {
            $data['order_details'] = $this->admin_m->single_select_by_uid($_GET['paymentID'], 'order_user_list');
            if (!empty($data['order_details'])) :
                $data['item_list'] = $this->admin_m->get_item_list_by_order_id($data['order_details']['id'], $data['shop']['id']);

            endif;

            $this->session->set_userdata(['payment' => $data['order_details'], 'is_paymentLink' => 1]);
        }

        $data['main_content'] = $this->load->view('payment/payment_gateway', $data, true);
        $this->load->view('payment_index', $data);
    }

    public function checkout($slug = '', $order_id = null)
    {
        $slug = custom_domain($this->url, $slug);
        if (ACTIVATE == 0) {
            return false;
            exit();
        }
        $data = array();

        $data['_title'] = lang('checkout');
        $data['page_title'] = 'Checkout';
        $data['slug'] = $slug;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        if (check_shop_open_status($data['shop_id']) == 0) :
            redirect(base_url('error-404'));
        endif;
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/checkout_page', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }





    public function order_success($slug = '', $order_id = null)
    {
        $this->load->model('order_m');
        $slug = custom_domain($this->url, $slug);
        if (ACTIVATE == 0) {
            return false;
            exit();
        }
        $id = get_id_by_slug($slug);
        if (empty($id)) {
            redirect(base_url('error-404'));
        }


        $data = [];

        $data = [
            '_title' => lang('checkout'),
            'page_title' => 'Checkout',
            'slug' => $slug,
            'is_footer' => true,
        ];


        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['id'] =  $id;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['shop_info'] = $this->common_m->get_restaurant_info_by_id($data['shop_id']);

        if (empty($order_id)) :
            $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/checkout_page', $data, true);
            $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
        endif;


        if (!empty($order_id)) :
            $check = $this->common_m->check_order($data['shop_id'], $order_id);
            if (!$check || empty($check['result'])) {
                redirect(base_url('error-404'));
            }

            $orderData = $check['result'];
            $data['order_id'] = $orderData['uid'];
            $data['qr_link'] = $this->order_m->handleQrCode($orderData, $data);
            $data['is_whatsapp'] = $this->order_m->checkWhatsappAvailability($orderData, $data['shop']);
            $data['track_link'] = url('my-orders/' . $data['shop_info']['username'] . '?phone=' . $orderData['phone'] . '&orderId=' . $order_id);

            $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/order_success_page', $data, true);
            $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
            $this->common_m->clear_auth_data();
        endif;
    }

    // add order action


    public function add_order($type = 1)
    {
        if (ACTIVATE == 0) {
            return false;
            exit();
        }

        try {
            $is_new_order = 1;
            $this->load->model(['security_m', 'order_m', 'order_merge_m']);

            // Get cart details
            $cartDetails = $this->order_m->get_cart_details();
            if (empty($cartDetails['items'])) {
                $msg = lang('cart_empty');
                echo json_encode(['st' => 2, 'msg' => $msg, 'url' => $_SERVER['HTTP_REFERER']]);
                exit();
            }
            $order_type = $this->input->post('order_type', true);

            $is_guest_login = $this->input->post('is_guest_login', true);
            $shop_info = $this->common_m->shop_info($cartDetails['shop_id']);


            // Form validation
            if (!$this->order_m->validate_order_form($shop_info, $is_guest_login)) {
                $this->cart_m->error_msg('error', validation_errors());
            }



            // Calculate prices
            $prices = $this->order_m->calculate_order_prices(
                $this->cart->total(),
                $shop_info,
                $cartDetails['tax_details']
            );

            // Get customer data

            $customer_data = $this->order_m->get_customer_data($shop_info, $is_guest_login);

            if (in_array($shop_info['is_customer_login'], [1, 2, 3]) && !$customer_data) {
                $this->cart_m->error_msg('error', __('customer_info_not_found'));
            }


            $check_limit = $this->security_m->check_limit('checkout');

            if ($check_limit == false) {
                $this->cart_m->error_msg('error', __('too_many_attempts_please_try_later'));
                exit();
            }





            $inputData = $this->input->post(null, true);
            // Prepare order data
            $order_data = $this->order_m->prepare_order_data($inputData, $shop_info, $prices, $customer_data);



            // Check if PIX Dinâmico - needs order creation BEFORE redirect
            $method = $this->input->post('method');
            $is_pix_dinamico = ($method === 'mercado_pix' && $this->input->post('use_payment') == 1);

            // For PIX Dinâmico, create order first, then redirect
            if ($is_pix_dinamico) {
                // Create order first
                $insert = $this->order_m->create_order($order_data);

                if ($insert) {
                    // Send order email
                    $this->user_email_m->send_order_mail($order_data['uid'], 0);
                    $this->order_m->order_info($insert, $order_data, 1);

                    // Now redirect to PIX payment page
                    $redirect_url = base_url('payment-pix/' . $shop_info['username'] . '/' . $order_data['uid']);
                    echo json_encode(['st' => 2, 'url' => $redirect_url]);
                    exit();
                } else {
                    $this->cart_m->error_msg('error', __('error_msg'));
                }
            }

            // Check payment redirect for other payment methods
            if ($this->order_m->should_redirect_payment($order_data)) {
                $redirect_url = $this->order_m->get_payment_redirect_url($shop_info, $order_data);
                echo json_encode(['st' => 2, 'url' => $redirect_url]);
                exit();
            }

            $mergeData = $this->order_merge_m->handle_order_merge(
                $shop_info,
                $order_data,
                $customer_data,
                $prices
            );

            // Handle merge confirmation response if needed
            if (isset($mergeData['st']) && $mergeData['st'] == 3) {
                echo json_encode($mergeData);
                exit();
            }


            // If order was merged, use merged data
            if (isset($mergeData['merged_data']) && is_array($mergeData['merged_data'])) {
                $order_data = $mergeData['merged_data'];
                $is_new_order = isset($mergeData['is_new_order']) ? $mergeData['is_new_order'] : 1;
                $insert = isset($mergeData['merge_id']) ? $mergeData['merge_id'] : 0;
            }





            if ($is_new_order == 1) {
                $insert =   $this->order_m->create_order($order_data);
            }



            if ($insert) {
                $this->user_email_m->send_order_mail($order_data['uid'], 0);
                $this->order_m->order_info($insert, $order_data, $type);
                $link = base_url('order-success/' . $shop_info['username'] . '/' . $order_data['uid']);
                echo json_encode(['st' => 1, 'link' => $link]);
                exit();
            } else {
                $this->cart_m->error_msg('error', __('error_msg'));
            }
        } catch (Exception $e) {
            $this->cart_m->error_msg('error', $e->getMessage());
        }
    }













    public function destroy_cart()
    {
        $this->cart->destroy();
        echo json_encode(['st' => 1]);
    }

    public function clear_cart()
    {
        $this->cart->destroy();
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function number_check($val)
    {
        if (!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $val)) {
            $this->form_validation->set_message('number_check', 'The {field} field must be a number or decimal.');
            return false;
        } else {
            return true;
        }
    }


    /**
     ** home page contact mail
     **/
    public function send_mail()
    {
        is_test();
        $this->form_validation->set_rules('name', 'your Name', 'trim|xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' . validation_errors() . '
            </div>';
            echo json_encode(['st' => 0, 'msg' => $msg]);
        } else {
            if (isset($_POST)) :
                $setting = settings();

                if (isset($setting['is_recaptcha']) && $setting['is_recaptcha'] == 1) :
                    if ($this->recaptcha() == false) {
                        $msg = '<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' . lang("robot_verification_failed") . '
                        </div>';
                        echo json_encode(array('st' => 0, 'msg' => $msg));
                        exit();
                    }
                endif;


                $user_id = base64_decode($this->input->post('id', true));
                $setting = $this->common_m->get_user_settings($user_id);
                $site_setting = settings();
                $this->load->library('email');
                //SMTP & mail configuration
                if ($setting['email_type'] == 2 && isset($setting['smtp_config'])) :
                    $smtp = json_decode($setting['smtp_config'], true);
                    $config = array(
                        'protocol'  => 'smtp',
                        'smtp_host' => !empty($smtp['smtp_host']) ? $smtp['smtp_host'] : 'smtp.gmail.com',
                        'smtp_port' => !empty($smtp['smtp_port']) ? $smtp['smtp_port'] : 465,
                        'smtp_user' => $setting['smtp_mail'],
                        'smtp_pass' => !empty($smtp['smtp_password']) ? base64_decode($smtp['smtp_password']) : '',
                        'smtp_crypto' => $smtp['smtp_port'] == 465 || $smtp['smtp_port'] == 25 ? 'ssl' : 'tls',
                        'mailtype'  => 'html',
                        'charset'   => 'utf-8',
                        'smtp_timeout' => 30
                    );
                    $this->email->initialize($config);
                endif;
                $this->email->set_mailtype("html");
                $this->email->set_newline("\r\n");

                $mail_array = array();
                $mail_array['name'] = $this->input->post('name', true);
                $mail_array['subject'] = $this->input->post('subjects', true);
                $mail_array['email'] = $this->input->post('email', true);
                $mail_array['message'] = $this->input->post('msg', true);

                $mail_body = $this->load->view('frontend/inc/mail_body', $mail_array, true);
                $this->email->to($setting['smtp_mail']);
                $this->email->from($this->input->post('email', true), $site_setting['site_name']);
                $this->email->subject($this->input->post('subjects', true));
                $this->email->message($mail_body);
                //Send email
                $send = $this->email->send();
                if ($send) {
                    $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <p><strong>' . lang("success") . ' </strong>' . lang("mail_send_successfully") . '</p>
                    </div>';
                    echo json_encode(array('st' => 1, 'msg' => $msg));
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <p><strong>' . lang("sorry") . ' </strong>' . lang("error_text") . '</p>
                    </div>';
                    echo json_encode(array('st' => 0, 'msg' => $msg));
                }
            endif;
        }
    }

    public function track_order($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('track_order');
        $data['page_title'] = "Track Order";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/track_order', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function track_order_list($slug)
    {
        $this->form_validation->set_rules('phone', lang("phone"), 'trim|xss_clean');
        $this->form_validation->set_rules('order_id', lang("order_id"), 'trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><strong>' . lang("sorry") . ' </strong>' . validation_errors() . '</p>
            </div>';
            echo json_encode(['st' => 0, 'msg' => $msg]);
        } else {
            if (empty($this->input->post('phone')) && empty($this->input->post('order_id'))) {
                __request('', 0);
                exit();
            }
            $data = [];
            $data['page_title'] = "Track Order";
            $data['page'] = "Profile";
            $data['slug'] = $slug;

            $this->load->library('pagination');

            $phone = $this->input->post('phone', true);
            $order_id = $this->input->post('order_id', true);
            $shop_id = base64_decode($this->input->post('shop_id', true));
            if (isset($order_id) & !empty($order_id)) {
                $order_id = $order_id;
            } else {
                $order_id = 0;
            }

            $pin_number = $this->input->post('pin_number', true);
            if (shop($shop_id)->is_pin == 1) :
                $check_pin = $this->common_m->check_pin($shop_id, $pin_number);
            else :
                $check_pin = 1;
            endif;

            if ($check_pin == 1) :
                $data['phone'] = $phone;
                $data['order_id'] = $order_id;

                $id = get_id_by_slug($slug);
                $data['id'] = $id;
                if (empty($id)) {
                    redirect(base_url('error-404'));
                }
                $lang = $this->load_restaurant_language($id);
                $data['lang'] = $lang;
                $data['user'] = $this->admin_m->get_profile_info($id);
                $data['shop'] = $this->admin_m->get_restaurant_info($id);
                $data['order_list'] = $this->common_m->track_order($phone, $order_id, $shop_id);

                $item = $this->load->view('layouts/ajax_track_order_list', $data, true);
                echo json_encode(['st' => 1, 'load_data' => $item]);
            else :
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-frown"></i>' . lang('sorry') . '! </strong> ' . lang('security_pin_not_match') . '
                </div>';
                echo json_encode(['st' => 0, 'msg' => $msg]);
            endif;
        }
    }





    public function all_orders($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('all_order');
        $data['page_title'] = "All Orders";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = false;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['page'] = "Profile";
        $data['slug'] = $slug;


        if (isset($_GET)) {

            $phone = $_GET['phone'];
            $order_id = !empty($_GET['orderId']) ? $_GET['orderId'] : 0;
            $shop_id = restaurant($id)->id;

            //pagination
            $config = [];
            $this->load->library('pagination');
            $per_page = $this->per_page($id);

            $page = $this->input->get('page');
            if (empty($page)) {
                $page = 0;
            }

            if ($page != 0) {
                $page = $page - 1;
            }
            $offset = ceil($page * $per_page);


            $total = $this->common_m->track_all_orders($phone, $shop_id, $order_id, 0, 0, $is_total = 1);
            $config['base_url'] = base_url('my-orders/' . $slug);
            $config['total_rows'] = $total;
            $config['per_page'] =  $per_page;
            $this->pagination->initialize($config);



            $data['order_list'] = $this->common_m->track_all_orders($phone, $shop_id, $order_id, $per_page, $offset, 0);
            $data['phone'] = $phone;
        }
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/track_order_list', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function get_time_by_date($id, $user_id)
    {
        $lang = $this->load_restaurant_language($user_id);
        $data['lang'] = $lang;
        $time = $this->common_m->get_time_using_id($id, $user_id);
        echo json_encode(['st' => 1, 'end_time' => $time['end_time'], 'start_time' => $time['start_time']]);
    }


    public function contacts($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('contacts');
        $data['page_title'] = "Contacts";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);


        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/contact', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }




    public function about($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('about');
        $data['page_title'] = "About";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/about', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }


    public function reservation($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('reservation');
        $data['page_title'] = "Reservision";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['reservation_types'] = $this->common_m->get_all_by_shop_id(restaurant($id)->id, 'reservation_types');

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/reservation', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function qr_menu($slug = '', $m_id = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Single Menu";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['packages'] = $this->common_m->get_single_qr_menu_by_id($m_id);
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/qr_menu', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }



    public function error_404()
    {
        $data = array();
        $data['page_title'] = "Error 404";
        $this->load->view('404');
    }

    public function count_copy($id)
    {
        $user = single_select_by_id($id, 'users');
        $data = array(
            'share_link' => $user['share_link'] + 1,
        );
        $this->common_m->update($data, $id, 'users');
        echo json_encode(['st' => 1]);
    }


    public function remove_customer_login()
    {
        $this->session->unset_userdata(['is_customer', 'customer_info']);
        echo json_encode(['st' => 1]);
    }

    public function add_reservation()
    {
        $this->form_validation->set_rules('name', lang("your_name"), 'trim|xss_clean|required');
        $this->form_validation->set_rules('email', lang('email'), 'trim|xss_clean|valid_email|required');
        $this->form_validation->set_rules('phone', lang("phone"), 'trim|xss_clean|required');
        $this->form_validation->set_rules('total_guest', lang('number_of_guest'), 'trim|xss_clean|required');
        $this->form_validation->set_rules('is_table', lang('table_reservation'), 'trim|xss_clean|required');
        $this->form_validation->set_rules('reservation_date', lang('reservation_date'), 'trim|xss_clean|required');
        $this->form_validation->set_rules('reservation_type', lang('reservation_type'), 'trim|xss_clean|required');
        $this->form_validation->set_rules('comments', lang("any_special_request"), 'trim|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' . validation_errors() . '
            </div>';
            echo json_encode(['st' => 0, 'msg' => $msg]);
        } else {

            $check_limit = $this->security_m->check_limit('reservation');

            if ($check_limit == false) {
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' . __('too_many_attempts_please_try_later') . '
                </div>';
                echo json_encode(['st' => 0, 'msg' => $msg]);
                exit();
            }


            if (isset($this->setting['is_recaptcha']) && $this->setting['is_recaptcha'] == 1) :
                if ($this->recaptcha() == false) {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' . lang("robot_verification_failed") . '
                    </div>';
                    echo json_encode(array('st' => 0, 'msg' => $msg));
                    exit();
                }
            endif;



            $email = $this->input->post('email', true);
            $name = $this->input->post('name', true);
            $phone = $this->input->post('phone', true);
            $total_guest = $this->input->post('total_guest', true);
            $is_table = $this->input->post('is_table', true);
            $reservation_date = $this->input->post('reservation_date', true);
            $reservation_type = $this->input->post('reservation_type', true);
            $comments = $this->input->post('comments', true);
            $shop_id = base64_decode($this->input->post('shop_id'));

            $data = [
                'uid' => $shop_id . random_string('numeric', 5) . $shop_id,
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'total_person' => $total_guest,
                'is_table' => $is_table,
                'reservation_date' => $reservation_date,
                'reservation_type' => $reservation_type,
                'comments' => $comments,
                'order_type' => 3,
                'shop_id' => $shop_id,
                'is_ring' => 1,
                'is_confirm' => 0,
                'created_at' => d_time(),
            ];
            $insert = $this->common_m->insert($data, 'order_user_list');
            if ($insert) {
                $this->user_email_m->send_reservation_mail($data['uid'], $status = 0);
                $msg = '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><strong>' . lang("success") . ' </strong>' . lang("order_confirmed") . '</p>
                </div>';
                echo json_encode(array('st' => 1, 'msg' => $msg));
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <p><strong>' . lang("sorry") . '</strong>' . lang("error_text") . '</p>
                </div>';
                echo json_encode(array('st' => 0, 'msg' => $msg));
            }
        }
    }


    public function add_qr_order($id)
    {

        $items = $this->common_m->get_single_qr_menu_by_id($id);
        /* Get shop_id from Cart*/
        if (!empty(auth('qr_order')['item_id']) && auth('qr_order')['item_id'] == $id) {
            $check = $this->common_m->get_order_status_by_order_id(auth('qr_order')['order_id']);
            if ($check->status == 1 || $check->status == 0) :
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-frown"></i> ! </strong> ' . lang('order_running_msg') . '
                </div>';
                echo json_encode(['st' => 0, 'msg' => $msg]);

                exit();
            elseif ($check->status == 2) :
                $this->session->unset_userdata('qr_order');
            endif;
        }


        $order_id = date('Y') . random_string('numeric', 6);
        $token_number = date('d') . '-' . random_string('numeric', 2);
        $data = array(
            'uid' => $order_id,
            'token_number' => $token_number,
            'order_type' => 7,
            'dine_id' => $items[0]['package_id'],
            'total_person' => 0,
            'table_no' => !empty($items[0]['table_no']) || $items[0]['table_no'] != 0 ? $items[0]['table_no'] : 0,
            'shop_id' => $items[0]['shop_id'],
            'is_ring' => 1,
            'status' => 0,
            'total' => $items[0]['final_price'],
            'created_at' => d_time(),
        );

        $insert = $this->admin_m->insert($data, 'order_user_list');
        // $insert = 1;
        if ($insert) {
            $this->version_changes_m->pusher($data['shop_id'], 'new_table_order');

            $s_array = array('order_id' => $insert, 'token_number' => $token_number, 'item_id' => $id);
            $this->session->set_userdata('qr_order', $s_array);
            if (shop($items[0]['shop_id'])->is_kds == 1) :
                $msg = '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h4>' . lang('token_number') . ': ' . $token_number . '</h4>
                <strong><i class="fas fa-smile"></i> ' . lang('congratulations') . ' </strong> ' . lang('order_place_successfully') . '
                <p> <strong>' . lang('order_number') . '</strong> #' . $order_id . '.</p>
                <p>' . lang('please_wait_msg') . '.</p>
                <a href=' . base_url('admin/kds/live/' . md5($items[0]['shop_id'])) . '>' . lang('track_order') . '.</a>
                </div>';
            else :
                $msg = '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h4>' . lang('token_number') . ': ' . $token_number . '</h4>
                <strong><i class="fas fa-smile"></i> ' . lang('congratulations') . ' </strong> ' . lang('order_place_successfully') . '
                <p> <strong>' . lang('order_number') . '</strong> #' . $order_id . '.</p>
                <p>' . lang('please_wait_msg') . '.</p>

                </div>';
            endif;
            echo json_encode(['st' => 1, 'msg' => $msg]);
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-frown"></i> Sorry! </strong> Somethings were wrong!
            </div>';
            echo json_encode(['st' => 0, 'msg' => $msg]);
        }
    }

    public function review($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Reviews";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['reviews'] = $this->common_m->get_shop_reviews($data['shop_id']);
        $data['total_rating'] = $this->common_m->total_shop_rating($data['shop_id']);
        $data['total_review'] = $this->common_m->total_shop_rating($data['shop_id'], 'total');
        $data['main_content'] = $this->load->view('frontend/shop_review', $data, true);
        $this->load->view('user_index', $data);
    }



    public function call_waiter()
    {

        $this->form_validation->set_rules('table_no', lang('table_no'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong> ' . validation_errors() . '
            </div>';
            echo json_encode(['st' => 0, 'msg' => $msg]);
        } else {
            $user_id = $this->input->post('user_id', true);
            $shop_id = $this->input->post('shop_id', true);
            $table_no = $this->input->post('table_no', true);
            $pin_number = $this->input->post('pin_number', true);

            $lang = $this->load_restaurant_language($user_id);
            $data['lang'] = $lang;

            if (isset($_GET) && !empty($_GET)) {
                $check_pin = 1;
            } else {
                if (restaurant($user_id)->is_pin == 1) :
                    $check_pin = $this->common_m->check_pin($shop_id, $pin_number);
                else :
                    $check_pin = 1;
                endif;
            }


            if ($check_pin == 1) :
                $check = $this->common_m->check_waiter_status($table_no, $shop_id);
                if ($check == 1) {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><i class="fas fa-frown"></i> ' . lang('sorry') . '! </strong> ' . lang('waiting_notification_msg') . '
                    </div>';
                    echo json_encode(['st' => 0, 'msg' => $msg]);
                    exit();
                }

                $data = array(
                    'table_no' => $table_no,
                    'user_id' => $user_id,
                    'shop_id' => $shop_id,
                    'is_ring' => 1,
                    'created_at' => d_time(),
                );
                $insert = $this->admin_m->insert($data, 'call_waiter_list');

                if ($insert) {
                    $this->version_changes_m->pusher($shop_id, 'call_waiter');
                    $this->system_model->call_waiter_push($insert, $data['shop_id'], 'call_waiter');
                    $msg = '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><i class="fas fa-smile"></i> ' . lang('success') . '! </strong> ' . lang("call_waiter_msg") . '
                    </div>';
                    echo json_encode(['st' => 1, 'msg' => $msg]);
                } else {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><i class="fas fa-frown"></i>' . lang('sorry') . '! </strong> ' . lang('error_msg') . '
                    </div>';
                    echo json_encode(['st' => 0, 'msg' => $msg]);
                }
            else :
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fas fa-frown"></i>' . lang('sorry') . '! </strong> ' . lang('security_pin_not_match') . '
                </div>';
                echo json_encode(['st' => 0, 'msg' => $msg]);
            endif;
        }
    }

    public function qr_waiter($slug = '')
    {
        $slug = custom_domain($this->url, $slug);



        if (isset($_GET['table']) && !empty($_GET['table'])) :
            $table_no = $_GET['table'];

            $info = $this->common_m->single_select_by_username($slug, 'restaurant_list');

            $check = $this->common_m->check_waiter_status($table_no, $info['id']);

            $lang = $this->load_restaurant_language($info['user_id']);
            $data['lang'] = $lang;

            if ($check == 1) {
                $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-frown"></i> ' . lang('sorry') . '! </strong> ' . lang('waiting_notification_msg') . '
            </div>';
                $this->session->set_flashdata('MSG', $msg);
                redirect(url("{$slug}?q=table&qr={$table_no}"));
                exit();
            }

            $data = array(
                'table_no' => $table_no,
                'user_id' => $info['user_id'],
                'shop_id' => $info['id'],
                'is_ring' => 1,
                'created_at' => d_time(),
            );

            $insert = $this->admin_m->insert($data, 'call_waiter_list');

            if ($insert) {
                $msg = '<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-smile"></i> ' . lang('success') . '! </strong> ' . lang("call_waiter_msg") . '
            </div>';
                $this->session->set_flashdata('MSG', $msg);
                redirect(url("{$slug}?q=table&qr={$table_no}"));
            } else {
                $msg = '<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><i class="fas fa-frown"></i>' . lang('sorry') . '! </strong> ' . lang('error_msg') . '
            </div>';
                $this->session->set_flashdata('MSG', $msg);
                redirect(url("{$slug}?q=table&qr={$table_no}"));
            }
        // else:
        //  $msg = '<div class="alert alert-danger alert-dismissible">
        //      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        //      <strong><i class="fas fa-frown"></i>'.lang('sorry').'! </strong> '.lang('error_msg').'
        //      </div>';
        //      $this->session->set_flashdata('msg', $msg);
        //      redirect(base_url("{$slug}?q=table"));
        endif;
    }

    public function reorder($uid)
    {

        $order_info = $this->admin_m->single_select_by_uid($uid, 'order_user_list');
        $item_details = $this->common_m->get_all_item_by_order_id($order_info['id']);

        $shopId = $order_info['shop_id'];

        if (check_shop_open_status($shopId) == 0) {
            $this->session->set_flashdata('error', !empty(lang('sorry_we_are_closed')) ? lang('sorry_we_are_closed') : 'Sorry We are close');
            redirect($_SERVER['HTTP_REFERER']);
            exit();
        }


        $searchForValue = '-';
        $stringValue = $order_info['uid'];

        if (strpos($stringValue, $searchForValue) !== false) {
            $new_id = str_replace('-', '', strstr($stringValue, '-'));
        } else {
            $new_id = $order_info['uid'];
        }
        //count total re-order with the same uid
        $ul = $this->admin_m->count_order_id($new_id);


        $new_uid = $ul . '-' . $new_id;

        if ($order_info['use_payment'] == 1 || $order_info['is_payment'] == 1) :
            $this->session->unset_userdata('payment');


            foreach ($item_details as $key => $value) :
                $item = $this->common_m->get_single_cart_items($value['item_id']);

                if ($value['is_extras'] == 1) {
                    $is_extra = $this->admin_m->check_extra_by_item_id($item['id']);
                    $is_extras = 1;
                    $extra_id = $value['extra_id'];
                    $title =  $item['title'];
                    $ids =  $item['id'] . '-' . $value['size_slug'] . '-1';
                } else {
                    $is_extras = 0;
                    $extra_id = '';
                    $title = $item['title'];
                    $ids = $item['id'] . '-' . $value['size_slug'];
                };


                $cart_data = array(
                    'id'      => $ids,
                    'item_id' => $item['id'],
                    'qty'     => $item['qty'],
                    'thumb'   => $item['thumb'],
                    'img_url'   => $item['img_url'],
                    'img_type'   => $item['img_type'],
                    'price'   => $value['item_price'],
                    'name'    => $item['title'],
                    'is_size' => $value['is_size'],
                    'is_package' => 0,
                    'shop_id' => $item['shop_id'],
                    'is_extras' => $is_extras,
                    'extra_id' => $extra_id,
                    'sizes' => ['size_slug' => $value['size_slug']]
                );
                $this->cart->insert($cart_data);
            endforeach;


            $data = array(
                'uid' => $new_uid,
                'name' => $order_info['name'],
                'email' => $order_info['email'],
                'phone' => $order_info['phone'],
                'customer_id' => $order_info['customer_id'],
                'address' => $order_info['address'],
                'delivery_area' => $order_info['delivery_area'],
                'order_type' => $order_info['order_type'],
                'total_person' => $order_info['total_person'],
                'table_no' => $order_info['table_no'],
                'reservation_date' => $order_info['reservation_date'],
                'pickup_time' => $order_info['pickup_time'],
                'pickup_date' => $order_info['pickup_date'],
                'shop_id' => $order_info['shop_id'],
                'delivery_charge' => $order_info['delivery_charge'],
                'shipping_id' => $order_info['shipping_id'],
                'is_ring' => 1,
                'pickup_point' => $order_info['pickup_point'],
                'total' => $order_info['total'],
                'comments' => $order_info['comments'],
                'tax_fee' => $order_info['tax_fee'],
                'discount' => $order_info['discount'],
                'sub_total' => $order_info['sub_total'],
                'is_coupon' => $order_info['is_coupon'],
                'use_payment' => $order_info['use_payment'],
                'coupon_percent' => $order_info['coupon_percent'],
                'tips' => $order_info['tips'],
                'created_at' => d_time(),
            );

            $this->session->set_userdata('payment', $data);
            redirect(base_url('profile/payment/' . shop($order_info['shop_id'])->username));
            exit();
        else :


            $new_arr = ['created_at' => d_time(), 'is_ring' => 1, 'status' => 0, 'uid' => $new_uid];
            $order_info_marge = array_merge($order_info, $new_arr);
            array_splice($order_info_marge, 0, 1);
            $insert = $this->common_m->insert($order_info_marge, 'order_user_list');
            if ($insert) :
                $this->version_changes_m->pusher($shopId, 'new_order');
                $order_list_arr = ['created_at' => d_time(), 'order_id' => $insert];
                foreach ($item_details as $key => $value) {
                    $parray = array_merge($value, $order_list_arr);
                    array_splice($parray, 0, 1);
                    $data[] = $parray;
                }
                $this->admin_m->insert_all($data, 'order_item_list');
                $this->upload_m->order_qr($order_info['phone'], $new_uid, $order_info['shop_id']);
            endif;
            $this->session->set_flashdata('success', !empty(lang('order_place_successfully')) ? lang('order_place_successfully') : 'Order Place Successfully!');
            redirect($_SERVER['HTTP_REFERER']);
        endif;
    }


    public function tips($id = 0, $tips = 0, $order_type = 0)
    {
        $data = [];
        $is_service_charge = 0;

        if (!empty(temp('is_shipping') == 1)) {
            $shipping = temp('cost');
            $is_shipping = 1;
        } else {
            $shipping = 0;
            $is_shipping = 0;
        }

        if (!empty(temp('coupon_price'))) {
            $coupon_price = temp('coupon_price');
        } else {
            $coupon_price = 0;
        }

        if ($order_type != 0) {
            if (!empty(temp('is_service_charge'))) {
                $is_service_charge = temp('is_service_charge');
            } else {
                $is_service_charge = $this->admin_m->__ordertype($id, $order_type, 'is_service_charge');
            }
        }




        $data['is_service_charge'] = $is_service_charge;
        $data['cost'] = $shipping;
        $data['shipping'] = $shipping;
        $data['is_shipping'] = $is_shipping;
        $data['coupon_price'] = $coupon_price;
        $data['tips'] = $tips;
        $data['shop_id'] = $id;
        $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
        $data['lang'] = $lang;
        $this->session->set_tempdata('temp_data', $data, 600);

        $load = $this->load->view('layouts/inc/checkout_total_area', $data, true);
        echo json_encode(['st' => 1, 'load_data' => $load, 'tips' => $tips, 'shipping' => $shipping, 'is_service_charge' => $is_service_charge]);
    }

    public function checkservicecharge($shop_id, $type_id)
    {
        $data = [];

        $service = $this->admin_m->__ordertype($shop_id, $type_id, 'is_service_charge');
        $data['is_service_charge'] = $service;
        $data['shop_id'] = $shop_id;
        $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
        $data['lang'] = $lang;
        $this->session->set_tempdata('temp_data', ['is_service_charge' => $service], 1700);
        $result = $this->load->view('layouts/inc/checkout_total_area', $data, TRUE);
        echo json_encode(['st' => 1, 'is_service_charge' => $service, 'load_data' => $result]);
    }

    public function shipping_address($id)
    {
        $data = [];
        $shipping  = single_select_by_id($id, 'delivery_area_list');
        $data['shop_id'] = $shipping['shop_id'];
        $data['cost'] =  $shipping['cost'];
        $data['shipping'] =  $shipping['cost'];
        $data['is_shipping'] =  1;
        $data['tips'] = !empty(temp('tips')) ? temp('tips') : 0;
        $data['is_service_charge'] = !empty(temp('is_service_charge')) ? temp('is_service_charge') : 0;
        $this->session->set_tempdata('temp_data', $data, 600);

        $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
        $data['lang'] = $lang;
        $load = $this->load->view('layouts/inc/checkout_total_area', $data, true);
        echo json_encode(['st' => 1, 'load_data' => $load, 'shipping' => $shipping['cost'], 'id' => $shipping['id'], 'is_service_charge' => $data['is_service_charge']]);
    }

    public function check_coupon_code()
    {
        $this->is__order();
        $code = strtoupper($this->input->get('coupon_code', true));
        $shop_id = $this->input->get('shop_id', true);
        $price = $this->input->get('price', true);
        $shipping_cost = $this->input->get('shipping_cost');
        $last_order_type = $this->input->get('last_order_type');
        $available = $this->admin_m->check_coupon_code($code, $shop_id);

        $lang = $this->load_restaurant_language($shop_id, 'shop_id');
        $data['lang'] = $lang;
        if (!empty($available)) {
            if ($available['total_used'] < $available['total_limit']) {
                $coupon_price = get_percent($price, $available['discount']);
                $total_price = $price - $coupon_price;
                $coupon_data = [
                    'is_discount' => true,
                    'discount' => $available['discount'],
                    'total_user' => $available['total_used'] + 1,
                    'coupon_price' => $coupon_price,
                    'coupon_id' => $available['id']
                ];



                $this->session->set_userdata('discount_ss', $coupon_data);

                if (isset($last_order_type) == "cash-on-delivery") :
                    if (isset($shipping_cost) && $shipping_cost != 0) :
                        $data['cost'] =  $shipping_cost;
                        $is_shipping = 1;
                    else :
                        $is_shipping = 0;
                    endif;
                else :
                    $is_shipping = 0;
                endif;

                $tData = ['coupon_price' => $coupon_price, 'is_shipping' => $is_shipping, 'shipping' => isset($shipping_cost) ? $shipping_cost : 0, 'tips' => !empty(temp('tips')) ? temp('tips') : 0];
                $this->session->set_tempdata('temp_data', $tData, 600);

                $data['shop_id'] = $shop_id;
                $data['coupon_price'] =  $coupon_data['coupon_price'];
                $data['coupon_details'] =  $coupon_data;

                $data['tips'] = !empty(temp('tips')) ? temp('tips') : 0;
                $load = $this->load->view('layouts/inc/checkout_total_area', $data, true);

                $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>' . lang('success') . '!</strong> ' . lang('coupon_applied_successfully') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
                echo json_encode(['st' => 1, 'load_data' => $load, 'coupon_percent' => $available['discount'], 'coupon_id' => $available['id'], 'is_shipping' => $is_shipping]);
            } else {
                $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>' . lang('sorry') . '!</strong> ' . lang('coupon_code_reached_the_max_limit') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>';
                echo json_encode(['st' => 0, 'msg' => $msg,]);
            };
        } else {
            $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>' . lang('sorry') . '</strong> ' . lang('coupon_code_not_exists') . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
            echo json_encode(['st' => 0, 'msg' => $msg,]);
        }
    }


    public function reset()
    {
        $this->session->unset_userdata('temp_data');
        echo json_encode(['st' => 1]);
    }


    public function exportcvs()
    {
        // file name
        $filename = 'users_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // get data
        $usersData = $this->admin_m->get_cvs_data();

        // file creation
        $file = fopen('php://output', 'w');

        $header = array("id", "keyword", "english", 'bn');
        fputcsv($file, $header);
        foreach ($usersData as $key => $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }


    public function recaptcha()
    {
        $settings =  settings();
        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
        $userIp = $this->input->ip_address();
        $secret = $this->settings['recaptcha']->secret_key;

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $status = json_decode($output, true);
        if ($status['success']) {
            return true;
        } else {
            return false;
        }
    }


    public function get_users($user_id, $shop_id, $auth_id)
    {
        $find = $this->common_m->find_subscribers($user_id, $shop_id);
        if ($find == 0) {
            $this->common_m->insert(['user_id' => $user_id, 'shop_id' => $shop_id, 'auth_id' => $auth_id, 'created_at' => d_time()], 'subscriber_list');
        }
        echo json_encode(['st' => 1, 'userId' => $user_id]);
    }

    /*----------------------------------------------
            Check Pickup Avaialble times
            ----------------------------------------------*/

    public function get_pickup_available_time($shop_id, $type = 1)
    {
        $restaurant = $this->admin_m->get_shop_profile_by_shop_id($shop_id);
        $time_slots = json_decode($restaurant['pickup_time_slots'], true);

        $current_date = strtotime(d_time());

        if (date('i', $current_date) <  30) {
            $currentTime = date('H', $current_date) . ':00';
        } else {
            $currentTime = date('H', $current_date) . ':30';
        }

        $nextTime = strtotime("+30 minutes", strtotime($currentTime));
        $nextTime = date('H:i', $nextTime);


        $searchTime = $currentTime . '-' . $nextTime;
        $timeslots = $time_slots;;
        $times = [];
        foreach ($timeslots as $key => $value) {
            if ($value >= $searchTime) {
                $times[] = $value;
            }
        }

        if ($type == 1) {
            $data['getTmes'] =  $times;
        } else {
            $data['getTmes'] =  $time_slots;
        }

        $data['shop_id'] = $shop_id;
        $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
        $data['lang'] = $lang;
        $load_data = $this->load->view('layouts/inc/pickupTimeslots', $data, true);

        echo json_encode(['st' => 1, 'times' => $searchTime, 'load_data' => $load_data]);
    }

    public function is__order()
    {
        if ($this->common_m->is_order() == 0) {
            return true;
            exit();
        }
    }

    /*----------------------------------------------
                GET Room Numbers by Hotel ID
                ----------------------------------------------*/

    public function get_room_numbers($hotelId)
    {
        $restaurant = $this->admin_m->single_select_by_id($hotelId, 'hotel_list');
        $data['roomNumers'] = json_decode($restaurant['room_numbers'], true);

        $data['shop_id'] = $restaurant['shop_id'];
        $lang = $this->load_restaurant_language($data['shop_id'], 'shop_id');
        $data['lang'] = $lang;
        $load_data = $this->load->view('layouts/inc/roomNumbers', $data, true);
        echo json_encode(['st' => 1, 'load_data' => $load_data]);
    }



    public function check_delivery_area($shop_id, $lat, $lang)
    {
        $st = $msg = '';
        $restaurant = shop($shop_id);
        $lang = $this->load_restaurant_language($shop_id, 'shop_id');
        $data['lang'] = $lang;
        if (isset($restaurant->is_radius) && $restaurant->is_radius == 1) :
            $radius_config = !empty($restaurant->radius_config) ? json_decode($restaurant->radius_config) : '';
            $radius = !empty($radius_config->radius) ? $radius_config->radius : 5;
            $location = [
                "lat" => $radius_config->latitude,
                "lng" => $radius_config->longitude,
            ];

            $poslat = $lat;
            $poslng = $lang;
            $get_dis = $this->distance($poslat, $poslng, $location['lat'], $location['lng'], "K");

            if ($radius >= $get_dis) {
                $latlang = 1;
            } else {
                $latlang = 0;
            };
            if ($latlang == 1) {
                $st = 1;
                $msg = $get_dis;
            } else {
                $st = 0;
                $msg = $radius_config->msg;
            }
        endif;
        echo json_encode(['st' => $st, 'msg' => $msg]);
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $radlat1 = pi() * $lat1 / 180;
        $radlat2 = pi() * $lat2 / 180;
        $theta = $lon1 - $lon2;
        $radtheta = pi() * $theta / 180;
        $dist = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);
        if ($dist > 1) {
            $dist = 1;
        }
        $dist = acos($dist);
        $dist = $dist * 180 / pi();
        $dist = $dist * 60 * 1.1515;
        if ($unit == "K") {
            $dist = $dist * 1.609344;
        }
        if ($unit == "N") {
            $dist = $dist * 0.8684;
        }
        return round($dist);
    }


    /*----------------------------------------------
                    GET PERSON BY TABLE ID
                    ----------------------------------------------*/

    public function get_person($shop_id, $table_id)
    {
        $table_size = $this->admin_m->get_table_size($table_id, $shop_id);

        $checkTable = $this->admin_m->check_booked_table($table_id, $shop_id);
        $remainTable = !empty($checkTable) ? $checkTable : 0;
        $data = '';
        if (isset($table_size) && !empty($table_size)) {
            if ($table_size > $remainTable) {
                for ($i = 1; $i <= ($table_size - $remainTable); $i++) {
                    echo  "<option value='{$i}'>{$i}</option>";
                }
                exit();
            } else {
                echo "<option value=''>" . lang('table_already_booked_try_different_one') . "</option>";;
            }
        }
    }







    public function terms($slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();
        $data['page_title'] = "Terms";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;

        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/terms', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }


    public function update_cart_sidebar($slug)
    {
        $data = [];
        $cart_id = __cart()->shop_id;
        $data['slug'] = $slug;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];

        $load_data = $this->load->view('common_layouts/cart_sidebar', $data, true);
        echo json_encode(['st' => 1, 'load_data' => $load_data]);
    }


    public function single_page($slug = '', $page_slug = '')
    {

        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Page";
        $data['page'] = "pages";
        $data['slug'] = $slug;
        $data['is_share'] = 1;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['spage'] = $this->common_m->get_my_page_by_slug($page_slug, $data['shop_id'], $lang);
        $data['seo'] = [
            'title' => !empty($data['spage']->title) ? html_escape($data['spage']->title) : $slug,
            'description' => !empty($data['spage']->details) ? $data['spage']->details : '',
            'url' => base_url('pages/' . $slug . '/' . $data['spage']->slug),
        ];
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/page', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }


    public function vendor_page($slug = '', $page_slug = '')
    {

        $slug = custom_domain($this->url, $slug);

        $data = array();
        $data['page_title'] = "Page";
        $data['page'] = "pages";
        $data['slug'] = $slug;
        $data['is_share'] = 1;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;

        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);
        $data['spage'] = $this->common_m->single_select_by_slug_row($page_slug, 'vendor_page_list');
        $data['seo'] = [
            'title' => !empty($data['spage']->title) ? html_escape($data['spage']->title) : $slug,
            'description' => !empty($data['spage']->details) ? $data['spage']->details : '',
            'url' => base_url('pages/' . $slug . '/' . $data['spage']->slug),
        ];
        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/page', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }


    protected function per_page($id)
    {

        $user_settings = $this->common_m->get_user_settings($id);
        $apps = @!empty($user_settings['extra_config']) ? json_decode($user_settings['extra_config']) : '';
        return $per_page = isset($apps->pagination_limit) && !empty($apps->pagination_limit) ? $apps->pagination_limit : 12;
    }




    public function offers($slug = '', $offer_slug = '')
    {
        $slug = custom_domain($this->url, $slug);
        $data = array();

        $data['_title'] = lang('offers');
        $data['page_title'] = "Offers";
        $data['page'] = "Profile";
        $data['slug'] = $slug;
        $data['is_footer'] = true;
        $id = get_id_by_slug($slug);
        $data['id'] = $id;
        if (empty($id)) {
            redirect(base_url('error-404'));
        }
        $this->load_restaurant_language($id);
        $lang = $this->current_language;
        $data['lang'] =  $lang;
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];
        $data['social'] = json_decode($data['shop']['social_list'], true);

        $data['offer_list'] = $this->common_m->get_my_offers($offer_slug, restaurant($id)->id);

        $data['main_content'] = $this->load->view(get_view_layouts_by_slug($slug) . '/offers', $data, true);
        $this->load->view(get_view_layouts_by_slug($slug) . '/index', $data);
    }

    public function whatsapp($order_id)
    {
        if (ACTIVATE == 0) {
            return false;
            exit();
        }
        $order_details = $this->admin_m->single_select_by_uid_row($order_id, 'order_user_list');

        $shop_info = $this->common_m->get_restaurant_info_by_id($order_details->shop_id);
        $order_list = $this->common_m->get_order_item($order_details->id, $shop_info['shop_id']);
        $p = __order((array)$order_details, $order_list);



        $shop_id = $shop_info['shop_id'];
        $lang = $this->load_restaurant_language($shop_id, 'shop_id');
        $data['lang'] = $lang;

        if ($shop_info['is_area_delivery'] == 1) :
            $shpping_info = $this->common_m->delivery_area_by_shop_id($order_details->shipping_id, $shop_info['shop_id']);
        endif;



        $data = '';
        $i = 1;

        $data .= lang('order_type') . "\t : " . order_type($order_details->order_type) . "\n";


        $data .= "---------------------------------------\n\n";

        foreach ($order_list as $key => $row) :
            if ($row['is_package'] == 1) :
                $data .= $i . ". {$row['package_name']} \t {$row['qty']} x " . wh_currency_position($row['item_price'], $shop_id) . "\n";
                $data .= "---------------------------------------\n";
            else :
                $data .= $i . ". {$row['name']} \t {$row['qty']} x " . wh_currency_position($row['item_price'], $shop_id) . "\n";

                if (isset($row['is_extras']) && $row['is_extras'] == 1) :
                    $data .=  whatsappExtra($row['extra_id'], $row['extra_qty'], $row['item_id'], $shop_id);

                endif;
                $data .= "----------------------------------------\n";
            endif;


            $i++;
        endforeach;

        $data .= lang('sub_total') . "\t : " . wh_currency_position($p->subtotal, $shop_id) . "\n";

        if (!empty($p->tax_details)) :
            foreach ($p->tax_details as  $key => $tax) :
                $data .= lang("tax") . " " . tax($tax['percent'], $tax['tax_status']) . " \t \t: " . wh_currency_position($tax['total_price'], $shop_id) . "\n";
            endforeach;
        else :
            $data .= lang('tax') . " \t \t: " . wh_currency_position($p->tax_fee, $shop_id) . "\n";
        endif;

        if ($p->tips != 0) :
            $data .= lang('tips') . "\t : " . wh_currency_position($p->tips, $shop_id) . "\n";
        endif;

        if ($order_details->order_type == 1) :
            $data .= lang('shipping') . "\t : " . wh_currency_position($p->shipping, $shop_id) . "\n";
        endif;

        if ($p->discount != 0) :
            $data .= lang('discount') . "\t : " . wh_currency_position($p->discount, $shop_id) . "\n";
        endif;

        if ($p->coupon_percent != 0) :
            $data .= lang('coupon_discount') . "\t : " . wh_currency_position($p->coupon_percent, $shop_id) . "\n";
        endif;
        if ($p->service_charge != 0) :
            $data .= lang('coupon_discount') . "\t : " . wh_currency_position($p->service_charge, $shop_id) . "\n";
        endif;


        $data .= "\n- - - - - - - - - - - - - - - - - - - -\n";
        $data .= "" . lang('total') . " : \t " . "" . wh_currency_position($p->grand_total, $shop_id) . " ";
        $data .= "\n- - - - - - - - - - - - - - - - - - - -\n\n";

        if ($order_details->is_payment == 1 && !empty($order_details->payment_by)) :
            $data .= "" . lang('payment_by') . " : \t " . "" . $order_details->payment_by . " \n";
        endif;



        if ($order_details->order_type == 4) :
            if (!empty($order_details->pickup_time) || empty($order_details->pickup_point)) :
                $data .= "---------------------------------------\n";
                $data .= "\t" . lang('order_details') . "\n";

                if (isset($order_details->pickup_time) && !empty($order_details->pickup_time)) :
                    $data .= "- - - - - - - - - - - - - - - - - - - -\n";
                    if (isset($order_details->pickup_date)) :
                        $data .= lang('pickup_date') . "\t : " . cl_format($order_details->pickup_date, $shop_id) . "\n";
                    endif;
                    $data .= lang('pickup_time') . "\t : " . $order_details->pickup_time . "\n";
                endif;
                $pickup_point = single_select_by_id($order_details->pickup_point, 'pickup_points_area')['address'];
                if (isset($order_details->pickup_point) && !empty($pickup_point)) :
                    $data .= lang('pickup_point') . "\t : " . $pickup_point . "\n\n";
                    $data .= "---------------------------------------\n";
                endif;
            endif;
        endif; //order_details->order_type // Pickup


        if ($order_details->order_type == 2) :
            $data .= "---------------------------------------\n";
            $data .= "\t" . lang('order_details') . "\n";
            if (isset($order_details->total_person) && !empty($order_details->total_person)) :
                $data .= "- - - - - - - - - - - - - - - - - - - -\n";
                $data .= lang('total_person') . "\t : " . $order_details->total_person . "\n";
                $data .= lang('booking_date') . "\t : " . cl_format($order_details->reservation_date, $shop_id) . "\n";
            endif;
        endif; //booking

        if ($order_details->order_type == 6) :
            $data .= "---------------------------------------\n";
            $data .= "\t" . lang('order_details') . "\n";
            if (isset($order_details->total_person) && !empty($order_details->total_person)) :
                $table_name = single_select_by_id($order_details->table_no, 'table_list')['name'];
                $data .= "---------------------------------------\n";
                $data .= lang('total_person') . "\t : " . $order_details->total_person . "\n";
                $data .= lang('table_no') . "\t : " . $table_name . "\n";
            endif;
        endif;


        if ($order_details->order_type == 8) :
            $data .= "---------------------------------------\n";
            $data .= "\t" . lang('order_details') . "\n";
            if (isset($order_details->hotel_id) && !empty($order_details->hotel_id)) :
                $hotel_name = single_select_by_id($order_details->hotel_id, 'hotel_list')['hotel_name'];
                $data .= "- - - - - - - - - - - - - - - - - - - -\n";
                $data .= lang('hotel_name') . "\t : " . $hotel_name . "\n";
                $data .= lang('room_number') . "\t : " . $order_details->room_number . "\n";
            endif;
        endif; //dine-in



        $data .= "\n\n ---------------------------------------\n";
        $data .= "\t" . lang('customer_details') . "\n";
        $data .= "---------------------------------------\n";

        if (!empty($order_details->phone)) :
            $data .= lang('phone') . "\t : " . $order_details->phone . "\n";
        endif;


        if (isset($order_details->delivery_area) && !empty($order_details->delivery_area) && $order_details->order_type == 1) :
            $coordinates = getCoordinatesAttribute($order_details->delivery_area, $shop_info['shop_id']);
            $lat = isset($coordinates['latitude']) ? $coordinates['latitude'] : '';
            $lng = isset($coordinates['longitude']) ? $coordinates['longitude'] : '';
            $data .= lang('gmap_link') . "\t : https://maps.google.com?q=" . $lat . "," . $lng . "\n";
        endif;

        if (isset($shpping_info['area']) && !empty($shpping_info['area'])) :
            $data .= lang('delivery_area') . "\t : " . $shpping_info['area'] . "\n";
        endif;

        if (!empty($order_details->address)) :
            $data .= lang('delivery_address') . "\t : " . $order_details->address . "\n";
            $data .= "---------------------------------------\n\n";
        endif;


        $track_url = base_url('my-orders/' . $shop_info['username'] . '?phone=' . $order_details->phone . '&orderId=' . $order_id);


        $replace_data = array(
            '{CUSTOMER_NAME}' => $order_details->name,
            '{ORDER_ID}' => $order_id,
            '{ITEM_LIST}' => $data,
            '{SHOP_NAME}' => $shop_info['shop_name'],
            '{SHOP_ADDRESS}' => $shop_info['address'],
            '{TRACK_URL}' => $track_url,
        );

        $accept_message = json_decode($shop_info['whatsapp_msg']);
        $msg = create_msg($replace_data, $accept_message);
        redirect("https://api.whatsapp.com/send?phone=" . $shop_info['dial_code'] . $shop_info['whatsapp_number'] . "&text=" . urlencode($msg));
        exit();
    }

    /**
     * Processar pagamento PIX dinâmico
     *
     * @param string $slug Slug do restaurante
     * @param string $order_id ID do pedido
     * @return void
     */
    public function payment_pix($slug = '', $order_id = '')
    {
        $slug = custom_domain($this->url, $slug);

        if (empty($slug) || empty($order_id)) {
            redirect(base_url('error-404'));
        }

        $data = array();
        $data['_title'] = 'Pagamento PIX';
        $data['page_title'] = 'PIX Dinâmico';
        $data['slug'] = $slug;
        $data['is_footer'] = false;

        $id = get_id_by_slug($slug);
        $data['id'] = $id;

        if (empty($id)) {
            redirect(base_url('error-404'));
        }

        // Carregar informações do restaurante
        $data['user'] = $this->admin_m->get_profile_info($id);
        $data['shop'] = $this->admin_m->get_restaurant_info($id);
        $data['shop_id'] = $data['shop']['id'];

        // Verificar se PIX dinâmico está ativado
        if (empty($data['shop']['is_mercado_pix']) || $data['shop']['is_mercado_pix'] != 1) {
            redirect(base_url('error-404'));
        }

        // Buscar dados do pedido
        $check = $this->common_m->check_order($data['shop_id'], $order_id);
        if (!$check || empty($check['result'])) {
            redirect(base_url('error-404'));
        }

        $order_data = $check['result'];

        // Verificar se já não foi pago
        if ($order_data['payment_status'] == 1) {
            redirect(base_url('order-success/' . $slug . '/' . $order_id));
        }

        // Carregar model do Mercado PIX
        $this->load->model('mercado_pix_m');

        // Buscar configuração do Mercado Pago
        $mercado_config = [];
        if (!empty($data['shop']['mercado_config'])) {
            $mercado_config = json_decode($data['shop']['mercado_config'], true);
        }

        if (empty($mercado_config['access_token'])) {
            $this->session->set_flashdata('error', 'Configuração do PIX dinâmico não encontrada. Entre em contato com o restaurante.');
            redirect(base_url($slug));
        }

        // Verificar se já existe um pagamento PIX para este pedido
        if (!empty($order_data['pix_payment_data'])) {
            $stored_pix_data = json_decode($order_data['pix_payment_data'], true);

            // Verificar se o pagamento ainda é válido (não expirou)
            if (!empty($stored_pix_data['expiration_timestamp']) && $stored_pix_data['expiration_timestamp'] > time()) {
                // Usar dados armazenados para exibir a página de pagamento
                $this->load_existing_pix_payment($data, $order_data, $stored_pix_data, $slug, $order_id);
                return;
            }
        }

        // Preparar dados para criar PIX
        $pix_data = [
            'order_id' => $order_data['uid'],
            'total_amount' => $order_data['total'],
            'customer_name' => $order_data['name'],
            'customer_email' => $order_data['email'],
            'customer_document' => $order_data['phone'], // Usar telefone como documento temporário
            'restaurant_name' => $data['shop']['name']
        ];

        // Criar pagamento PIX dinâmico
        $pix_result = $this->mercado_pix_m->create_dynamic_pix($pix_data, $mercado_config);

        if (!$pix_result['success']) {
            $this->session->set_flashdata('error', 'Erro ao gerar PIX: ' . $pix_result['error']);
            redirect(base_url($slug));
        }

        // Calcular timestamp de expiração de forma simples e direta
        // Usar sempre a configuração local para evitar problemas de timezone
        $expiration_minutes = $mercado_config['pix_expiration'] ?? 30;
        $expiration_timestamp = time() + ($expiration_minutes * 60);

        // Log para debug
        log_message('info', 'PIX Timer - Expiration calculated: ' . $expiration_timestamp . ' (current: ' . time() . ', minutes: ' . $expiration_minutes . ')');

        // Preparar dados do PIX para armazenar no banco
        $pix_payment_data = [
            'payment_id' => $pix_result['payment_id'],
            'qr_code' => $pix_result['qr_code'],
            'qr_code_base64' => $pix_result['qr_code_base64'],
            'expiration_timestamp' => $expiration_timestamp,
            'expiration_date' => $pix_result['expiration_date'] ?? '',
            'created_at' => time(),
            'status' => $pix_result['status'] ?? 'pending'
        ];

        // Salvar dados do pagamento PIX no pedido
        $this->db->where('id', $order_data['id']);
        $this->db->update('order_user_list', [
            'mercado_pix_id' => $pix_result['payment_id'],
            'payment_by' => 'mercado_pix',
            'is_payment' => 0,
            'pix_payment_data' => json_encode($pix_payment_data)
        ]);

        // Preparar dados para a view
        $data['order_id'] = $order_data['uid'];
        $data['total_amount'] = $order_data['total'];
        $data['customer_name'] = $order_data['name'];
        $data['restaurant_name'] = $data['shop']['name'];
        $data['restaurant_logo'] = !empty($data['shop']['logo']) ? base_url('uploads/restaurant/' . $data['shop']['logo']) : '';
        $data['payment_id'] = $pix_result['payment_id'];
        $data['qr_code'] = $pix_result['qr_code'];
        $data['qr_code_base64'] = $pix_result['qr_code_base64'];
        $data['expiration_minutes'] = $mercado_config['pix_expiration'] ?? 30;
        $data['expiration_timestamp'] = $expiration_timestamp;
        $data['order_tracking_url'] = base_url('my-orders/' . $slug . '?phone=' . $order_data['phone'] . '&orderId=' . $order_id);

        // Carregar view de pagamento PIX
        $this->load->view('payment/mercado_pix_payment', $data);
    }

    /**
     * Carregar página de pagamento PIX com dados existentes
     *
     * @param array $data Dados base da página
     * @param array $order_data Dados do pedido
     * @param array $stored_pix_data Dados do PIX armazenados
     * @param string $slug Slug do restaurante
     * @param string $order_id ID do pedido
     * @return void
     */
    private function load_existing_pix_payment($data, $order_data, $stored_pix_data, $slug, $order_id)
    {
        // Preparar dados para a view usando os dados armazenados
        $data['order_id'] = $order_data['uid'];
        $data['total_amount'] = $order_data['total'];
        $data['customer_name'] = $order_data['name'];
        $data['restaurant_name'] = $data['shop']['name'];
        $data['restaurant_logo'] = !empty($data['shop']['logo']) ? base_url('uploads/restaurant/' . $data['shop']['logo']) : '';
        $data['payment_id'] = $stored_pix_data['payment_id'];
        $data['qr_code'] = $stored_pix_data['qr_code'];
        $data['qr_code_base64'] = $stored_pix_data['qr_code_base64'];

        // Calcular minutos restantes baseado no timestamp armazenado
        $remaining_seconds = $stored_pix_data['expiration_timestamp'] - time();
        $data['expiration_minutes'] = max(0, ceil($remaining_seconds / 60));
        $data['expiration_timestamp'] = $stored_pix_data['expiration_timestamp'];
        $data['order_tracking_url'] = base_url('my-orders/' . $slug . '?phone=' . $order_data['phone'] . '&orderId=' . $order_id);

        // Carregar view de pagamento PIX
        $this->load->view('payment/mercado_pix_payment', $data);
    }

    /**
     * Verificar status do pagamento PIX
     *
     * @return void
     */
    public function check_mercado_pix_status()
    {
        // Verificar se é requisição POST
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['payment_id']) || empty($input['order_id'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Dados incompletos'
            ]);
            return;
        }

        // Buscar dados do pedido
        $order_data = $this->db->where('uid', $input['order_id'])->get('order_user_list')->row_array();

        if (empty($order_data)) {
            echo json_encode([
                'success' => false,
                'error' => 'Pedido não encontrado'
            ]);
            return;
        }

        // Buscar configuração do restaurante
        $shop_data = $this->db->where('id', $order_data['shop_id'])->get('restaurant_list')->row_array();

        if (empty($shop_data['mercado_config'])) {
            echo json_encode([
                'success' => false,
                'error' => 'Configuração não encontrada'
            ]);
            return;
        }

        $mercado_config = json_decode($shop_data['mercado_config'], true);

        // Carregar model e verificar status
        $this->load->model('mercado_pix_m');
        $status_result = $this->mercado_pix_m->get_payment_status($input['payment_id'], $mercado_config['access_token']);

        if (!$status_result['success']) {
            echo json_encode([
                'success' => false,
                'error' => $status_result['error']
            ]);
            return;
        }

        // Se foi aprovado, atualizar pedido
        if ($status_result['status'] === 'approved') {
            $this->db->where('id', $order_data['id']);
            $this->db->update('order_user_list', [
                'status' => 1,
                'payment_status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        echo json_encode([
            'success' => true,
            'status' => $status_result['status'],
            'status_detail' => $status_result['status_detail'] ?? ''
        ]);
    }
}
