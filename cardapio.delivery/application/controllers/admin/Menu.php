<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_login();
		check_valid_user();
	}


	/**
	 ** Items
	 **/
	public function item()
	{
		$data = array();
		$data['page_title'] = "Items";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['is_create'] = 0;
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['all_items'] = $this->admin_m->get_all_items_ln('0', $_GET['lang'] ?? site_lang());
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['all_items'] = $this->admin_m->get_all_items('0');
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		$data['main_content'] = $this->load->view('backend/menu/items', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function item_list($id)
	{
		$data = array();
		$data['page_title'] = "Items";
		$data['page'] = "Menu";
		$data['is_create'] = 0;
		$data['data'] = false;
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['all_items'] = $this->admin_m->get_all_items_ln($id, $_GET['lang'] ?? site_lang());
		else :
			$data['all_items'] = $this->admin_m->get_all_items($id);
		endif;

		$data['main_content'] = $this->load->view('backend/menu/item_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function create_item()
	{
		$data = array();
		$data['page_title'] = "Items";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['is_create'] = 1;
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['all_items'] = $this->admin_m->get_all_items_ln('0', $_GET['lang'] ?? site_lang());
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['all_items'] = $this->admin_m->get_all_items('0');
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		$data['main_content'] = $this->load->view('backend/menu/create_items', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	/**
	 ** edit about
	 **/

	public function edit_item($id)
	{
		$data = array();
		$data['page_title'] = "Items";
		$data['page'] = "Menu";
		$data['data_type'] = false;
		$data['data'] = $this->admin_m->single_select_by_auth_id($id, 'items');
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		$data['extras'] = $this->admin_m->get_extras($id, restaurant()->id);
		$data['extras_libraries'] = $this->admin_m->select_all_by_shop_status(restaurant()->id, 'extra_libraries');
		if (empty($data['data'])) :
			valid_user($data['data']['user_id']);
		endif;
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;


		$data['main_content'] = $this->load->view('backend/menu/create_items', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	/**
	 *** add items
	 **/
	public function add_items()
	{
		if (ACTIVATE == 0) {
			return false;
			exit();
		}

		is_test();
		$is_size_check = $this->input->post('is_size', true);
		$img_type = $this->input->post('img_type', true);
		$this->form_validation->set_rules('cat_id', lang('category'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('title', lang('title'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('overview', 'Small Description', 'trim|xss_clean');
		$this->form_validation->set_rules('veg_type', 'Veg Type', 'trim|xss_clean');
		$this->form_validation->set_rules('allergen_id[]', 'Allergen', 'trim|xss_clean');
		$this->form_validation->set_rules('in_stock', 'In stock', 'trim|xss_clean');
		if ($img_type == 2) {
			$this->form_validation->set_rules('img_url', 'Image URL', 'trim|xss_clean|required');
		}
		if (!isset($is_size_check)) :
			$this->form_validation->set_rules('price', 'Price', 'required|trim|callback_number_check|xss_clean');
		endif;
		$this->form_validation->set_rules('details', 'Details', 'trim');
		if ($this->form_validation->run() == FALSE) {
			__request(validation_errors(), 0, '');
		} else {
			$id = $this->input->post('id');
			if ($id == 0) :
				if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
					$total = $this->admin_m->check_limit_by_table_ln('items');
				else :
					$total = $this->admin_m->check_limit_by_table('items');
				endif;

				$limit = limit(auth('id'), 1);
				if ($limit != 0) {
					$total_up = $total + 1;

					if ($total_up > $limit) {
						$check = 0;
						__request('Sorry You Uploaded maximum Items', 0, base_url('admin/menu/item'));
						exit();
					} else if ($total > $limit) {
						$check = 0;
						__request(__('you_reached_max_limit'), 0, base_url('admin/menu/item'));
						exit();
					} else {
						$check = 1;
					}
				} else {
					$check = 1; // for unlimited
				}
			else :
				$check = 1;
			endif;


			if ($check == 1) :

				$veg_type = $this->input->post('veg_type', true);

				if (isset($is_size_check) && $is_size_check == 1) :
					$is_size = 1;
					$price = json_encode(['variant_name' => $_POST['variant_name'], 'variant_options' => $_POST['variants']]);
				else :
					$is_size = 0;
					$price = $this->input->post('price', true);
				endif;
				$is_feature = $this->input->post('is_features');
				$previous_price = $this->input->post('previous_price');
				$cat_id = $this->input->post('cat_id', true);
				$language = $this->input->post('language', true);
				$uid = $_ENV['ID'] . random_string('numeric', 4);

				$n = $this->db->where(['shop_id' => restaurant()->id])->count_all_results('items');

				if (__sub() == 1) {
					$sub_category_id = $this->input->post('sub_category_id', true);
				} else {
					$sub_category_id = 0;
				}

				$data = array(
					'cat_id' => $cat_id,
					'sub_category_id' => $sub_category_id,
					'title' => $this->input->post('title', true),
					'allergen_id' => json_encode($this->input->post('allergen_id[]')),
					'veg_type' => isset($veg_type) && !empty($veg_type) ? $veg_type : 0,
					'user_id' => auth('id'),
					'shop_id' => restaurant()->id,
					'overview' => $this->input->post('overview'),
					'details' => $this->input->post('details'),
					'tax_fee' => $this->input->post('tax_fee', true) ?? 0,
					'tax_status' => $this->input->post('tax_status', true) ?? 0,
					'in_stock' => !empty($this->input->post('in_stock')) ? $this->input->post('in_stock') : 0,
					'is_features' => isset($is_feature) ? 1 : 0,
					'price' => $price,
					'previous_price' => isset($previous_price) ? $previous_price : 0,
					'img_type' => $img_type,
					'img_url' => $this->input->post('img_url', true),
					'is_size' => $is_size,
					'created_at' => d_time(),
					'language' => $language ?? 'english',
					'is_pos_only' => isset($_POST['is_pos_only']) ? $_POST['is_pos_only'] : 0,
				);

				$catData = [
					'shop_id' => restaurant()->id,
					'user_id' => auth('id'),
					'uid' => $uid ?? time() . random_string('numeric', 3),
				];

				$is_copy_extras = $this->input->post('is_copy_extra');
				$is_copy = $this->input->post('is_copy');

				if (isset($is_copy) && $is_copy == 1) {
					$insert = $this->admin_m->insert($data, 'items');
					if ($img_type == 1) :
						$img_data = array(
							'images' => $this->input->post('images'),
							'thumb' => $this->input->post('thumb'),
						);

						$this->admin_m->update($img_data, $insert, 'items');
					endif;
				} else {
					if ($id == 0) {
						$item_id = $this->admin_m->insert($catData, 'item_list');
						$insert = $this->admin_m->insert(array_merge(['item_id' => $item_id ?? 0, 'uid' => $uid ?? time() . random_string('numeric', 3), 'orders' => $n + 1], $data), 'items');
					} else {
						$insert = $this->admin_m->update($data, $id, 'items');
					}
				}

				if ($insert) {
					$ex_data = $ex_title_data = $extra_title_ids = $extra_items = [];
					if (isset($is_copy_extras) && $is_copy_extras == 1) {
						$extra_title = $this->admin_m->get_extra_title($id, restaurant()->id);
						$item_extras = $this->admin_m->get_extras($id, restaurant()->id);

						if (sizeof($extra_title) > 0) {
							$new_item_id = ['item_id' => $insert, 'created_at' => d_time()];
							foreach ($extra_title as $key => $t) {
								$extra_items = $this->admin_m->get_extras_by_title_id($t['id'], restaurant()->id);
								$mergeArr = array_merge($t, $new_item_id);
								array_splice($mergeArr, 0, 1);
								$last_title_id = $this->admin_m->insert($mergeArr, 'extra_title_list');
								$this->add_extra_items($extra_items, $last_title_id, $insert);
							}
						}
					}


					$this->upload_m->upload_img($insert, 'items');
					$this->upload_m->croped($insert, 'items');
					__request(lang('success_text'), 1, base_url('admin/menu/item_list/' . $cat_id));
				} else {
					__request(lang('error_text'), 0, base_url('admin/menu/item_list/' . $cat_id));
				}
			endif; //end check
		}
	}

	protected function add_extra_items($item_extras, $extra_id, $insert)
	{
		if (sizeof($item_extras) > 0) :
			foreach ($item_extras as $key => $value) {
				$order_list_arr = ['item_id' => $insert, 'extra_title_id' => $extra_id];
				$parray = array_merge($value, $order_list_arr);
				array_splice($parray, 0, 1);
				$this->admin_m->insert($parray, 'item_extras');
			}
		endif;
	}


	public function add_images($id)
	{
		is_test();
		if (!empty($_FILES['file']['name'])) {
			$up_load = $this->upload_m->upload(400);
			if ($up_load['st'] == 1) :
				$old = single_select_by_id($id, 'items');
				if (!empty($old['extra_images'])) {
					$images = json_encode(array_merge(json_decode($old['extra_images'], true), $up_load['data']));
				} else {
					$images = json_encode($up_load['data']);
				};
				$this->admin_m->update(['extra_images' => $images], $id, 'items');
			else :
				echo json_encode(['st' => 0, 'msg' => $up_load['data']['error']]);
			endif;
			echo json_encode(['st' => 1]);
		} else {
			echo json_encode(['st' => 0]);
		}
	}


	public function delete_extra_img($id)
	{
		is_test();
		if (isset($_GET['img'])) {
			$old = single_select_by_id($id, 'items');
			$old_img = json_decode($old['extra_images'], TRUE);
			$getImg = $old_img[$_GET['img']];

			delete_image_from_server($getImg['thumb']);
			delete_image_from_server($getImg['image']);

			unset($old_img[$_GET['img']]);
			$this->admin_m->update(['extra_images' => json_encode($old_img)], $id, 'items');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function addons($id)
	{

		$data = array();
		$data['page_title'] = "Menu";
		$data['page'] = "Menu";
		$data['data_type'] = false;
		$data['data'] = $this->admin_m->single_select_by_auth_id($id, 'items');
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		$data['extras'] = $this->admin_m->get_extras($id, restaurant()->id);
		$data['extras_libraries'] = $this->admin_m->select_all_by_shop_status(restaurant()->id, 'extra_libraries');

		if (empty($data['data'])) :
			valid_user($data['data']['user_id']);
		endif;

		$data['item'] = $this->common_m->get_single_items($id);
		$data['extrasList'] = $this->admin_m->get_my_addons($id, restaurant()->id);
		if (!empty($data['item']->shop_id)) :
			$data['shop_info'] = $this->admin_m->get_shop_info($data['item']->shop_id);
			$data['shop_id'] = $data['item']->shop_id;
		else :
			$data['shop_info'] = [];
			$data['shop_id'] = '';
		endif;

		$data['main_content'] = $this->load->view('backend/menu/addons', $data, TRUE);
		$this->load->view('backend/index', $data);

		$this->load->model('updated_queries');
		$addColumn = $this->updated_queries->addMaxQty();
	}


	public function add_extras()
	{
		is_test();
		$this->form_validation->set_rules('ex_name', 'name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('ex_price', 'Price', 'trim|required|xss_clean|callback_number_check');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$id = $this->input->post('ex_id', true);

			$data = array(
				'item_id' => $this->input->post('item_id', true),
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'ex_name' => $this->input->post('ex_name'),
				'ex_price' => $this->input->post('ex_price'),
				'extra_title_id' => $this->input->post('extra_title_id') ?? 0,
			);
			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'item_extras');
			} else {
				$insert = $this->admin_m->update($data, $id, 'item_extras');
			}

			if ($insert) {
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function delete_extra($id)
	{
		is_test();
		$del = $this->admin_m->item_delete($id, 'item_extras');
		if ($del) {
			$this->session->set_flashdata('success', lang('delete_success'));
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function category()
	{

		$data = array();
		$data['page_title'] = "Category";
		$data['page'] = "Menu";
		$data['is_create'] = false;
		$data['is_size'] = TRUE;
		$data['data'] = false;
		$data['allergens'] = $this->admin_m->select_all_by_user('allergens');
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		$data['sizes'] = $this->admin_m->select_all_by_user('item_sizes');
		$data['main_content'] = $this->load->view('backend/menu/category', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function create_category()
	{
		$data = array();
		$data['page_title'] = "Category";
		$data['page'] = "Menu";
		$data['is_create'] = true;
		$data['is_size'] = False;
		$data['is_lang'] = 0;
		$data['data'] = false;
		$data['allergens'] = $this->admin_m->select_all_by_user('allergens');
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		$data['sizes'] = $this->admin_m->select_all_by_user('item_sizes');
		$data['main_content'] = $this->load->view('backend/menu/category', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function edit_category($id)
	{
		$data = array();
		$data['page_title'] = "Category";
		$data['is_create'] = true;
		$data['is_size'] = False;
		$data['is_lang'] = 0;
		$data['is_edit'] = 1;
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_auth_id($id, 'menu_type');
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		if (empty($data['data'])) :
			valid_user($data['data']['user_id']);
		endif;
		$data['main_content'] = $this->load->view('backend/menu/category', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function clone_category($id)
	{
		is_test();
		$data = array();
		$data['page_title'] = "Category";
		$data['is_create'] = true;
		$data['is_size'] = False;
		$data['is_clone'] = TRUE;
		$data['is_lang'] = 1;
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_cat_id($id, 'menu_type');;
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		if (empty($data['data'])) :
			valid_user($data['data']['user_id']);
		endif;
		$data['main_content'] = $this->load->view('backend/menu/category', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	/**
	 *** add_portfolio_type
	 **/
	public function add_category()
	{
		is_test();
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/category'));
		} else {

			$language = $this->input->post('language', true);
			$data = array(
				'name' => $this->input->post('name', true),
				'type' => $this->input->post('type', true) ?? 'others',
				'details' => $this->input->post('details', true),
				'orders' => $this->input->post('orders', true),
				'language' => $language ?? 'english',
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'is_pos_only' => isset($_POST['is_pos_only']) ? 1 : 0,
				'created_at' => d_time(),
			);

			$catData = [
				'shop_id' => restaurant()->id,
				'user_id' => auth('id'),
			];


			$id = $this->input->post('id');
			$is_clone = $this->input->post('is_clone');
			if ($id == 0) {
				$cat_id = $this->admin_m->insert($catData, 'item_category_list');
				$insert = $this->admin_m->insert(array_merge(['category_id' => $cat_id], $data), 'menu_type');
			} else {

				if (isset($is_clone) && $is_clone == 1 && isset($language) && $language != 'english') :
					$cat_info = $this->admin_m->single_select_by_id($id, 'menu_type');
					$insert = $this->admin_m->insert(array_merge(['category_id' => $cat_info['category_id'], 'thumb' => $cat_info['thumb'], 'images' => $cat_info['images']], $data), 'menu_type');
				else :
					$insert = $this->admin_m->update($data, $id, 'menu_type');
				endif;
			}

			if ($insert) {
				$this->upload_m->upload_img($insert, 'menu_type');
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/category'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/category'));
			}
		}
	}


	public function number_check($val)
	{
		if (!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $val)) {
			$this->form_validation->set_message('number_check', 'The {field} field must be a number or decimal.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function allergens()
	{
		$data = array();
		$data['page_title'] = "Allergens";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		$data['main_content'] = $this->load->view('backend/menu/allergens', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function edit_allergen($id)
	{
		$data = array();
		$data['page_title'] = "Allergens";
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_id($id, 'allergens');
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		$data['main_content'] = $this->load->view('backend/menu/allergens', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	/**
	 *** add allergen
	 **/
	public function add_allergen()
	{
		is_test();
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/allergens'));
		} else {
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'language' => $this->input->post('language', TRUE),
				'user_id' => auth('id'),
				'created_at' => d_time(),
			);
			$id = $this->input->post('id');
			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'allergens');
			} else {
				$insert = $this->admin_m->update($data, $id, 'allergens');
			}

			if ($insert) {
				$this->upload_m->upload_img($insert, 'allergens');
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/allergens'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/allergens'));
			}
		}
	}



	public function extras()
	{
		$data = array();
		$data['page_title'] = "Extras";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['extra_lists'] = $this->admin_m->select_all_by_user_ln('extra_libraries');
		$data['main_content'] = $this->load->view('backend/menu/extra_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function edit_extras($id)
	{
		$data = array();
		$data['page_title'] = "Extras";
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_id($id, 'extra_libraries');
		$data['extra_lists'] = $this->admin_m->select_all_by_user_ln('extra_libraries');
		$data['main_content'] = $this->load->view('backend/menu/extra_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	/**
	 *** add allergen
	 **/
	public function add_extra_list()
	{
		is_test();
		$this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('price', lang('price'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('language', lang('language'), 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/allergens'));
		} else {
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'price' => $this->input->post('price', TRUE),
				'language' => $this->input->post('language', TRUE),
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'status' => 1,
			);
			$id = $this->input->post('id');
			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'extra_libraries');
			} else {
				$insert = $this->admin_m->update($data, $id, 'extra_libraries');
			}

			if ($insert) {

				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/extras'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/extras'));
			}
		}
	}


	public function specialties()
	{
		$data = array();
		$data['page_title'] = "Specialties";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['specialties'] = $this->admin_m->get_admin_specilities();
		$data['main_content'] = $this->load->view('backend/menu/specialties', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function create_specialties()
	{
		$data = array();
		$data['page_title'] = "Specialties";
		$data['page'] = "Menu";
		$data['specialties'] = $this->admin_m->get_admin_specilities();
		$data['main_content'] = $this->load->view('backend/menu/create_specialities', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function edit_specialties($id)
	{
		$data = array();
		$data['page_title'] = "Specialties";
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_package_id($id, 'item_packages');
		$data['specialties'] = $this->admin_m->get_admin_specilities();
		if (empty($data['data'])) :
			valid_user($data['data']['user_id']);
		endif;
		$data['main_content'] = $this->load->view('backend/menu/create_specialities', $data, TRUE);
		$this->load->view('backend/index', $data);
	}



	/**
	 *** add_portfolio_type
	 **/
	public function add_specialties()
	{
		is_test();
		$is_discount = $this->input->post('is_discount', TRUE);
		$price = $this->input->post('price', TRUE);
		$is_home = $this->input->post('is_home', TRUE);
		$this->form_validation->set_rules('package_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('overview', 'Overview', 'trim|required|xss_clean');
		$this->form_validation->set_rules('in_stock', 'Set stock', 'trim|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'required|trim|callback_number_check|xss_clean');
		if (isset($is_discount) && $is_discount == 1) {
			$this->form_validation->set_rules('discount', 'Discount %', 'trim|required|xss_clean');
			$discount_price = $this->input->post('discount', TRUE);
			$final_price = $price - ($discount_price / 100) * $price;
			$is_discount = $is_discount;
		} else {
			$discount_price = 0;
			$is_discount = 0;
			$final_price = $price;
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/specialties'));
		} else {
			$data = array(
				'package_name' => $this->input->post('package_name', TRUE),
				'price' => $this->input->post('price', TRUE),
				'details' => $this->input->post('details'),
				'overview' => $this->input->post('overview', TRUE),
				'in_stock' => !empty($this->input->post('in_stock')) ? $this->input->post('in_stock') : 0,
				'final_price' => $final_price,
				'discount' => $discount_price,
				'is_discount' => $is_discount,
				'is_home' => isset($is_home) ? 1 : 0,
				'tax_fee' => isset($_POST['tax_fee']) ? $_POST['tax_fee'] : 0,
				'tax_status' => isset($_POST['tax_status']) ? $_POST['tax_status'] : '+',
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'is_special' => 1,
				'created_at' => d_time(),
				'language' => $_POST['language'],
			);
			$cData = [
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
			];


			$id = $this->input->post('id');
			if ($id == 0) {
				$pacakge_id = $this->admin_m->insert($cData, 'item_packages_list');
				$insert = $this->admin_m->insert(array_merge(['package_id' => $pacakge_id ?? 0], $data), 'item_packages');
			} else {
				if (isset($_GET['action']) && $_GET['action'] == "clone") {
					$info = $this->admin_m->single_select_by_id($id, 'item_packages');
					$pData = ['package_id' => $info['package_id'], 'images' => $info['images'], 'thumb' => $info['thumb']];
					$insert = $this->admin_m->insert(array_merge($pData, $data), 'item_packages');
				} else {
					$insert = $this->admin_m->update($data, $id, 'item_packages');
				}
			}



			if ($insert) {
				$this->upload_m->upload_img($insert, 'item_packages');
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/specialties'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/specialties'));
			}
		}
	}





	public function packages()
	{
		$data = array();
		$data['page_title'] = "Packages";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['packages'] = $this->admin_m->get_all_packages('0');
		$data['main_content'] = $this->load->view('backend/menu/packages', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function edit_packages($id)
	{
		$data = array();
		$data['page_title'] = "Packages";
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_id($id, 'item_packages');
		$data['items'] = $this->admin_m->get_package_items();

		$data['main_content'] = $this->load->view('backend/menu/create_packages', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function create_packages()
	{
		$data = array();
		$data['page_title'] = "Packages";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['allergens'] = $this->admin_m->select_all_by_user_ln('allergens');
		$data['items'] = $this->admin_m->get_package_items();
		$data['main_content'] = $this->load->view('backend/menu/create_packages', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function add_packages()
	{
		is_test();
		$is_upcoming = $this->input->post('is_upcoming', TRUE);
		$is_discount = $this->input->post('is_discount', TRUE);
		$is_price = $this->input->post('is_price', TRUE);
		$is_home = $this->input->post('is_home', TRUE);

		// for custom price
		if (isset($is_price) && $is_price == 1) :
			$this->form_validation->set_rules('price', 'Price', 'trim|required|xss_clean|callback_number_check');
			$price = $this->input->post('price', TRUE);
		else :
			// for dynamic price
			$packages = $this->input->post('items[]', TRUE);
			$price = 0;
			foreach ($packages as $key => $p) {
				$item = $this->admin_m->single_select_by_id($p, 'items');
				$price += $item['price'];
			}
		endif;


		$this->form_validation->set_rules('package_name', 'Package Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|xss_clean');
		$this->form_validation->set_rules('items[]', 'Items', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'trim');
		$this->form_validation->set_rules('in_stock', 'In stock', 'trim|xss_clean');

		if (isset($is_discount) && $is_discount == 1) {
			$this->form_validation->set_rules('discount', 'Discount %', 'trim|required|xss_clean');
			$discount_price = $this->input->post('discount', TRUE);
			$final_price = $price - ($discount_price / 100) * $price;
			$is_discount = $is_discount;
		} else {
			$discount_price = 0;
			$is_discount = 0;
			$final_price = $price;
		}

		if (isset($is_upcoming) && $is_upcoming == 1) {
			$this->form_validation->set_rules('live_date', 'Live Date', 'trim|required|xss_clean');
			$live_date = $this->input->post('live_date', TRUE);
			$is_upcoming = 1;
		} else {
			$live_date = d_time();
			$is_upcoming = 0;
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/create_packages'));
		} else {

			$end_date = strtotime("+" . $this->input->post('duration') . " day", strtotime($live_date));
			$end_date = date('Y-m-d', $end_date);
			$end_dates = $end_date . " 23:59:59";


			$data = array(
				'uid' => uid(),
				'package_name' => $this->input->post('package_name', TRUE),
				'duration' => $this->input->post('duration', TRUE),
				'price' => $price,
				'item_id' => json_encode($this->input->post('items[]', TRUE)),
				'details' => $this->input->post('details'),
				'in_stock' => !empty($this->input->post('in_stock')) ? $this->input->post('in_stock') : 0,
				'final_price' => $final_price,
				'discount' => $discount_price,
				'is_upcoming' => $is_upcoming,
				'is_discount' => $is_discount,
				'live_date' => $live_date,
				'end_date' => $end_dates,
				'is_home' => isset($is_home) ? 1 : 0,
				'is_price' => isset($is_price) ? 1 : 0,
				'tax_fee' => isset($_POST['tax_fee']) ? $_POST['tax_fee'] : 0,
				'tax_status' => isset($_POST['tax_status']) ? $_POST['tax_status'] : '+',
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'created_at' => d_time(),
				'language' => $_POST['language'],
			);

			$cData = [
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
			];

			$id = $this->input->post('id');
			if ($id == 0) {
				$pacakge_id = $this->admin_m->insert($cData, 'item_packages_list');
				$insert = $this->admin_m->insert(array_merge(['package_id' => $pacakge_id ?? 0], $data), 'item_packages');
			} else {
				if (isset($_GET['action']) && $_GET['action'] == "clone") {
					$info = $this->admin_m->single_select_by_id($id, 'item_packages');
					$pData = ['package_id' => $info['package_id'], 'images' => $info['images'], 'thumb' => $info['thumb']];
					$insert = $this->admin_m->insert(array_merge($pData, $data), 'item_packages');
				} else {
					$insert = $this->admin_m->update($data, $id, 'item_packages');
				}
			}

			if ($insert) {
				$this->upload_m->upload_img($insert, 'item_packages');
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/packages'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/create_packages'));
			}
		}
	}









	public function add_sizes()
	{
		is_test();
		$this->form_validation->set_rules('p_size[]', 'Name', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/category'));
		} else {
			$size = [];
			if (isset($_POST['p_size'])) :
				$this->admin_m->delete_by_user_id('item_sizes');
				foreach ($_POST['p_size'] as $key => $value) {
					$size[] = array(
						'title' => $value,
						'slug' => $_POST['slug'][$key],
						'type' => $_POST['type'][$key],
						'user_id' => auth('id'),
						'shop_id' => restaurant()->id,
					);
				}
				$insert = $this->admin_m->insert_all($size, 'item_sizes');
			endif;

			if ($insert) {
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/category'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/category'));
			}
		}
	}


	public function add_library_extras()
	{
		is_test();
		$this->form_validation->set_rules('ex_id[]', 'Extra Name', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$size = [];
			if (isset($_POST['ex_id'])) :
				foreach ($_POST['ex_id'] as $key => $value) {
					$size[] = array(
						'ex_id' => $value,
						'ex_name' => $_POST['ex_name'][$key],
						'ex_price' => $_POST['ex_price'][$key],
						'item_id' => $_POST['item_id'],
						'extra_title_id' => $_POST['extra_title_id'] ?? 0,
						'user_id' => auth('id'),
						'shop_id' => restaurant()->id,
					);
				}
				$insert = $this->admin_m->insert_all($size, 'item_extras');
			endif;

			if ($insert) {
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}


	public function get_cat_info_by_type($id)
	{
		$data = [];
		$data['sizes'] = $this->admin_m->get_cat_info_by_type($id);
		if (!empty($data['sizes'])) :
			$load = $this->load->view('backend/menu/ajax_sizes', $data, true);
			echo json_encode(['st' => 1, 'data' => $load]);
		else :
			echo json_encode(['st' => 0,]);
		endif;
	}


	public function notification_off()
	{
		$data = [];
		$off_data = array(
			'is_ring' => 0,
		);
		$update = $this->admin_m->update_by_type($off_data, restaurant()->id, 'shop_id', 'order_user_list');
		if ($update) {
			$this->input->set_cookie('is_ring', '0', 300);
			$data['orders'] = $this->admin_m->get_new_orders(restaurant()->id);
			$data['notify'] = $this->admin_m->get_todays_notify(restaurant()->id);
			$data['completed_orders'] = $this->admin_m->get_today_completed_order(restaurant()->id);
			$load = $this->load->view('backend/inc/ajax_notification', $data, true);
			echo json_encode(['st' => 1, 'data' => $load]);
		} else {
			echo json_encode(['st' => 0,]);
		}
	}



	public function delete($id)
	{
		is_test();

		$del = $this->admin_m->delete($id, 'order_user_list');
		$del = $this->admin_m->delete_order_items($id, 'order_item_list');
		if ($del) {
			$this->session->set_flashdata('success', lang('delete_success'));
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


	public function reset_count($id, $table)
	{

		$up = $this->admin_m->update(['remaining' => 0], $id, $table);
		if ($up) {
			$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


	public function dine_in()
	{
		$data = array();
		$data['page_title'] = "QR Builder";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['packages'] = $this->admin_m->get_all_dine_in('0');
		$data['main_content'] = $this->load->view('backend/menu/dine_in', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function edit_dine_in($id)
	{
		$data = array();
		$data['page_title'] = "QR Builder";
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_id($id, 'item_packages');
		$data['items'] = $this->admin_m->get_package_items();

		$data['table_list'] = $this->admin_m->select_all_by_user('table_list');

		$data['main_content'] = $this->load->view('backend/menu/create_dine_in', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function create_dine_in()
	{
		$data = array();
		$data['page_title'] = "QR Builder";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['allergens'] = $this->admin_m->select_all_by_user('allergens');
		$data['items'] = $this->admin_m->get_package_items();
		$data['table_list'] = $this->admin_m->select_all_by_user('table_list');
		$data['main_content'] = $this->load->view('backend/menu/create_dine_in', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function add_dine_in()
	{
		is_test();
		$is_upcoming = $this->input->post('is_upcoming', TRUE);
		$is_discount = $this->input->post('is_discount', TRUE);
		$is_price = $this->input->post('is_price', TRUE);
		$is_home = $this->input->post('is_home', TRUE);

		// for custom price
		if (isset($is_price) && $is_price == 1) :
			$this->form_validation->set_rules('price', 'Price', 'trim|required|xss_clean|callback_number_check');
			$price = $this->input->post('price', TRUE);
		else :
			// for dynamic price
			$packages = $this->input->post('items[]', TRUE);
			$price = 0;
			foreach ($packages as $key => $p) {
				$item = $this->admin_m->single_select_by_id($p, 'items');
				$price += $item['price'];
			}
		endif;


		$this->form_validation->set_rules('package_name', 'Package Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|xss_clean');
		$this->form_validation->set_rules('items[]', 'Items', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'trim');

		if (isset($is_discount) && $is_discount == 1) {
			$this->form_validation->set_rules('discount', 'Discount %', 'trim|required|xss_clean');
			$discount_price = $this->input->post('discount', TRUE);
			$final_price = $price - ($discount_price / 100) * $price;
			$is_discount = $is_discount;
		} else {
			$discount_price = 0;
			$is_discount = 0;
			$final_price = $price;
		}

		if (isset($is_upcoming) && $is_upcoming == 1) {
			$this->form_validation->set_rules('live_date', 'Live Date', 'trim|required|xss_clean');
			$live_date = $this->input->post('live_date', TRUE);
			$is_upcoming = 1;
		} else {
			$live_date = d_time();
			$is_upcoming = 0;
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/create_dine_in'));
		} else {

			$end_date = strtotime("+" . $this->input->post('duration') . " day", strtotime($live_date));
			$end_date = date('Y-m-d', $end_date);
			$end_dates = $end_date . " 23:59:59";

			$data = array(
				'package_name' => $this->input->post('package_name', TRUE),
				'duration' => $this->input->post('duration', TRUE),
				'price' => $price,
				'item_id' => json_encode($this->input->post('items[]', TRUE)),
				'details' => $this->input->post('details'),
				'in_stock' => 0,
				'final_price' => $final_price,
				'discount' => $discount_price,
				'is_upcoming' => $is_upcoming,
				'is_discount' => $is_discount,
				'live_date' => $live_date,
				'end_date' => $end_dates,
				'is_home' => isset($is_home) ? 1 : 0,
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'is_special' => 2,
				'table_no' => !empty($this->input->post('table_no')) ? $this->input->post('table_no') : 0,
				'created_at' => d_time(),
			);

			$id = $this->input->post('id');
			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'item_packages');
			} else {
				$insert = $this->admin_m->update($data, $id, 'item_packages');
			}

			if ($insert) {
				$this->upload_m->menu_qr($insert, restaurant()->id);
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/dine_in'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/create_dine_in'));
			}
		}
	}


	public function add_order()
	{
		$sort = $_POST['sort'];
		$table = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : '';
		$or = explode(",", $sort);
		$order = 1;
		foreach ($or as $key => $id) {
			$data = array(
				'orders' => $order,
			);
			$this->admin_m->update($data, $id, $table);

			$order++;
		}
		$msg = lang('moved_successfull');
		echo json_encode(array('st' => 1, 'msg' => $msg));
	}


	public function exportToCSV($data, $slug)
	{
		// Create a temporary file handle
		$temp_file = fopen('php://temp', 'r+');

		// Write the UTF-8 BOM (Byte Order Mark) to the file
		fwrite($temp_file, "\xEF\xBB\xBF");
		$columnNames = ['language', 'title', 'images', 'thumb', 'price', 'overview', 'details', 'is_features', 'status', 'in_stock', 'tax_fee', 'veg_type', 'img_type', 'img_url'];
		fputcsv($temp_file, $columnNames);
		// Loop through the data and write each row to the file

		foreach ($data as $row) {
			// Process each value in the row
			$processed_row = array_map(function ($value) {
				if (is_array($value)) {
					// Handle array values
					return $value;
				} elseif (is_string($value)) {
					// Handle string values
					return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
				} else {
					// Handle other types of values
					return $value;
				}
			}, $row);

			// Write the row to the file
			fputcsv($temp_file, $processed_row);
		}

		// Move the file pointer to the beginning of the file
		rewind($temp_file);

		// Read the file contents
		$csv_data = stream_get_contents($temp_file);

		// Close the file handle
		fclose($temp_file);

		$filename = $slug . '_' . time() . '_items';
		// Provide headers for file download
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename=' . $filename . '.csv');
		header('Pragma: no-cache');
		echo $csv_data;
		exit();
	}


	public function exportcvs($language)
	{
		$data[] = array(
			'language' => $language,
			'title' => '',
			'images' => '',
			'thumb' => '',
			'price' => '',
			'overview' => '',
			'details' => '',
			'is_features' => 1,
			'status' => 1,
			'in_stock' => 0,
			'tax_fee' => 0,
			'veg_type' => 1,
			'img_type' => 1,
			'img_url' => '',
		);
		$this->exportToCSV($data, $language);
	}



	public function import($category_id)
	{


		is_test();
		if (isset($category_id) && empty($category_id)) {
			$this->session->set_flashdata('error', lang('error_text'));
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		}

		$csvMimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
		if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

			if (is_uploaded_file($_FILES['file']['tmp_name'])) {
				//open uploaded csv file with read only mode
				$csvFile = fopen($_FILES['file']['tmp_name'], 'r');


				$header = fgetcsv($csvFile); //skip first row

				// Import the CSV file
				while (($row = fgetcsv($csvFile)) !== FALSE) {
					$language = $row[0];
					$title = $row[1];
					$images = $row[2];
					$thumb = $row[3];
					$price = $row[4];
					$overview = $row[5];
					$details = $row[6];
					$is_features = $row[7];
					$status = $row[8];
					$in_stock = $row[9];
					$tax_fee = $row[10];
					$veg_type = $row[11];
					$img_type = $row[12];
					$img_url = $row[13];


					$data = array(
						'shop_id' => restaurant()->id,
						'user_id' => auth('id'),
						'cat_id' => $category_id,
						'language' => $language,
						'title' => $title,
						'images' => $images,
						'thumb' => $thumb,
						'price' => $price,
						'overview' => $overview,
						'details' => $details,
						'is_features' => $is_features,
						'status' => $status,
						'in_stock' => $in_stock,
						'tax_fee' => $tax_fee,
						'veg_type' => $veg_type,
						'img_type' => $img_type,
						'img_url' => $img_url,
					);
					$insert = $this->admin_m->insert($data, 'items');
				}

				//close opened csv file
				fclose($csvFile);
				if ($insert) {
					$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				$this->session->set_flashdata('error', lang('error_text'));
				redirect($_SERVER['HTTP_REFERER']);
			}
		} else {
			$this->session->set_flashdata('error', 'Invalid File');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}




	private function parse_csv_file($file_path)
	{
		$csv_data = array();

		if (($handle = fopen($file_path, "r")) !== FALSE) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$csv_data[] = $row;
			}
			fclose($handle);
		}

		return $csv_data;
	}


	public function variants()
	{
		$data = array();
		$data['page_title'] = "Variants";
		$data['page'] = "Menu";
		$data['data'] = false;
		$data['allergens'] = $this->admin_m->select_all_by_user('allergens');
		$data['items'] = $this->admin_m->get_package_items();
		$data['main_content'] = $this->load->view('backend/menu/create_packages', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function create_product_variants($id = '')
	{
		$this->form_validation->set_rules('variant_name', lang("variant_name"), 'trim|xss_clean|required');
		$this->form_validation->set_rules('variant_options', lang("variant_options"), 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {

			$data = [];
			$data['variant_name'] = $_POST['variant_name'];
			$variant_options = $_POST['variant_options'];

			if (strpos($variant_options, ',') !== false) {
				$get_variants = explode(",", $_POST['variant_options']);
			} elseif (strpos($variant_options, '|') !== false) {
				$get_variants = explode("|", $_POST['variant_options']);
			} else {
				$get_variants = explode("|", $_POST['variant_options']);
			}

			$data['total_variants'] = sizeof($get_variants);
			$data['variant_options'] = $get_variants;
			$load_data = $this->load->view('backend/menu/inc/ajax_variants', $data, TRUE);
			echo json_encode(['st' => 1, 'load_data' => $load_data]);
		}
	}

	public function delete_addons($id)
	{
		is_test();
		//delete extras by extra_title_id
		$del = $this->db->delete('item_extras', array('extra_title_id' => $id));
		if ($del) {
			$this->db->delete('extra_title_list', array('id' => $id));
			__request(__("success_text"), 1, '');
		} else {
			__request(__("error_text"), 0, '');
		}
	}

	public function add_new_extras()
	{
		is_test();

		$this->form_validation->set_rules('title', __('title'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('is_single_select', __('type'), 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			__request(validation_errors(), 0, '');
		} else {
			$id = $this->input->post('extra_title_id', true);
			$item_id = $this->input->post('item_id', true);
			$shop_id = restaurant()->id;

			$n = $this->db->where(['item_id' => $item_id, 'shop_id' => $shop_id])->count_all_results('extra_title_list');

			$data = array(
				'item_id' => $item_id,
				'shop_id' => $shop_id,
				'user_id' => auth('id'),
				'title' => $this->input->post('title'),
				'is_required' => $this->input->post('is_required') ?? 0,
				'is_single_select' => $this->input->post('is_single_select') ?? 0,
				'language' => $this->input->post('language') ?? 'english',
				'select_limit' => $this->input->post('select_limit') ?? 1,
				'select_max_limit' => isset($_POST['select_max_limit']) ? $_POST['select_max_limit'] : 0,
				'max_qty' => isset($_POST['max_qty']) ? $_POST['max_qty'] : 1,
				'created_at' => d_time(),
			);
			if ($id == 0) {
				$this->admin_m->check_existing_addons($_POST['item_id'], $shop_id);
				$data = array_merge($data, ['orders' => $n + 1]);
				$insert = $this->admin_m->insert($data, 'extra_title_list');
			} else {
				$insert = $this->admin_m->update($data, $id, 'extra_title_list');
			}

			if ($insert) {
				__request(__("success_text"), 1, '');
			} else {
				__request(__("error_text"), 0, '');
			}
		}
	}



	public function reset_data()
	{
		is_test();
		$this->custom_m->removeTablesData(restaurant()->id, auth('id'));
		__request(__("success_text"), 1, '');
	}


	public function sub_category()
	{

		$data = array();
		$data['page_title'] = "Sub Category";
		$data['page'] = "Menu";
		$data['data'] = false;
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		$data['sub_category_list'] = $this->admin_m->get_my_sub_categories();
		$data['main_content'] = $this->load->view('backend/menu/subcategory/home', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function edit_sub_category($id)
	{

		$data = array();
		$data['page_title'] = "Sub Category";
		$data['page'] = "Menu";
		$data['data'] = $this->admin_m->single_select_by_id($id, 'sub_category_list');
		if (isset(restaurant()->is_multi_lang) && restaurant()->is_multi_lang == 1) :
			$data['menu_type'] = $this->admin_m->get_my_categories_ln(restaurant()->id, $_GET['lang'] ?? site_lang());
		else :
			$data['menu_type'] = $this->admin_m->get_my_categories();
		endif;
		$data['sub_category_list'] = $this->admin_m->get_my_sub_categories();
		$data['main_content'] = $this->load->view('backend/menu/subcategory/home', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function get_subcategories($id)
	{

		$subcatlist = $this->admin_m->get_subcategories_by_cat_id($id, $_ENV['ID']);
		$data = '';
		if (sizeof($subcatlist) > 0) {
			foreach ($subcatlist as $value) {
				$data .= "<option value= '{$value['id']}'> {$value['sub_category_name']} </option>";
			}
		} else {
			$data = '<option value="">' . lang("not_found") . '</option>';
		}

		echo json_encode(['data' => $data]);
	}
	public function add_sub_category()
	{
		is_test();
		$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_category_name', 'Name', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/menu/sub_category'));
		} else {

			$language = $this->input->post('language', true);
			$data = array(
				'sub_category_name' => $this->input->post('sub_category_name', true),
				'category_id' => $this->input->post('category_id', true),
				'orders' => $this->input->post('orders', true),
				'language' => $language ?? site_lang(),
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'created_at' => d_time(),
			);


			$id = $this->input->post('id');
			$is_clone = $this->input->post('is_clone');
			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'sub_category_list');
			} else {
				$insert = $this->admin_m->update($data, $id, 'sub_category_list');
			}

			if ($insert) {
				$this->upload_m->upload_img($insert, 'sub_category_list');
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/menu/sub_category'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/menu/sub_category'));
			}
		}
	}
}
