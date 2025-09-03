<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Queue_m extends CI_Model
{
    protected $table;
    public function __construct()
    {
        $this->db->query("SET sql_mode = ''");
        // old_shop_id, new_shop_id , old_user_id, new_user_id ,action_id, action_role, table_name, type, status
        $this->table = 'data_queue';
        set_time_limit(120);
    }


    public function addToQueue($data, $table_names)
    {
         $this->deleteOldCompletedTasks();
        foreach ($table_names as $table_name) {
            $data = array(
                'old_user_id' => $data['old_user_id'] ?? 0,
                'new_user_id' => $data['new_user_id'] ?? 0,
                'old_shop_id' => $data['old_shop_id'] ?? 0,
                'new_shop_id' => $data['new_shop_id'] ?? 0,
                'table_name' => $table_name,
                'action_role' => $data['action_role'] ?? '',
                'type' => $data['type'] ?? '',
                'status' => 'pending',
                'created_at' => d_time(),
            );

            if ($this->check_existing($data) == false) {
                $this->db->insert($this->table, $data);
            }
        }

        return true;
    }

    public function check_existing($data)
    {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where('old_user_id', $data['old_user_id']);
        $this->db->where('new_user_id', $data['new_user_id']);
        $this->db->where('old_shop_id', $data['old_shop_id']);
        $this->db->where('new_shop_id', $data['new_shop_id']);
        $this->db->where('table_name', $data['table_name']);
        $this->db->where('action_role', $data['action_role']);
        $this->db->where('type', $data['type']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getNextQueueItem($type)
    {
        $this->db->where('type', $type);
        $this->db->where('status', 'pending');
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get($this->table);

        return $query->row_array();
    }

    public function markAsCompleted($id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, array('status' => 'completed'));
    }

    public function getCompletedUserTables($user_id)
    {
        $this->db->where('new_user_id', $user_id);
        $this->db->where('status', 'completed');
        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    public function getCompletedShopTables($shop_id)
    {
        $this->db->where('new_shop_id', $shop_id);
        $this->db->where('status', 'completed');
        $query = $this->db->get($this->table);

        return $query->result_array();
    }

    public function getCompletedTables()
    {
        $this->db->where('status', 'completed');
        $query = $this->db->get($this->table);

        return $query->result_array();
    }


    public function copyDataForUser($old_user_id, $new_user_id, $table_name)
    {
        $source_query = $this->db->get_where($table_name, array('user_id' => $old_user_id));

        if ($source_query->num_rows() > 0) {
            $data_to_copy = $source_query->result_array();

            foreach ($data_to_copy as $row) {
                // Set the new user_id for the destination table
                $row['user_id'] = $new_user_id;

                unset($row['id']);
                // Insert the row into the destination table
                $this->db->insert($table_name, $row);
            }

            return $new_user_id;
        }
    }

    public function copyDataForshop($old_user_id, $new_user_id, $old_shop_id, $new_shop_id, $table_name)
    {
        if (!empty($old_user_id) && !empty($old_shop_id)) {
            $source_query = $this->db->get_where($table_name, array('user_id' => $old_user_id, 'shop_id' => $old_shop_id));
        } elseif (!empty($old_shop_id)) {
            $source_query = $this->db->get_where($table_name, array('shop_id' => $old_shop_id));
        }

        if ($source_query->num_rows() > 0) {
            $data_to_copy = $source_query->result_array();

            foreach ($data_to_copy as $row) {
                // Set the new user_id for the destination table
                if (!empty($row['user_id'])) {
                    $row['user_id'] = $new_user_id;
                }
                if (!empty($row['shop_id'])) {
                    $row['shop_id'] = $new_shop_id;
                }

                unset($row['id']);

                // Insert the row into the destination table
                $this->db->insert($table_name, $row);
            }
            return $new_shop_id;
        }
    }





    function get_queue_items($type, $max_execution_time = 60, $batch_size = 10)
    {
        $isDebug = false;
        $completed_tables = array();

        // Record the start time
        $start_time = microtime(true);
       

        while ($item = $this->getNextQueueItem($type)) {
            // Record the start time for each iteration
            $iteration_start_time = microtime(true);

            if ($item['action_role'] == 'user_id') {
                $user_id = $this->copyDataForUser($item['old_user_id'], $item['new_user_id'], $item['table_name']);
                $this->markAsCompleted($item['id']);
            }
            // Uncomment this part if 'shop_id' copying is needed
            elseif ($item['action_role'] == 'shop_id') {
                $shop_id = $this->copyDataForshop($item['old_user_id'], $item['new_user_id'], $item['old_shop_id'], $item['new_shop_id'], $item['table_name']);
                $this->markAsCompleted($item['id']);
            }

            // Record the end time for each iteration
            $iteration_end_time = microtime(true);

            // Calculate the iteration execution time
            $iteration_execution_time = $iteration_end_time - $iteration_start_time;
            if ($isDebug == TRUE) {
                // Display the iteration execution time
                echo "Iteration Execution Time: " . number_format($iteration_execution_time, 4) . " seconds<br>";
            }

            // Check execution time and exit if nearing the limit
            if ($iteration_end_time - $start_time > $max_execution_time) {
                break;
            }

            // Check if the batch limit is reached
            if (--$batch_size <= 0) {
                // Reset the batch size for the next iteration
                $batch_size = 10;

                // Calculate the remaining time in the current execution window
                $remaining_time = $max_execution_time - ($iteration_end_time - $start_time);

                // Sleep for a dynamic time based on remaining time
                usleep(max(500000, $remaining_time * 0.1)); // Sleep for 10% of the remaining time (minimum 0.5 seconds)
            }
        }

        // Record the end time
        $end_time = microtime(true);

        // Calculate the total execution time
        $execution_time = $end_time - $start_time;
        if ($isDebug == TRUE) {
            // Display the total execution time
            echo "Total Execution Time: " . number_format($execution_time, 4) . " seconds";
        }

        // Rest of your code...

        return $completed_tables;
    }


    public function getTotalQueueItems($type)
    {
        $this->db->where('type', $type);
        $this->db->where('status', 'pending');
        return $this->db->count_all_results($this->table);
    }






    public function deleteOldCompletedTasks()
    {
        $tenMinutesAgo = date('Y-m-d H:i:s', strtotime('-20 minutes'));

        // Delete completed tasks older than 10 minutes
        $this->db->where('status', 'completed');
        $this->db->where('created_at <=', $tenMinutesAgo);
        $this->db->delete($this->table);
    }

    public function get_new_restaurant()
    {
        $this->db->select('u.id as user_id, u.username, u.user_role, COUNT(i.id) as item_count,r.id as shop_id,u.email');
        $this->db->from('users u');
        $this->db->join('restaurant_list r', 'r.user_id = u.id', 'left');
        $this->db->join('items i', 'r.id = i.shop_id', 'left');
        $this->db->where('u.user_role', 0);
        $this->db->where('r.id !=', 0);
        $this->db->group_by('u.id');
        $this->db->having('item_count', 0);
        $query = $this->db->get();
        return $query->result();
    }
}
