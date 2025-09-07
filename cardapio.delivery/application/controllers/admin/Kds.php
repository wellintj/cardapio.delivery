<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kds extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function live($id)
	{
		$data = array();
		$data['page_title'] = "KDS";
		$data['page'] = "KDS";
		$data['data'] = false;
		$data['shop'] = $this->admin_m->get_shop_profile_md5($id);
		$data['id'] = $data['shop']['id'];
		if (restaurant($data['shop']['user_id'])->is_kds != 1) :
			redirect(base_url());
		endif;
		$data['order_list'] = $this->admin_m->get_my_today_order_list_by_kds_id($id);
		$data['main_content'] = $this->load->view('backend/restaurant/kds_live', $data, TRUE);
		$this->load->view('backend/kds_index', $data);
	}

	/*----------------------------------------------
	change order start from quick view
----------------------------------------------*/
	public function order_status_by_ajax($id, $shop_id, $status)
	{

		$order_id = $this->admin_m->get_order_id($id);
		if (auth('is_staff') == TRUE && !empty(staff_info()->id)) {
			$staff_id = staff_info()->id;
			$staff_action = order_action($status);
			$action_by = 'staff';
		} else {
			$staff_id = 0;
			$staff_action = '';
			$action_by = 'vendor';
		}


		if ($status == 0) {
			$data = array(
				'status' => 1,
				'is_preparing' => 0,
				'accept_time' => d_time(),
			);

			$this->admin_m->update($data, $id, 'order_user_list');
			$data = array(
				'status' => 1,
				'staff_id' => $staff_id,
				'staff_action' => $staff_action,
				'action_by' => $action_by,
			);
			$change = $this->admin_m->update_kds_by_type($data, $id, $shop_id, 'order_user_list');
		} elseif ($status == 1) {
			//start preparing by kitchen
			$time_data = array(
				'is_preparing' => 1,
			);

			$this->admin_m->update($time_data, $id, 'order_user_list');
			$data = array(
				'status' => $status,
				'staff_id' => $staff_id,
				'staff_action' => $staff_action,
				'action_by' => $action_by,
			);
			$change = $this->admin_m->update_kds_by_type($data, $id, $shop_id, 'order_user_list');
		} elseif ($status == 2) {
			$date = 'completed_time';
			$data = array(
				'status' => $status,
				'staff_id' => $staff_id,
				'staff_action' => $staff_action,
				'action_by' => $action_by,
				$date => d_time(),
			);
			$change = $this->admin_m->update_kds_by_type($data, $id, $shop_id, 'order_user_list');
			@$this->admin_m->get_order_details($id, $shop_id, $status = 1, $encrypt = true);
		} elseif ($status == 3) {
			$date = 'cancel_time';
			$data = array(
				'status' => $status,
				'staff_id' => $staff_id,
				'staff_action' => $staff_action,
				'action_by' => $action_by,
				$date => d_time(),
			);
			$change = $this->admin_m->update_kds_by_type($data, $id, $shop_id, 'order_user_list');
			@$this->admin_m->get_order_details($id, $shop_id, $status = 2, $encrypt = true);
		} elseif ($status == 4) {
			$time_data = array(
				'is_preparing' => 2,
				'status' => 1,
				'staff_id' => $staff_id,
				'staff_action' => $staff_action,
				'action_by' => $action_by,
			);
			@$this->admin_m->get_order_details($id, $shop_id, $status = 1, $encrypt = true);
			$change = $this->admin_m->update($time_data, $id, 'order_user_list');
		}

		if ($change) {
			$data = [];
			$data['shop'] = $this->admin_m->get_shop_profile_md5($shop_id);
			$data['id'] = $data['shop']['id'];
			$data['order_list'] = $this->admin_m->get_my_today_order_list_by_kds_id($shop_id);
			$load_view = $this->load->view('backend/restaurant/kds_details', $data, true);

			$this->version_changes_m->pusher($data['id'], 'order_status', $order_id);
			__staffAction($order_id,$staff_id,$staff_action);
			echo json_encode(['st' => 1, 'load_data' => $load_view]);
		}
	}

	public function get_new_order($id)
	{
		$data = [];
		$data['id'] = $id;
		$data['shop'] = $this->admin_m->get_shop_profile_md5(md5($id));
		$data['id'] = $data['shop']['id'];
		$count_notify = $this->admin_m->get_new_kds_order($id);
		$data['order_list'] = $this->admin_m->get_my_today_order_list_by_kds_id(md5($id));
		$data['dine_list'] = $this->admin_m->get_my_todays_dine($id);
		$load_view = $this->load->view('backend/restaurant/kds_details', $data, true);
		if ($count_notify > 0) :
			echo json_encode(['st' => 1, 'load_data' => $load_view]);
		else :
			echo json_encode(['st' => 0, 'load_data' => '']);
		endif;
	}

	public function check_pin($shop_id)
	{
		
		$this->load->library('session');
		$this->form_validation->set_rules('kds_pin', lang('kds_pin'), 'trim|xss_clean|required');

		if ($this->form_validation->run() == FALSE) {
			__request(validation_errors(), 0);
		} else {

			$kds_pin = $this->input->post('kds_pin', TRUE);
			$check_pin =  $this->admin_m->check_kds_pin($kds_pin, $shop_id);

			if ($check_pin == 1) {
				$data = [
					'is_kds_login' => 1
				];
				$this->session->set_userdata($data);

				__request(lang('success_text'), 1, '');
			} else {

				__request(lang("invalid_pin"), 0);
			}
		}
	}


	public function status($itemId, $status)
	{
		$id = $this->admin_m->get_order_item_id($itemId);
		if ($id != 0) {
			if ($status == 'done') {
				$data = [
					'status' => 1
				];
			} else {
				$data = [
					'status' => 2
				];
			}
			$this->admin_m->update($data, $id, 'order_item_list');

			echo
			json_encode(['st' => 1, 'status' => $status, 'msg' => lang('success_text')]);
			exit();
		} else {
			echo
			json_encode(['st' => 0, 'msg' => lang('error_text')]);
			exit();
		}
	}


	public function logout()
	{
		$data = [
			'is_kds_login' => 0
		];
		$this->session->set_userdata($data);
		__request(lang('success_text'), 1, '');
	}
}
