<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// is_login();
	}

	/*----------------------------------------------
	  	Notification for live orders	
	----------------------------------------------*/
	public function get_ajax_notification()
	{
		$data = array();
		$data['page_title'] = "Order List";
		$shop_id = restaurant()->id ?? 0;
		$data['orders'] = $this->admin_m->get_new_orders($shop_id);
		$data['notify'] = $this->admin_m->get_todays_notify($shop_id);
		$data['completed_orders'] = $this->admin_m->get_today_completed_order($shop_id);
		$data['reservations'] = $this->admin_m->get_todays_reservations($shop_id);

		$count_notify = $this->admin_m->get_todays_all_notify($shop_id);
		$load_view = $this->load->view('backend/inc/ajax_realtime_notification', $data, TRUE);
		if ($count_notify > 0) :
			echo json_encode(['st' => 1, 'load_data' => $load_view]);
		else :
			echo json_encode(['st' => 0, 'load_data' => '']);
		endif;
	}


	/*----------------------------------------------
  		Waiter notification list in bottom
----------------------------------------------*/
	public function get_waiter_notification()
	{
		$data = array();
		$data['page_title'] = "Order List";
		$shop_id = restaurant()->id ?? 0;
		$data['orders'] = $this->admin_m->get_waiter_notification($shop_id);
		$data['todays_notify'] = $this->admin_m->get_todays_waiter_notification($shop_id);
		$data['count_notify'] = $this->admin_m->get_todays_waiter_notification($shop_id, 1);
		$load_view = $this->load->view('backend/inc/ajax_waiter_notify', $data, TRUE);
		if ($data['count_notify'] > 0) :
			echo json_encode(['st' => 1, 'load_data' => $load_view]);
		else :
			echo json_encode(['st' => 0, 'load_data' => '']);
		endif;
	}


	/*----------------------------------------------
	  	waiter/table icon ringign			
	----------------------------------------------*/
	public function table_notification()
	{
		$data = array();
		$data['page_title'] = "Order List";
		$load_view = $this->load->view('backend/inc/ajax_table_notification', $data, TRUE);
		echo json_encode(['st' => 1, 'load_data' => $load_view]);
	}


	public function accept_waiter($id, $status = 0)
	{
		if (!empty(auth('staff_id'))) {
			$staff_id = auth('staff_id');
		} else {
			$staff_id = 0;
		}
		$data = ['is_ring' => 0, 'staff_id' => $staff_id, 'status' => $status];
		$update = $this->admin_m->update($data, $id, 'call_waiter_list');
		$load_data = $this->table_order(true);
		echo json_encode(['st' => 1, 'load_data' => $load_data ?? '']);
	}

	public function table_order($isView = false)
	{
		$data = [];
		$shop_id = restaurant()->id ?? 0;
		$dine = $this->admin_m->get_new_dine_order($shop_id);
		$waiter = $this->admin_m->get_todays_waiter_notification($shop_id, 1);

		if ($dine > 0 || $waiter > 0) {
			$data['table_list'] = $this->common_m->get_table_list($shop_id);
			$load_view = $this->load->view('backend/users/inc/table_orders', $data, TRUE);
			if ($isView == false) :
				echo json_encode(['st' => 1, 'load_data' => $load_view]);
			else :
				return $load_view;
			endif;
		} else {
			if ($isView == false) :
				echo json_encode(['st' => 0, 'load_data' => '']);
			else:
				return '';
			endif;
		}
	}

	public function update_order_status()
	{
		$data = array();

		$this->load->library('pagination');
		$data['is_filter'] = false;
		$data['hide'] = true;
		$data['order_list'] = $this->admin_m->get_my_today_order_list_by_id(restaurant()->id);
		$load_data = $this->load->view('backend/order/order_list', $data, TRUE);
		echo json_encode(['st' => 1, 'load_data' => $load_data]);
	}



	/*----------------------------------------------
	  		Merge list
	----------------------------------------------*/
	public function merge_order_list()
	{
		$data = [];
		$is_merge = $this->admin_m->get_merged_order_list();
		if (sizeof($is_merge) > 0) {
			$data['merge_orders'] = $is_merge;
			$load_view = $this->load->view('backend/inc/merge_ajax_load', $data, TRUE);
			echo json_encode(['st' => 1, 'load_data' => $load_view]);
		}
	}

	public function close_merge($id)
	{
		$data = ['merge_status' => 0];
		$update = $this->admin_m->update($data, $id, 'order_user_list');
		echo json_encode(['st' => 1]);
	}
}
