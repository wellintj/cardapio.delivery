<?php
class Order_merge_m extends CI_Model
{
    /**
     * Handle order merge configuration and execution
     * @param array $shop_info Shop configuration and details
     * @param array $data Current order data containing shop_id, order_type, customer_data, table_no, sub_total, tax_fee, is_guest_login
     * @param float $total Current order total
     * @return array Returns merge result
     */
    public function handle_order_merge($shop_info, $data, $total)
    {
        // Early return if merge not enabled or guest login
        if (!$this->is_merge_enabled($shop_info) || $data['is_guest_login']) {
            return ['is_new_order' => 1, 'data' => $data];
        }

        // Get recent order that could be merged
        $recent_order = $this->find_recent_order($data);
        if (!$recent_order) {
            return ['is_new_order' => 1, 'data' => $data];
        }

        // Generate merge ID
        $merge_id = $recent_order->uid . '_' . random_string('numeric', 4);

        // Check if we need to prompt user for merge
        if ($this->should_prompt_for_merge($shop_info, $data, $recent_order)) {
            return $this->generate_merge_prompt($recent_order);
        }

        // Process merge if confirmed or auto-merge enabled
        if ($this->should_process_merge($recent_order, $data)) {
            return $this->process_merge($recent_order, $data, $total, $merge_id);
        }

        return ['is_new_order' => 1, 'data' => $data];
    }

    /**
     * Check if order merging is enabled in shop config
     */
    private function is_merge_enabled($shop_info)
    {
        $merge_config = @!empty($shop_info['order_merge_config']) ?
            json_decode($shop_info['order_merge_config']) : '';

        return isset($merge_config->is_order_merge) &&
            $merge_config->is_order_merge == 1;
    }

    /**
     * Find recent order that could be merged
     */
    private function find_recent_order($data)
    {
        $customer_data = $data['customer_data'];
        return $this->common_m->check_latest_order(
            $data['shop_id'],
            $data['order_type'],
            $customer_data['email'],
            $customer_data['phone'],
            $customer_data['customer_id']
        );
    }

    /**
     * Check if we need to prompt user for merge decision
     */
    private function should_prompt_for_merge($shop_info, $data, $recent_order)
    {
        $merge_config = json_decode($shop_info['order_merge_config']);

        if (
            isset($merge_config->is_system) &&
            $merge_config->is_system == 2 &&
            !isset($_POST['is_merge'])
        ) {
            if ($data['order_type'] == 6) {
                return $recent_order->table_no == $data['table_no'];
            }

            return in_array($data['order_type'], [1, 9]);
        }

        return false;
    }

    /**
     * Generate merge prompt details
     */
    private function generate_merge_prompt($recentOrder)
    {
        $data = [];
        $data['order'] = $this->common_m->get_order_details($recentOrder->uid, $recentOrder->shop_id);

        $details = $this->load->view('common_layouts/order_merge_info', $data, true);


        // $details = "<div class='recentDetails'>
        //     <p class='mt-5'><b>" . lang('previous_order') . "</b></p>
        //     <ul>
        //         <li><span>" . lang('order_id') . "</span>: <span>#{$recentOrder->uid}</span></li>
        //         <li><span>" . lang('grand_total') . "</span>: <span>" .
        //     currency_position($recentOrder->total, $recentOrder->shop_id) .
        //     "</span></li>
        //     </ul>
        // </div>";


        return [
            'st' => 3,
            'is_merge' => 1,
            'details' => $details
        ];
    }

    /**
     * Check if we should process the merge
     */
    private function should_process_merge($recent_order, $data)
    {
        $is_merge = $this->input->post('is_merge', TRUE);
        if (isset($is_merge) && $is_merge == 0) {
            return false;
        }

        if ($data['order_type'] == 6) {
            return $recent_order->table_no == $data['table_no'];
        }

        return in_array($data['order_type'], [1, 9]);
    }

    /**
     * Process the actual order merge
     */
    private function process_merge($recent_order, $data, $total, $merge_id)
    {
        $update_data = [
            'total' => $total + $recent_order->total,
            'sub_total' => $data['sub_total'] + $recent_order->sub_total,
            'tax_fee' => $data['tax_fee'] + $recent_order->tax_fee,
            'is_order_merge' => 1,
            'merge_status' => 1,
            'is_ring' => 1,
            'status' => 1,
            'is_preparing' => 1
        ];

        $insert = $this->common_m->update($update_data, $recent_order->id, 'order_user_list');

        if ($insert) {
            $this->session->set_userdata([
                'is_merge' => 1,
                'merge_id' => $merge_id
            ]);

            // Send merge notification
            $this->version_changes_m->pusher(
                $data['shop_id'],
                'order_merge',
                [
                    'old_id' => $recent_order->uid,
                    'merge_id' => $merge_id
                ]
            );

            return [
                'is_new_order' => 0,
                'data' => array_merge((array)$recent_order, $update_data),
                'merge_id' => $merge_id
            ];
        }

        return ['is_new_order' => 1, 'data' => $data];
    }
}
