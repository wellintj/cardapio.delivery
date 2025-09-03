<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_login();
	}


	public function index()
	{
		$data = array();
		$data['page_title'] = "Coupon List";
		$data['page'] = "Promo";
		$data['couponList'] = $this->admin_m->select_all_by_user_desc('coupon_list');
		$data['main_content'] = $this->load->view('backend/users/coupon_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}




	public function add_coupon()
	{

		$data = array();
		$data['page_title'] = "Coupon List";
		$data['page'] = "Promo";
		$data['data'] = FALSE;
		$data['couponList'] = $this->admin_m->select_all_by_user_desc('coupon_list');
		$data['main_content'] = $this->load->view('backend/users/add_coupon', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function edit($id)
	{

		$data = array();
		$data['page_title'] = "Coupon List";
		$data['page'] = "Promo";
		$data['data'] = single_select_by_id($id, 'coupon_list');
		$data['couponList'] = $this->admin_m->select_all_by_user_desc('coupon_list');
		$data['main_content'] = $this->load->view('backend/users/add_coupon', $data, TRUE);
		$this->load->view('backend/index', $data);
	}


	public function create_coupon()
	{
		is_test();
		$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|xss_clean|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|xss_clean|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/coupon/'));
		} else {
			// Converter datas do formato brasileiro (dd/mm/yyyy) para o formato do banco (yyyy-mm-dd)
			$start_date = $this->input->post('start_date', TRUE);
			$end_date = $this->input->post('end_date', TRUE);
			
			if(!empty($start_date)) {
				$date_parts = explode('/', $start_date);
				if(count($date_parts) == 3) {
					$start_date = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];
				}
			}
			
			if(!empty($end_date)) {
				$date_parts = explode('/', $end_date);
				if(count($date_parts) == 3) {
					$end_date = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];
				}
			}
			
			$data = array(
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'coupon_code' => strtoupper($this->input->post('coupon_code', TRUE)),
				'title' => $this->input->post('title', TRUE),
				'discount' => $this->input->post('discount', TRUE),
				'total_limit' => $this->input->post('total_limit', TRUE),
				'start_date' => $start_date,
				'end_date' => $end_date,
				'is_menu' => isset($_POST['is_menu']) ? 1 : 0,
				'created_at' => d_time(),
			);

			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'coupon_list');
			} else {
				$insert = $this->admin_m->update($data, $id, 'coupon_list');
			}

			if ($insert) {
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/coupon'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/coupon'));
			}
		}
	}



	public function offers()
	{
		$data = array();
		$data['page_title'] = "Offers";
		$data['page'] = "Promo";
		$data['offer_list'] = $this->admin_m->get_offers(restaurant()->id);
		$data['item_list'] = $this->admin_m->get_items_for_offers();
		$data['main_content'] = $this->load->view('backend/users/offers/offers', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function add_offers()
	{
		is_test();
		$id = $this->input->post('id');
		$this->form_validation->set_rules('name', __('name'), 'trim|xss_clean|required');
		if (isset($id) && $id == 0) :
			$this->form_validation->set_rules('slug', __('slug'), 'trim|xss_clean|required|is_unique[pages.slug]|callback_english_check');
		else :
			$this->form_validation->set_rules('slug', __('slug'), 'trim|xss_clean|required');
		endif;

		$this->form_validation->set_rules('discount', __('discount'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('start_date', __('start_date'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('end_date', __('end_date'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('status', __('status'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('item_ids[]', __('items'), 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/coupon/offers'));
		} else {
			// Converter datas do formato brasileiro (dd/mm/yyyy) para o formato do banco (yyyy-mm-dd)
			$start_date = $this->input->post('start_date', TRUE);
			$end_date = $this->input->post('end_date', TRUE);
			
			if(!empty($start_date)) {
				$date_parts = explode('/', $start_date);
				if(count($date_parts) == 3) {
					$start_date = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];
				}
			}
			
			if(!empty($end_date)) {
				$date_parts = explode('/', $end_date);
				if(count($date_parts) == 3) {
					$end_date = $date_parts[2].'-'.$date_parts[1].'-'.$date_parts[0];
				}
			}
			
			$data = array(
				'user_id' => auth('id'),
				'shop_id' => restaurant()->id,
				'name' => $this->input->post('name', TRUE),
				'slug' => str_slug($this->input->post('slug', TRUE)),
				'item_ids' => json_encode($this->input->post('item_ids', TRUE)),
				'discount' => $this->input->post('discount', TRUE),
				'start_date' => $start_date,
				'end_date' => $end_date,
				'status' => isset($_POST['status']) ? $_POST['status'] : 0,
				'created_at' => d_time(),
			);

			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'offer_list');
			} else {
				$insert = $this->admin_m->update($data, $id, 'offer_list');
			}
			if ($insert) {
				$this->upload_m->upload_img($insert, 'offer_list');
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/coupon/offers'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/coupon/offers'));
			}
		}
	}

	public function english_check($string)
	{
		if (preg_match('/[^A-Za-z0-9  -]/', $string)) {
			//string contains only letters from the English alphabet
			$this->form_validation->set_message('english_check', 'The {field} field contains only letters from the English alphabet.');
			return FALSE;
		} else {
			return true;
		}
	}
	public function remove_item($item_id, $offer_id)
	{
		$offer = $this->admin_m->single_select_by_id($offer_id, 'offer_list');

		$old_offer = json_decode($offer['item_ids'], TRUE);
		$new_offer = array_diff($old_offer, array($item_id));


		$this->admin_m->update(['item_ids' => json_encode($new_offer)], $offer_id, 'offer_list');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
