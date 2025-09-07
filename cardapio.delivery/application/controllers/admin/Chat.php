<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('version_changes_m');
    }


    public function user_chat()
    {
        check_valid_user();
        $data = array();
        $data['page_title'] = "Chat";
        $data['page'] = "Chat";
        $data['sender_id'] = auth('id');
        $data['receiver_id'] = admin()->id;
        $data['role'] = 'user';
        $data['info'] = $this->admin_m->single_select_by_id_row(auth('id'), 'users');
        $data['message_list'] = $this->admin_m->get_user_message(auth('id'));

        $data['main_content'] = $this->load->view('backend/chat/chat', $data, TRUE);
        $this->load->view('backend/index', $data);
    }


    public function index()
    {
        check_valid_auth();
        $data = array();
        $data['page_title'] = "Chat";
        $data['page'] = "Chat";

        $q = $this->input->get('q', true);
        $data['q'] = isset($q) && !empty($q) ? $q : 0;
        $data['qinfo'] = $this->admin_m->get_sender_id($data['q']);

        $data['receiver_id'] = !empty($data['qinfo']) ? $data['qinfo']->sender_id : 0;
        $data['sender_id'] = auth('id');

        $data['role'] = 'admin';
        $data['user_message'] = $this->admin_m->get_users_list();
        $data['info'] = $this->admin_m->single_select_by_id_row(auth('id'), 'users');
        $data['user_message'] = $this->admin_m->get_users_list();

        $data['message_list'] = $this->admin_m->get_admin_user_message($data['sender_id'], $data['receiver_id']);


        $data['main_content'] = $this->load->view('backend/chat/chat', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    public function get_message($sender_id = null, $receiver_id = null)
    {
        if (auth('user_role') == 1) :
            $this->get_admin_message($sender_id, $receiver_id);
        else :
            $this->get_user_message($sender_id, $receiver_id);
        endif;
    }


    function get_user_message($sender_id = null, $receiver_id = null)
    {
        $data = [];
        $sender_id = !empty($sender_id) ? $sender_id : auth('id');
        $data['message_list'] = $this->admin_m->get_user_message($sender_id, $receiver_id);
        $load = $this->load->view('backend/chat/chat_thumb', $data, TRUE);
        echo json_encode(['st' => 1, 'sender_id' => $sender_id, 'load_data' => $load]);
    }

    function get_admin_message($sender_id = null, $receiver_id = null)
    {
        $data = [];
        $sender_id = !empty($sender_id) ? $sender_id : auth('id');
        $data['message_list'] = $this->admin_m->get_admin_user_message($sender_id, $receiver_id);
        $load = $this->load->view('backend/chat/chat_thumb', $data, TRUE);
        echo json_encode(['st' => 1, 'sender_id' => $sender_id, 'load_data' => $load]);
    }


    function search()
    {
        $data = [];
        $data['user_list'] = $this->admin_m->get_users_list();
        $load = $this->load->view('backend/chat/user_thumb', $data, TRUE);
        echo json_encode(['st' => 1,  'load_data' => $load]);
    }

    function change_status($id)
    {
        $data = [
            'status' => 'seen'
        ];

        $this->db->where(['sender_id' => $id])->update('chat_list', xs_clean($data));
        echo json_encode(['st' => 1]);
    }

    public function send()
    {
        is_test();

        $this->form_validation->set_rules('message', lang('message'), 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {
            __request(validation_errors(), $status = 0);
        } else {
            if (auth('user_role') == 1) {
                $role = 'admin';
            } else {
                $role = 'user';
            }

            $q = $this->input->post('q', true);
            $data = array(
                'sender_id' => $this->input->post('sender_id', TRUE),
                'receiver_id' => $this->input->post('receiver_id', TRUE),
                'role' => $role ?? 'admin',
                'message' => $this->input->post('message', TRUE),
                'created_at' => d_time(),
            );
            $send = $this->admin_m->insert($data, 'chat_list');
            if ($send) {

                $this->version_changes_m->msgpusher($data['sender_id'], $data['receiver_id'], $data['role'], 'new_message');
                __request('', $status = 1);
            } else {
                __request('', $status = 0);
            }
        }
    }
}
