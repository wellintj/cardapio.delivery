<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Affiliate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		is_login();
		$this->load->model('Affiliate_m','ref_m');
	}

	
	public function index()
	{
		check_valid_auth();
		$data = array();
		$data['page_title'] = "Affiliate Settings";
		$data['page'] = "Affiliate";
		$data['main_content'] = $this->load->view('backend/affiliate/admin_home', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function payout()
	{
		__isFeature('affiliate');
		$data = array();
		$data['page_title'] = "Payout Request";
		$data['page'] = "Affiliate";
		$data['active_transaction'] = $this->affiliate_m->get_affiliate_by_vendor($_ENV['ID']??0);
		$data['payoutList'] = $this->affiliate_m->get_payout_request($_ENV['ID']??0);
		$data['main_content'] = $this->load->view('backend/affiliate/payout', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function user()
	{
		__isFeature('affiliate');
		$data = array();
		$data['page_title'] = "Affiliate Dashboard";
		$data['page'] = "Affiliate";
		$data['transaction_list'] = $this->ref_m->get_my_referal_list($_ENV['ID']);
		$data['month'] = $this->affiliate_m->get_affiliate_income($_ENV['ID'],'month');
		$data['all'] = $this->affiliate_m->get_affiliate_income($_ENV['ID'],'all');
		$data['main_content'] = $this->load->view('backend/affiliate/user_home', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function vendor_affiliate_settings()
	{
		__isFeature('affiliate');
		$data = array();
		$data['page_title'] = "Vendor Affiliate Settings";
		$data['page'] = "Affiliate";
		$data['u_settings'] = $this->admin_m->get_user_settings();
		$data['main_content'] = $this->load->view('backend/affiliate/vendor_affiliate_settings', $data, TRUE);
		$this->load->view('backend/index', $data);
	}
	

	public function vendor_affiliate_list()
	{
		__isFeature('affiliate');
		$data = array();
		$data['page_title'] = "Vendor Affiliate List";
		$data['page'] = "Affiliate";
		$data['transaction_list'] = $this->ref_m->get_my_referal_list($_ENV['ID']);
		$data['month'] = $this->affiliate_m->get_affiliate_income($_ENV['ID'],'month');
		$data['all'] = $this->affiliate_m->get_affiliate_income($_ENV['ID'],'all');
		$data['main_content'] = $this->load->view('backend/affiliate/vendor_affiliate_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function add_code(){
		is_test();
		$this->form_validation->set_rules('referal_code', lang('referal_code'), 'trim|xss_clean|required|is_unique[restaurant_list.referal_code]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/affiliate/user'));
			}else{	
				$data = array(
					'referal_code' => strtoupper(trim($this->input->post('referal_code',TRUE))),
				);
	
				$insert = $this->admin_m->update($data,restaurant()->id,'restaurant_list'); 

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/affiliate/user'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/affiliate/user'));
				}	
		}
	}

	public function send_payout_request(){
		is_test();
		$requestId = $_POST['request_id'];

		if(isset($requestId) && $requestId != $_ENV["ID"]):
			$this->session->set_flashdata('error', lang('error_text'));
			redirect($_SERVER["HTTP_REFERER"]);
			exit();
		endif;

		$this->form_validation->set_rules('request_id', lang('request_id'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('monthyear[]', lang('date'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('ids[]', lang('ids'), 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/affiliate/payout_request'));
		}else{	

				$month_year = [];
				foreach($_POST['ids'] as  $key => $value):
					if(in_array($key,$_POST['monthyear'])):
						$month_year[] = $key;
					endif;
				endforeach;
			
			  
			  $check = $this->affiliate_m->get_payout_request_by_date_ids($requestId,$month_year);
			
				if(sizeof($check) > 0):
		            $ids = $mergeId =  [];
					foreach($check as  $key2 => $value):
						$ids[] = $value->ids;
						$data[] = array(
							'uid' => uid(),
							'request_id' => $requestId,
							'payout_month' => $value->monthYear,
							'ids' => $value->ids,
							'balance' => $value->balance,
							'total_referel' => $value->total_referal,
							'referel_type' => 'subscription',
							'request_date' => d_time(),
							'is_payment' => 0,
						);
					endforeach;

					$insert = $this->admin_m->insert_all($data,'affiliate_payout_list');
					// $insert =1;
				else:
			        $this->session->set_flashdata('error', 'Not found any data');
					redirect($_SERVER['HTTP_REFERER']);
				endif;

				

				if(isset($insert)){
					foreach($ids as  $keys=> $id):
						$this->admin_m->update_in(['is_request'=>1,'request_date'=>d_time()],json_decode($id),'vendor_affiliate_list');
					endforeach;
					
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/affiliate/payout'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/affiliate/payout'));
				}
				
		}
	}


	public function add_vendor_affiliate_settings(){
		is_test();
		$this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('payment_details', lang('payment_details'), 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/affiliate/vendor_affiliate_settings'));
			}else{	
				$settingsData = array(
					'payment_method' => $this->input->post('payment_method'),
					'payment_details' => $this->input->post('payment_details'),
					'payment_email' => $this->input->post('payment_email'),
				);
				$data = ['vendor_affiliate_settings' => json_encode($settingsData)];
				$insert = $this->admin_m->update_by_user_id($data,restaurant()->user_id,'user_settings'); 

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/affiliate/vendor_affiliate_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/affiliate/vendor_affiliate_settings'));
				}	
		}
	}


	// ******************
	//	admin section
	//*************************** */

	
	public function payout_request()
	{
		$data = array();
		$data['page_title'] = "Payout Request";
		$data['page'] = "Affiliate";
		$data['request_list'] = $this->affiliate_m->get_payout_request_list();

		if(isset($_GET['requestId']) && !empty(trim($_GET['requestId']))){
			$data['requestId'] = $_GET['requestId'];
			$data['payoutList'] = $this->affiliate_m->get_payout_request($_GET['requestId'],$is_encrypt=true);
		}else{
			$data['requestId'] = 0;
			$data['payoutList'] = [];
		}
		$data['main_content'] = $this->load->view('backend/affiliate/payout_request', $data, TRUE);
		$this->load->view('backend/index', $data);
	}
	public function completed_payout()
	{
		$data = array();
		$data['page_title'] = "Completed Payout";
		$data['page'] = "Affiliate";
		$data['payoutList'] = $this->affiliate_m->complete_payout_list();
		$data['main_content'] = $this->load->view('backend/affiliate/complete_payout_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}
	
	//common function
	public function affiliate_details()
	{
		$data = array();
		$data['page_title'] = "Payout Request";
		$data['page'] = "Affiliate";
		if(isset($_GET['requestId'],$_GET['monthYear']) && !empty(trim($_GET['requestId'])) && !empty(trim($_GET['monthYear']))){
			$data['requestId'] = $_GET['requestId'];
			$data['payoutList'] = $this->affiliate_m->get_payout_details($_GET['requestId'],$_GET['monthYear']);
		}else{
			$data['requestId'] = 0;
			$data['payoutList'] = [];
		}
		
		$data['main_content'] = $this->load->view('backend/affiliate/payout_details', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	
	
	
	
	
	
	public function affiliate_list()
	{

		$data = array();
		$data['page_title'] = "Affiliate List";
		$data['page'] = "Affiliate";
		$data['transaction_list'] = $this->ref_m->get_all_affiliate_transaction();
		$data['main_content'] = $this->load->view('backend/affiliate/affiliate_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function add_affiliate_config(){
		is_test();
		$this->form_validation->set_rules('commision_rate', lang('commision_rate'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('commision_type', lang('commision_type'), 'trim|xss_clean|required');$this->form_validation->set_rules('subscriber_commision_rate', lang('subscriber_commision_rate'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('subscriber_commision_type', lang('subscriber_commision_type'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('minimum_payout', lang('minimum_payout'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('payment_method', lang('payment_method'), 'trim|xss_clean|required');
		$this->form_validation->set_rules('referal_guidelines', lang('referal_guidelines'), 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/affiliate/'));
			}else{	
				$checkData = array(
					'commision_rate' => $this->input->post('commision_rate',TRUE),
					'commision_type' => $this->input->post('commision_type',TRUE),
					'subscriber_commision_rate' => $this->input->post('subscriber_commision_rate',TRUE),
					'subscriber_commision_type' => $this->input->post('subscriber_commision_type',TRUE),
					'minimum_payout' => $this->input->post('minimum_payout',TRUE),
					'payment_method' => $this->input->post('payment_method',TRUE),
					'referal_guidelines' => $this->input->post('referal_guidelines'),
					'is_affiliate' => isset($_POST['is_affiliate'])?1:0,
				);

				$insert = __check($checkData); 

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/affiliate'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/affiliate'));
				}	
		}
	}


	
	
	

	public function approve_payment($id,$month_year,$status=1){

		//status 1 for approved the request. status 0 for holding the status
		$info = $this->affiliate_m->get_payout_by_id_month($id,$month_year,$status);
		if(!empty($info)){
			if($status==1):
				$data = array(
					'is_payment'=> 1,
					'complete_date'=> d_time(),
					'status'=> 1,
				);
			else:
				$data = array(
					'is_payment'=> 0,
					'complete_date'=> d_time(),
					'status'=> 2,
				);
			endif;
			$update = $this->admin_m->update($data,$info->id,'affiliate_payout_list');

			if($update){
				$this->session->set_flashdata('success', lang('success_text'));
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', lang('error_text'));
				redirect(base_url('admin/affiliate/payout_request'));
			}
		}else{
			$this->session->set_flashdata('error', lang('error_text'));
			redirect(base_url('admin/affiliate/payout_request'));
		}
	}

	

}