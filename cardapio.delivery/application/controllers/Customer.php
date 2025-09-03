<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends MY_Controller
{
	public $env;
	public function __construct()
	{
		parent::__construct();
		$this->env =  isset(__env()->is_development) ? __env()->is_development : 0;
	}

	public function registration()
	{
		$sorry = !empty(lang("sorry")) ? lang("sorry") : "sorry";
		$success = !empty(lang("success")) ? lang("success") : "success";
		$reg_success = !empty(lang("registration_successfull")) ? lang("registration_successfull") : "Registration successfull";
		$invalid = !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!';

		$shop_id = $_POST['shop_id'];
		$shop_info = shop($shop_id);

		if (isset($shop_info->is_email_based) && $shop_info->is_email_based == 0) :
			$this->form_validation->set_rules('email', __('email'), 'trim|xss_clean|is_unique[customer_list.email]', array('is_unique' => __('email_already_exits')));
			$this->form_validation->set_rules('phone', __('phone'), 'trim|required|xss_clean|is_unique[customer_list.phone]', array('is_unique' => __('phone_already_exits')));
		else :
			$this->form_validation->set_rules('email', __('email'), 'trim|required|xss_clean|is_unique[customer_list.email]', array('is_unique' => __('email_already_exits')));
			$this->form_validation->set_rules('phone', __('phone'), 'trim|xss_clean|is_unique[customer_list.phone]', array('is_unique' => __('phone_already_exits')));
		endif;

		$this->form_validation->set_rules('name', __('name'), 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', __('password'), 'trim|required|xss_clean|min_length[3]');
		$this->form_validation->set_rules('cpassword', __('confirm_password'), 'trim|required|xss_clean|matches[password]');

		if (shop($shop_id)->is_question == 1 && (isset($shop_info->is_email_based) && $shop_info->is_email_based == 0)) :
			$this->form_validation->set_rules('answer', __('question_answer'), 'trim|required|xss_clean');
		endif;


		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Sorry ! </strong> ' . validation_errors() . '
			</div>';
			echo json_encode(array('st' => 0, 'msg' => $msg,));
		} else {

			$dial_code = $this->input->post('dial_code', true);
			$name = $this->input->post('name', true);
			$email = $this->input->post('email', true);

			$phone = $dial_code . $this->input->post('phone', true);


			$password = $this->input->post('password', true);
			$dial_code = '+' . $dial_code;
			$question_id = $this->input->post('question', true);
			$answer = $this->input->post('answer', true);
			$shop_id = $this->input->post('shop_id', true);
			$user_id = shop($shop_id)->user_id;

			$check_country = $this->common_m->check_country_by_dial_code($dial_code);
			if (!empty($check_country)) {
				$country_id = $check_country->id;
				$country = $check_country->name;
			} else {
				$country_id = 0;
				$country = '';
			}

			$q = ['id' => $question_id, 'answer' => $answer];
			$data = array(
				'customer_name' => $name,
				'phone' => $phone,
				'email' => $email ?? '',
				'dial_code' => $dial_code,
				'country_id' => $country_id,
				'country' => $country,
				'password' => md5($password),
				'created_at' => d_time(),
				'role' => 'customer',
				'question' => json_encode($q),
				'shop_id' => $shop_id,
				'user_id' => $user_id,
			);
			$insert = $this->common_m->insert($data, 'customer_list');
			if ($insert) :
				$s_array = array(
					'customer_id' => $insert,
					'customer_name' => $name,
					'customer_phone' => '+' . $phone,
					'customer_email' => $email ?? '',
					'question' => json_encode($q) ?? '',
					'role' => 'customer',
					'is_customer' => TRUE,
				);
				$this->session->set_userdata($s_array);
				$p = '';
				if (isset($shop_info->is_email_based) && $shop_info->is_email_based == 0) :
					$p .= '<p class="fz-14"><i class="icofont-ui-call"></i> ' . $phone . '</p>';
				else :
					$p .= '<p class="fz-14"><i class="icofont-ui-call"></i> ' . $phone . '</p>';
					$p .= '<p class="fz-14"><i class="far fa-envelope"></i> ' . $email ?? "" . '</p>';
				endif;

				$info = '
					<div class="flex flex-column">
						<h4 class="bb_1_dashed w_100 pb-5">' . lang('customer_info') . '</h4>
						<div class="customerInfoModal">
							<h4 class="pb-7 pt-5 fz-14"><i class="icofont-users-alt-4"></i> ' . $name . '</h4>
							' . $p . '
						</div>
					</div>
					<div class="customerEdit">
						<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
					</div>
				';
				$msg = "<div class='alert alert-success alert-dismissible'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<strong>{$success} ! </strong> {$reg_success}  <i class='fa fa-smile-o'></i>

					</div>";
				$s_array['shop_info'] = $shop_info ?? '';
				$customer_data = $this->load->view('layouts/inc/customer_info_modal', $s_array, TRUE);
				echo json_encode(array('st' => 1, 'msg' => $msg, 'info' => $info, 'address' => !empty($address) ? $address : '', 'customer_data' => $customer_data));
				exit();
			else :
				$msg = '<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>' . $sorry . '</strong> ' . $invalid . ' <i class="fa fa-frown-o" ></i>
					</div>';
				echo json_encode(array('st' => 0, 'msg' => $msg));
			endif;
		}
		//end validation
	}

	public function customer_login()
	{
		$sorry = !empty(lang("sorry")) ? lang("sorry") : "sorry";
		$welcome = !empty(lang("welcome")) ? lang("welcome") : "Welcome";
		$login_success = !empty(lang("login_success")) ? lang("login_success") : "Login successfull";
		$not_approve = !empty(lang("account_not_approve")) ? lang("account_not_approve") : "Your account is not approved";
		$invalid = !empty(lang("invalid_login")) ? lang("invalid_login") : "Login invalid";

		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');





		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>' . __('sorry') . ' </strong> ' . validation_errors() . '
		</div>';
			echo json_encode(array('st' => 0, 'msg' => $msg,));
		} else {

			$dial_code = $this->input->post('dial_code', TRUE) ?? '';
			$phone_with_code = $dial_code . $this->input->post('phone', TRUE);
			$phone_without_code = $this->input->post('phone', TRUE);
			$password = $this->input->post('password', TRUE);
			$email = $this->input->post('email', TRUE);

			if (empty($phone_without_code) && empty($email)) :
				$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>' . __('sorry') . ' </strong> ' . __('invalid_login') . '
		</div>';
				echo json_encode(array('st' => 0, 'msg' => $msg,));
			endif;

			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$query = $this->admin_m->check_customer_email_login($email, $password); //check email / user name and password
				$is_email_login = 1;
			} else {
				$query = $this->admin_m->check_customer_login($phone_with_code, $phone_without_code, $password); //check email / user name and password
			}



			if (!empty($query['result'])) {
				$s_array = array();
				foreach ($query['result'] as $row) :
					$phone = customer_phone($row->phone, $dial_code);
					$shop_info = isset($row->shop_id) && !empty($row->shop_id) ? shop($row->shop_id) : '';
					$s_array = array(
						'customer_id' => $row->id,
						'customer_name' => $row->customer_name,
						'customer_email' => $row->email ?? '',
						'customer_phone' => $phone,
						'customer_address' => $row->address,
						'gmap_link' => $row->gmap_link,
						'question' => $row->question ?? '',
						'dial_code' => $dial_code,
						'role' =>  $row->role,
						'is_email_login' =>  isset($is_email_login) ? 1 : 0,
						'is_email_based' =>  isset($shop_info->is_email_based) && $shop_info->is_email_based == 1 ? 1 : 0,
						'is_' . $row->role => TRUE,
					);
					$this->session->set_userdata($s_array);
					$p = '';
					if (isset($is_email_login) && $is_email_login == 1) :
						$p .= '<p class="fz-14"><i class="icofont-ui-call"></i> ' . $phone . '</p>';
						$p .= '<p class="fz-14"><i class="far fa-envelope"></i> ' . $email ?? "" . '</p>';
					else :
						$p .= '<p class="fz-14"><i class="icofont-ui-call"></i> ' . $phone . '</p>';
					endif;


					$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>' . $welcome . ' ! </strong> ' . $login_success . '  <i class="fa fa-smile-o"></i>

					</div>';
					$info = '
						<div class="flex flex-column">
							<h4 class="bb_1_dashed w_100 pb-5">' . lang('customer_info') . ' <a href="javascript:;" class="customerRemove ml-20 text-danger"><i class="icofont-close-line "></i></a></h4>
							<div class="customerInfoModal">
								<h4 class="pb-7 pt-5 fz-14"><i class="icofont-users-alt-4"></i> ' . $s_array["customer_name"] . '</h4>
								' . $p . '
							</div>
						</div>
						<div class="customerEdit">
							<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
						</div>
					';
					$data = [];
					$data['shop_id'] = isset($row->shop_id) ? $row->shop_id : 0;
					$data['question_list'] = $this->admin_m->select('question_list');
					$data['customer_data'] = $s_array;
					$customer_data = $this->load->view('layouts/inc/customer_info_modal', $data, TRUE);
					echo json_encode(array('st' => 1, 'msg' => $msg, 'info' => $info, 'address' => !empty($row->address) ? $row->address : '', 'customer_data' => $customer_data, 'gmap_link' => !empty($row->gmap_link) ? $row->gmap_link : ''));
					exit();
				endforeach;
			} else {
				$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>' . $sorry . '</strong> ' . $invalid . ' <i class="fa fa-frown-o" ></i>
			</div>';
				echo json_encode(array('st' => 0, 'msg' => $msg));
			}
			//end login_info_check

		}
		//end validation
	}


	public function update_customer()
	{
		$sorry = !empty(lang("sorry")) ? lang("sorry") : "sorry";
		$welcome = !empty(lang("welcome")) ? lang("welcome") : "Welcome";
		$invalid = !empty(lang("error_text")) ? lang("error_text") : "Sorry Somethings were wrong!!";
		$success = !empty(lang("success_text")) ? lang("success_text") : "Save change successfully";
		$phone = $this->input->post('phone', TRUE);

		$this->form_validation->set_rules('customer_name', 'Name', 'trim|xss_clean');
		if (isset($_POST['is_update']) && $_POST['is_update'] == 1) :
			if (auth('customer_phone') == $phone) :
				$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
			else :
				$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean|is_unique[customer_list.phone]', array('is_unique' => __('phone_already_exits')));
			endif;

		else :
			$this->form_validation->set_rules('phone', 'phone', 'trim|required|xss_clean');
		endif;



		$this->form_validation->set_rules('customer_address', 'address', 'trim|xss_clean');
		$this->form_validation->set_rules('gmap_link', 'Google Map Link', 'trim|xss_clean');
		if (isset($_POST['is_update']) && $_POST['is_update'] == 1) :

		endif;
		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong>Sorry ! </strong> ' . validation_errors() . '
		</div>';
			echo json_encode(array('st' => 0, 'msg' => $msg));
		} else {
			if ($_POST) {

				$question_id = $this->input->post('question', true);
				$answer = $this->input->post('answer', true);

				$q = ['id' => $question_id, 'answer' => $answer];


				$s_array = array(
					'customer_id' => $this->input->post('customer_id', TRUE),
					'customer_name' => $this->input->post('customer_name', TRUE),
					'customer_phone' => $phone,
					'customer_address' => $this->input->post('customer_address', TRUE),
					'customer_email' => $this->input->post('customer_email', TRUE) ?? '',
					'gmap_link' => $this->input->post('gmap_link', TRUE),
					'question' => json_encode($q),
					'role' =>  'customer',
					'is_customer' => TRUE,
				);

				$update_data = array(
					'customer_name' => $this->input->post('customer_name', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'email' => $this->input->post('email', TRUE) ?? '',
					'address' => $this->input->post('customer_address', TRUE),
					'gmap_link' => $this->input->post('gmap_link', TRUE),
					'question' => json_encode($q),
				);

				if (isset($_POST['is_update']) && $_POST['is_update'] == 1) :
					$this->admin_m->update($update_data, $this->input->post('customer_id', TRUE), 'customer_list');
				endif;

				$this->session->set_userdata($s_array);
				$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>' . $welcome . ' ! </strong> ' . $success . '  <i class="fa fa-smile-o"></i>

					</div>';

				$p = '';
				if ($s_array['customer_email']) {
					$p = '<p class="fz-14"><i class="far fa-envelope"></i> ' . $s_array['customer_email'] . '</p>';
				}


				$info = '
						<div class="flex flex-column">
							<h4 class="bb_1_dashed w_100 pb-5">' . lang('customer_info') . ' <a href="javascript:;" class="customerRemove ml-20 text-danger"><i class="icofont-close-line "></i></a></h4>
							<div class="customerInfoModal">
								<h4 class="pb-7 pt-5 fz-14"><i class="icofont-users-alt-4"></i> ' . $s_array['customer_name'] . '</h4>
								<p class="fz-14"><i class="icofont-ui-call"></i> ' . $s_array['customer_phone'] . '</p>
								' . $p . '
							</div>
						</div>
						<div class="customerEdit">
							<a href="#customereditModal" data-toggle="modal"><i class="fa fa-edit"></i></a>
						</div>
					';
				$customer_data = $this->load->view('layouts/inc/customer_info_modal', $s_array, TRUE);
				echo json_encode(array('st' => 1, 'msg' => $msg, 'info' => $info, 'address' => !empty($s_array['customer_address']) ? $s_array['customer_address'] : '', 'customer_data' => $customer_data, 'phone' => $s_array['customer_phone'], 'gmap_link' => $s_array['gmap_link']));
				exit();
			} else {
				$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>' . $sorry . '</strong> ' . $invalid . ' <i class="fa fa-frown-o" ></i>
			</div>';
				echo json_encode(array('st' => 0, 'msg' => $msg));
			}
			//end login_info_check

		}
		//end validation
	}

	public function profile()
	{
		if (empty(auth('is_customer'))) {
			redirect(base_url());
		}
		$data = [];
		$data['page_title'] = "Customer Profile";
		$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'), 'customer_list');
		$data['countries'] = $this->admin_m->select('countries');
		$data['question_list'] = $this->admin_m->select('question_list');
		$data['main_content'] = $this->load->view('customer/customer_profile', $data, TRUE);
		$this->load->view('customer/index', $data);
	}

	public function password()
	{
		if (empty(auth('is_customer'))) {
			redirect(base_url());
		}
		$data = [];
		$data['page_title'] = "Customer Password";
		$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'), 'customer_list');
		$data['main_content'] = $this->load->view('customer/change_password', $data, TRUE);
		$this->load->view('customer/index', $data);
	}



	public function logout()
	{
		$this->session->unset_userdata('is_customer');
		$sdata = array();
		$sdata['msg'] = 'Successfully logout';
		$this->session->set_userdata($sdata);
		redirect('login', 'refresh');
	}

	public function order_list()
	{
		if (empty(auth('is_customer'))) {
			redirect(base_url());
		}
		$data = [];
		$data['page_title'] = "Customer OrderList";
		$data['info'] = $this->admin_m->single_select_by_id(auth('customer_id'), 'customer_list');
		$data['order_list'] = $this->admin_m->get_customer_order_list(auth('customer_id'));
		$data['main_content'] = $this->load->view('customer/order_list', $data, TRUE);
		$this->load->view('customer/index', $data);
	}


	public function change_status($status, $id)
	{
		$data = [
			'status' => $status
		];

		$this->admin_m->update($data, $id, 'service_order');
		redirect($_SERVER['HTTP_REFERER']);
	}


	public function add_rating()
	{

		$this->form_validation->set_rules('customer_rating', 'Rating', 'trim|required|xss_clean');
		$this->form_validation->set_rules('customer_review', 'Comments', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data = [
				'customer_rating' => $this->input->post('customer_rating'),
				'customer_review' => $this->input->post('customer_review'),
				'rating_time' => d_time(),
			];
			$uid = $this->input->post('uid');
			$insert = $this->admin_m->update_by_uid($data, $uid);

			if ($insert) :
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			else :
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			endif;
		}
	}

	public function forgot($type = '')
	{
		$data = array();
		$data['page_title'] = "Forgot";
		$data['page'] = "Login";
		$data['type'] = isset($type) ? $type : "";
		$data['main_content'] = $this->load->view('frontend/customer/forgot', $data, TRUE);
		$this->load->view('frontend/index', $data);
	}


	public function check_customer_info()
	{
		is_test();
		$this->form_validation->set_rules('phone', __('phone'), 'trim|xss_clean');
		$this->form_validation->set_rules('email', __('email'), 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> Sorry! </strong> ' . validation_errors() . '
				</div>';
			echo json_encode(array('st' => 0, 'msg' => $msg,));
			exit();
		} else {

			$phone = $this->input->post('phone', true);
			$email = $this->input->post('email', true);



			if (empty($phone) && empty($email)) :
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i>' . __('sorry') . ' </strong> ' . __('required_fields_cannot_be_empty') . '
				</div>';
				echo json_encode(array('st' => 0, 'msg' => $msg,));
				exit();
			endif;

			$is_email = 0;

			if (preg_match('/^[0-9]+$/', $phone)) {
				$check_email = $this->admin_m->check_valid_customer_phone(trim($phone));
				$is_email = 0;
			}

			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$check_email = $this->admin_m->check_valid_customer_email(trim($email));
				$is_email = 1;
			}



			if ($check_email == FALSE) {
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> ' . __('sorry') . ' </strong>' . __('invalid') . '
			</div>';
				echo json_encode(array('st' => 0, 'msg' => $msg,));
				exit();
			} else {
				$data = [];
				if ($is_email == 0) :
					$question = isJson($check_email['question']) ? json_decode($check_email['question']) : '';
					if (empty($question)) {
						$msg = '<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong><i class="fas fa-frown"></i> Sorry! </strong>You are not added security questions. Please contact to your store!
						</div>';
						echo json_encode(array('st' => 0, 'msg' => $msg,));
						exit();
					} else {

						$data['customer_data'] = $check_email;
						$data['question'] = $this->admin_m->single_select_by_id($question->id, 'question_list');

						$load_data = $this->load->view('frontend/customer/question_field', $data, TRUE);
						echo json_encode(array('st' => 1, 'data' => $load_data, 'is_modal' => 1));
					}
				else :
					$id = $check_email['id'];
					$new_password = random_string('alnum', 5);
					$check_email['password'] = $new_password;
					$data = [
						'password' => md5($new_password),
					];

					if (isset($check_email['user_id']) && !empty($check_email['user_id'])) :
						$sent = $this->forget_mail($type = 'user', $check_email);
					else :
						$sent = $this->forget_mail($type = 'admin', $check_email);
					endif;




					if ($sent == 1) :
						$this->common_m->update($data, $id, 'customer_list');
						$msg = '<div class="alert alert-success alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong><i class="fas fa-check"></i> ' . __('success') . ' </strong> ' . lang("password_change_successfully") . '
						</div>';
						echo json_encode(array('st' => 1, 'msg' => $msg, 'url' => base_url('staff-login/customer'), 'is_modal' => 0));
						exit();
					else :
						$msg = '<div class="alert alert-error alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong><i class="fas fa-ban"></i> ' . __('sorry') . ' </strong> ' . lang("error_text") . '
						</div>';
						echo json_encode(array('st' => 1, 'msg' => $msg, 'url' => base_url('staff-login/customer')));
						exit();
					endif;


				endif;
			}
		}
	}

	/*----------------------------------------------
             forgot customer email         
    ----------------------------------------------*/

	protected function forget_mail($type, $data)
	{
		$user_name = $data['customer_name']; // Get the user's name from your database


		$subject = !empty(__('forget_password')) ? __('forget_password') : "Forgot password";
		$message = '
            <p>Dear ' . $user_name . ',</p>
            <p>You recently requested to reset your password for your account.</p>
            <p><u><b>' . $data["password"] . '<b></u></p>
            <p>Thank you</p>
        ';

		if ($type == 'user') :
			$mail_info = ['msg' => $message, 'subject' => $subject, 'type' => 1, 'mail_to' => $data['email']];
			$send = $this->user_email_m->customer_forget_password($data['user_id'], $mail_info);
		else :
			$send = $this->email_m->send_mail('', $data['email'], $subject, $message);
		endif;



		if ($send) {
			return true;
		} else {
			return false;
		}
	}


	public function recovery_password()
	{
		is_test();
		$this->form_validation->set_rules('answer', 'Question Answer', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'New Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong><i class="fas fa-frown"></i> Sorry! </strong> ' . validation_errors() . '
		</div>';
			echo json_encode(array('st' => 0, 'msg' => $msg,));
			exit();
		} else {
			$id = $_POST['customer_id'];
			$customer_data = $this->admin_m->single_select_by_id($id, 'customer_list');
			$question = isJson($customer_data['question']) ? json_decode($customer_data['question']) : '';
			$answer = $this->input->post('answer', true);
			if (isset($question) && !empty($customer_data)) :
				if ($answer == $question->answer) {
					$data = [
						'password' => md5($_POST['password']),
					];
					$this->common_m->update($data, $id, 'customer_list');

					$msg = '<div class="alert alert-success alert-dismissible">
		 			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong><i class="fas fa-check"></i> Success! </strong> ' . lang("password_change_successfully") . '
		 		</div>';
					echo json_encode(array('st' => 1, 'msg' => $msg, 'url' => base_url('staff-login/customer')));
				} else {
					$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><i class="fas fa-frown"></i> ' . lang("sorry") . ' </strong>' . lang("security_question_ans_not_correct") . '
			</div>';
					echo json_encode(array('st' => 0, 'msg' => $msg,));
				}
			endif;
		}
	}



	public function subscription_invoice($id)
	{

		$data = array();
		$data['page_title'] = "subscriptions  Invoice";
		$info = $this->admin_m->single_select_by_md5_id($id, 'payment_info');
		if (empty($info)) {
			redirect($_SERVER['HTTP_REFERER']);
		}

		$data['st'] = (object) settings();
		$data['admin'] = admin();
		$data['u'] = (object) $this->admin_m->get_user_info_by_id($info->user_id);
		$data['invoice_info'] = $this->admin_m->get_subscribed_package($info->user_id, $info->account_type);
		if (isset($data['invoice_info']->referal_code) && !empty($data['invoice_info']->referal_code)) :
			$data['ref_info'] = $this->affiliate_m->get_affiliate_info_by_code($data['invoice_info']->referal_code, $info->user_id);
		endif;
		$data['tax'] = isset($data['st']->invoice_config) && isJson($data['st']->invoice_config) ? json_decode($data['st']->invoice_config) : '';

		$data['main_content'] = $this->load->view('common/subscription_invoice', $data, TRUE);
		$this->load->view('index', $data);
	}


	/*----------------------------------------------
     SEND CUSTOMER OTP 
    ----------------------------------------------*/

	public function send_otp()
	{
		$otp_type =  $this->input->post('otp_type', true);

		if ($otp_type == 'phone'):
			$this->form_validation->set_rules('phone', __('phone'), 'required|trim|xss_clean');
			$this->form_validation->set_rules('dial_code', __('dial_code'), 'required|trim|xss_clean');
		endif;

		if ($otp_type == 'email'):
			$this->form_validation->set_rules('phone', __('email'), 'trim|xss_clean|required|valid_email');
		endif;



		if ($this->form_validation->run() == FALSE) {
			__response(["st" => 0, 'msg' => validation_errors()]);
			return;
		} else {

			$phone = $customer_email = $without_dial_code = $dial_code = '';
			$country_id = 0;
			$id = $this->input->post('id', TRUE);
			$customer_phone = trim($this->input->post('phone', TRUE));
			$s_info =  restaurant($id);


			if (empty($id) && empty($s_info)) {
				__response(['st' => 0, 'msg' => __('invalid')]);
				return;
			}



			if (filter_var($customer_phone, FILTER_VALIDATE_EMAIL)):
				$customer_email = $customer_phone;
				$customer_info = $this->db->where(['email' => $customer_email])->get('customer_list')->row();
			elseif (preg_match('/^0?\d{10,18}$/', $customer_phone)):
				$dial_code = get_phone($this->input->post('dial_code', TRUE));
				$country_id = $this->db->like("REPLACE(dial_code, '+', '')", $dial_code, 'after', FALSE)
					->get('country')
					->row()->id ?? 0;

				$phone = get_phone($dial_code . $customer_phone);
				$without_dial_code = $customer_phone;
				$customer_info = $this->db->where('phone', $phone)
					->or_where('phone', get_phone($without_dial_code))
					->get('customer_list')
					->row();
			else:
				$customer_info = [];
				__response(['st' => 0, 'msg' => __('invalid')]);
				return;
			endif;



			if (empty($customer_info)) :
				$data = [
					'dial_code' => $dial_code ?? '',
					'phone' => $phone ?? '',
					'email' => $customer_email ?? '',
					'country_id' => $country_id,
					'user_id' => $id,
					'shop_id' => $s_info->id ?? 0,
				];
				$customer_id =  $this->common_m->insert($data, 'customer_list');
			else :
				$customer_id = $customer_info->id;
			endif;


			$otp = generate_otp($customer_id, $phone);

			if (isset($otp['error'])) {
				__response(['st' => 0, 'msg' => $otp['error']]);
				return;
			}

			if (isset($otp['otp'])) {
				if (isset($s_info->is_customer_login) && $s_info->is_customer_login == 2) :
					$this->user_email_m->send_otp_mail($id, $customer_email, $otp['otp']);
				endif;

				if (isset($s_info->is_customer_login) && $s_info->is_customer_login == 3 && !empty($phone)) :
					$sms = $this->system_model->send_otp_sms($id, $phone, $otp['otp']);

					if (isset($sms['status']) && $sms['status'] == 0 && $this->env == 1):
						__response(['st' => 0, 'msg' => $sms['msg']]);
						return;
					endif;

				endif;


				$customer_info = [
					'customer_id' => $customer_id,
					'phone' => $without_dial_code ?? '',
					'dial_code' => $dial_code ?? '',
					'email' => $customer_email
				];

				$this->session->set_userdata('customer_info', $customer_info);
				$load_data = $this->load->view('layouts/otp/otp_modal', ['customer_id' => $customer_id, 'phone' => $customer_phone, 'email' => $customer_email, 'dial_code' => $dial_code ?? '', 'id' => $id], TRUE);
				__response(['st' => 1, 'otp_id' => $customer_id, 'phone' => $customer_phone, 'email' => $customer_email, 'load_data' => $load_data]);
			} else {
				__response(['st' => 0, 'msg' => __('error_msg')]);
				return;
			}
		}
	}


	/*----------------------------------------------
      VERIFY CUSTOMER OTP 
    ----------------------------------------------*/
	public function verify_otp()
	{
		$this->form_validation->set_rules('otp[]', __('otp'), 'required');

		if ($this->form_validation->run() == FALSE) {
			__response(["st" => 0, 'msg' => validation_errors()]);
			return;
		} else {
			$data = [];
			$isLoad = 0;
			$entered_otp = $this->input->post('otp', TRUE);
			$entered_otp = implode('', $entered_otp);
			$customer_id = __ctemp('otp_id', 'otp_data');
			if (!$customer_id) {
				__response(['st' => 0, 'msg' => __("session_expired_request_a_new_otp")]);
				return;
			}

			// Call the verify_otp function
			$result = verify_otp($customer_id, $entered_otp);

			if (isset($result['error'])) {
				__response(['st' => 0, 'msg' => $result['error']]);
				return;
			} else {
				$customer_info = s_id($customer_id, 'customer_list');
				if (empty($customer_info->name) && empty($customer_info->password)):
					$isLoad = 1;
					$data['cinfo'] = $customer_info;
					$data['id'] = $customer_info->user_id ?? 0;
					$load = $this->load->view('layouts/otp/otp_customer_info', $data, true);
				endif;

				$this->session->set_userdata('customer_info', ['is_otp_login' => 1, 'customer_id' => $customer_id,  'is_customer' => TRUE, 'role' => 'customer', 'info' => $customer_info ?? []]);
				__response(['st' => 1, 'msg' => __('success_msg'), 'load_view' => $load ?? '', 'isLoad' => $isLoad]);
				return;
			}
		}
	}

	/*----------------------------------------------
     ADD INFORMATION AFTER OTP SUCCESS 
    ----------------------------------------------*/
	public function add_otp_info()
	{
		$customer_id = $this->input->post('customer_id', TRUE);

		$this->form_validation->set_rules('name', __('name'), 'required|trim|xss_clean');



		$email_rule = 'trim|xss_clean|valid_email';
		$email_rule .= $customer_id ? '|callback_check_unique[customer_list.email.' . $customer_id . ']' : '|is_unique[customer_list.email]';


		$this->form_validation->set_rules(
			'email',
			__('email'),
			$email_rule,
			array(
				'is_unique' => lang('email_already_exists'),
				'check_unique' => lang('email_already_exists')
			)
		);


		$phone_rule = 'trim|xss_clean';
		$phone_rule .= $customer_id ? '|callback_check_unique[customer_list.phone.' . $customer_id . ']' : '|is_unique[customer_list.phone]';
		$this->form_validation->set_rules(
			'phone',
			__('phone'),
			$phone_rule,
			array(
				'is_unique' => lang('phone_already_exists'),
				'check_unique' => lang('phone_already_exists')
			)
		);


		$this->form_validation->set_rules('password', __('password'), 'trim|xss_clean|required');


		if ($this->form_validation->run() == FALSE) {
			__response(['st' => 0, 'msg' => validation_errors()]);
			return;
		} else {

			$email = $this->input->post('email', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$dial_code = $this->input->post('dial_code', TRUE);

			$country_id = $this->db->like("REPLACE(dial_code, '+', '')", $dial_code, 'after', FALSE)
				->get('country')
				->row()->id ?? 0;


			$data = [
				'customer_name' => $this->input->post('name', TRUE),
				'password' => md5($this->input->post('password', TRUE)),
				'dial_code' => $this->input->post('dial_code', TRUE) ?? '',
				'country_id' => $country_id ?? 0,
			];

			if (empty($customer_id)) {
				__response(['st' => 0, 'msg' => __('error_msg')]);
				return;
			} else {
				if (isset($phone) && !empty($phone)) {
					$data['phone'] = $phone;
				}

				if (isset($email) && !empty($email)) {
					$data['email'] = $email;
				}

				$this->admin_m->update($data, $customer_id, 'customer_list');
				__response(['st' => 1, 'msg' => __('success_msg')]);
				return;
			}
		}
	}

	public function check_unique($value, $params)
	{

		return is_unique($value, $params);
	}
}
