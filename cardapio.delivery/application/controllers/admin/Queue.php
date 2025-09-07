<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Queue extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_valid_auth();
        $this->load->model('queue_m');
    }

    public function cloneShop()
    {
        $data = array();
        $data['page_title'] = "Clone Restaurant";
        $data['page'] = "Queue";
        $data['data'] = false;
        $data['userList'] = $this->admin_m->select('users');
        $data['newRestaurant'] = $this->queue_m->get_new_restaurant();
        $data['permission_list'] = $this->admin_m->select_permossion('admin_staff');
        $data['main_content'] = $this->load->view('backend/queue/clone_restaurant', $data, TRUE);
        $this->load->view('backend/index', $data);
    }

    public function clone()
    {
        is_test();
        $id = $this->input->post('id');
        $this->form_validation->set_rules('old_user_id', lang('clone_from_user'), 'trim|xss_clean|required');
        $this->form_validation->set_rules('new_user_id', lang("clone_for_user"), 'trim|xss_clean|required');
        if ($this->form_validation->run() == FALSE) {
            __request(validation_errors(), 0, '');
        } else {
            $shopTables = ['items', 'item_list', 'delivery_area_list', 'extra_libraries', 'hotel_list', 'item_category_list', 'item_packages'];
            $userTables = ['allergens','menu_type'];

            $old_user_id = $_POST['old_user_id'];
            $new_user_id = $_POST['new_user_id'];

            $old_shop_id = restaurant($old_user_id)->id;
            $new_shop_id = restaurant($new_user_id)->id;

            $user_data = array(
                'old_user_id' => $old_user_id,
                'new_user_id' => $new_user_id,
                'action_role' => 'user_id',
                'type' => 'clone'
            );

            $shop_data = array(
                'old_shop_id' => $old_shop_id,
                'new_shop_id' => $new_shop_id,
                'old_user_id' => $old_user_id,
                'new_user_id' => $new_user_id,
                'user_id' => $new_shop_id,
                'action_role' => 'shop_id',
                'type' => 'clone'
            );

            $this->queue_m->addToQueue($user_data, $userTables);
            $this->queue_m->addToQueue($shop_data, $shopTables);


              // Get the number of tasks for the progress bar
            $totalTasks = $this->queue_m->getTotalQueueItems('clone');

        // Initialize the progress
            $progress = 0;

            while ($completedTables = $this->queue_m->get_queue_items('clone', 10)) {
            // Update the progress
                $progress += count($completedTables);

            // Send the progress to the front-end using JSON
                echo json_encode(['progress' => $progress, 'totalTasks' => $totalTasks]);

            // Process the completed tables
                foreach ($completedTables as $table) {
                    echo '<h3>' . $table['table_name'] . '</h3>';
                    echo '<p>Data copied successfully <span style="color: green;">✓</span></p>';
                }
                
            // Sleep for a short time to give the server some rest
            usleep(500000); // Sleep for 0.5 seconds (adjust as needed)
        }

            // Send the final progress to the front-end
            echo json_encode(['progress' => $totalTasks, 'totalTasks' => $totalTasks]);
    }
}
}
