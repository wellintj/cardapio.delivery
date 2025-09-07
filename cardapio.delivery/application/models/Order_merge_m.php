<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_merge_m extends CI_Model
{
    public function __construct()
    {
        // parent::__construct();
        $this->load->model('common_m');
    }

    public function handle_order_merge($shop_info, $orderData, $customerData, $prices)
    {
        $is_merge = $this->input->post('is_merge', true);
        $order_merge_config = @!empty($shop_info['order_merge_config']) ? json_decode($shop_info['order_merge_config']) : '';

        // Return early if merge is not enabled or guest login
        if (
            !isset($order_merge_config->is_order_merge) || $order_merge_config->is_order_merge != 1 ||
            $orderData['is_guest_login'] == 1
        ) {
            return ['is_new_order' => 1];
        }

        // Check for latest order
        $latest_order = $this->common_m->check_latest_order(
            $orderData['shop_id'],
            $orderData['order_type'],
            $customerData['email'],
            $customerData['phone'],
            $customerData['customer_id']
        );

        if (empty($latest_order) || !is_object($latest_order) || (isset($is_merge) && $is_merge == 0)) {
            return ['is_new_order' => 1];
        }

        $merge_id = $latest_order->uid . '_' . random_string('numeric', 4);

        // If order type is not allowed for merging, return new order
        if (!$this->is_mergeable_order_type($orderData['order_type'])) {
            return ['is_new_order' => 1];
        }

        // Handle manual merge confirmation if needed
        if ($this->should_confirm_merge($order_merge_config, $latest_order, $orderData)) {
            return $this->prepare_merge_confirmation($latest_order, $orderData, $prices);
        }

        // Process merge based on order type
        return $this->process_order_merge(
            $latest_order,
            $orderData,
            $prices,
            $merge_id
        );
    }

    private function is_mergeable_order_type($order_type)
    {
        // Define allowed order types for merging
        $order_type = Order::type($order_type);
        $allowed_types = ['cod', 'dine-in', 'paycash', 'room-service']; // delivery, table, pickup
        return in_array($order_type, $allowed_types);
    }



    private function should_confirm_merge($config, $latest_order, $orderData)
    {
        $order_type = Order::type($orderData['order_type']);
        if (!isset($config->is_system) || $config->is_system != 2 || isset($_POST['is_merge'])) {
            return false;
        }

        // First check if order type is allowed for merging
        if (!$this->is_mergeable_order_type($orderData['order_type'])) {
            return false;
        }

        // For table orders, only merge if same table
        if ($order_type == 'dine-in') {
            return $latest_order->table_no == $orderData['table_no'];
        }

        if ($order_type == 'room-service') {
            return $latest_order->hotel_id == $orderData['hotel_id'] && $latest_order->room_number == $orderData['room_number'];
        }
        return true;
    }

    private function prepare_merge_confirmation($recent_order, $orderData, $prices)
    {
        $data = [];
        $data['order'] = $this->common_m->get_order_details($recent_order->uid, $recent_order->shop_id);
        // Get current calculated totals
        $totals = $this->calculate_merge_totals($recent_order, $orderData, $prices);

        $data['current_total'] = currency_position($totals['current_order_total'], $recent_order->shop_id);
        $data['previous_total'] = currency_position($totals['previous_order_total'], $recent_order->shop_id);
        $data['merged_total'] = currency_position($totals['total'], $recent_order->shop_id);

        $details = $this->load->view('common_layouts/order_merge_info', $data, true);

        return [
            'st' => 3,
            'is_merge' => 1,
            'details' => $details
        ];
    }

    private function process_order_merge($recent_order, $orderData, $prices, $merge_id)
    {
        // Get calculated totals
        $totals = $this->calculate_merge_totals($recent_order, $orderData, $prices);

        $base_update_data = [
            'total' => $totals['total'],
            'sub_total' => $totals['sub_total'],
            'tax_fee' => $totals['tax_fee'],
            'is_order_merge' => 1,
            'merge_status' => 1,
            'is_ring' => 1,
            'status' => $recent_order->status ?? 0,
            'is_preparing' => $recent_order->is_preparing ?? 0,
        ];

        $current_data = array_merge($orderData, $base_update_data);

        // Update the existing order
        $update = $this->common_m->update($current_data, $recent_order->id, 'order_user_list');

        // Set merge session data
        $this->session->set_userdata(['is_merge' => 1, 'merge_id' => $merge_id]);

        // Send merge notification
        $this->version_changes_m->pusher(
            $orderData['shop_id'],
            'order_merge',
            ['old_id' => $recent_order->uid, 'merge_id' => $merge_id]
        );

        return [
            'merge_id' => $update ?? 0,
            'is_new_order' => 0,
            'merged_data' => array_merge((array)$recent_order, $current_data)
        ];
    }

    private function calculate_merge_totals($recent_order, $orderData, $prices)
    {
        return [
            'total' => $orderData['total'] + $recent_order->total,
            'sub_total' => $orderData['sub_total'] + $recent_order->sub_total,
            'tax_fee' => $orderData['tax_fee'] + $recent_order->tax_fee,
            'current_order_total' => $orderData['total'],
            'previous_order_total' => $recent_order->total
        ];
    }
}
