<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array();
		$data['page_title'] = "Page List";
		$data['page'] = "Pages";
		$data['data'] = false;
		if (restaurant()->is_multi_lang == 1) :
			$data['pages'] = $this->admin_m->select_all_by_user_ln('vendor_page_list');
		else :
			$data['pages'] = $this->admin_m->select_all_by_user('vendor_page_list');
		endif;
		$data['main_content'] = $this->load->view('backend/vendor/page_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}

	public function edit_page($id)
	{
		$data = array();
		$data['page_title'] = "Create Pages";
		$data['page'] = "Pages";
		$data['data'] = $this->admin_m->single_select_by_id($id, 'vendor_page_list');
		if (restaurant()->is_multi_lang == 1) :
			$data['pages'] = $this->admin_m->select_all_by_user_ln('vendor_page_list');
		else :
			$data['pages'] = $this->admin_m->select_all_by_user('vendor_page_list');
		endif;
		if (empty($data['data'])) :
			valid_user($data['data']['user_id']);
		endif;
		$data['main_content'] = $this->load->view('backend/vendor/page_list', $data, TRUE);
		$this->load->view('backend/index', $data);
	}



	public function create_page()
	{
		is_test();
		$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		if ($id == 0) :
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|callback_english_check');
		else :
			$this->form_validation->set_rules('slug', 'Slug', 'trim|required|xss_clean|callback_english_check');
		endif;
		$this->form_validation->set_rules('details', 'Details', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			$this->index();
		} else {
			$data = array(
				'title' => $this->input->post('title', TRUE),
				'slug' => str_slug($this->input->post('slug', TRUE)),
				'details' => $this->input->post('details'),
				'status' => isset($_POST['status']) ? $_POST['status'] : 0,
				'is_menu_bar' => isset($_POST['is_menu_bar']) ? 1 : 0,
				'shop_id' => restaurant()->id,
				'language' => isset($_POST['language']) ? $_POST['language'] : site_lang(),
				'user_id' => auth('id'),
			);

			if ($id == 0) {
				$insert = $this->admin_m->insert($data, 'vendor_page_list');
			} else {
				$insert = $this->admin_m->update($data, $id, 'vendor_page_list');
			}

			if ($insert) {
				$this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
				redirect(base_url('admin/pages'));
			} else {
				$this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
				redirect(base_url('admin/pages'));
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

	public function delete_room_number($id)
	{
		if (isset($_GET['key'])) {
			$old = single_select_by_id($id, 'hotel_list');
			$old_img = json_decode($old['room_numbers'], TRUE);
			$getImg = $old_img[$_GET['key']];

			unset($old_img[$_GET['key']]);
			$this->admin_m->update(['room_numbers' => json_encode($old_img)], $id, 'hotel_list');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */