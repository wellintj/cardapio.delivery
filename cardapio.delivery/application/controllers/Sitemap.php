<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data = [];
        $data['urls'] = $this->admin_m->select('sitemap_list');
        $this->output->set_content_type('application/xml');
        $this->load->view('sitemap', $data);
    }

    public function sitemap()
    {
        check_valid_auth();
        is_login();

        $data = array();
        $data['page_title'] = "Site Map";
        $data['page'] = "Sitemap";
        $data['data'] = false;
        $data['site_map_list'] = $this->admin_m->select('sitemap_list');
        $data['main_content'] = $this->load->view('backend/admin_activities/sitemap_list', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    public function add_sitemap()
    {
        is_test();
        check_valid_auth();
        is_login();

        $id = $this->input->post('id');
        $this->form_validation->set_rules('url', __('url'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect(base_url('sitemap/sitemap'));
        } else {
            $data = array(
                'url' => $this->input->post('url', TRUE),
                'changefreq' => $this->input->post('changefreq', TRUE),
                'status' => 1,
                'created_at' => today(),
            );

            if ($id == 0) {
                $insert = $this->admin_m->insert($data, 'sitemap_list');
            } else {
                $insert = $this->admin_m->update($data, $id, 'sitemap_list');
            }

            if ($insert) {
                $this->custom_m->generate();
                $this->session->set_flashdata('success', !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful');
                redirect(base_url('sitemap/sitemap'));
            } else {
                $this->session->set_flashdata('error', !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!!');
                redirect(base_url('sitemap/sitemap'));
            }
        }
    }

    public function delete($id, $table)
    {
        is_test();
        $del = $this->admin_m->delete($id, $table);
        if ($del) {
            $this->custom_m->generate();
            $this->session->set_flashdata('success', 'Item Deleted');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('error', 'Somthing worng. Error!!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
