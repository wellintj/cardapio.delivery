<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Statistics_m extends CI_Model
{
    public function __construct()
    {
        $this->db->query("SET sql_mode = ''");
    }

    public function get_income($type, $orderType = 0)
    {
        // $type='last7';
        $today = today();
        $shop_id = restaurant()->id;
        $last7 = make_day('7', 'days');
        $llast7 = get_last_date('7', 'days', make_day('7', 'days'));

        $yesterday = make_day('1', 'days');

        $lastMonth = make_day('1', 'month');

        $llastmonth = get_last_date('1', 'month', make_day('1', 'month'));
        if ($type == 'today') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
            $date = "{$today} - {$today}";
        elseif ($type == 'last7') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$last7}' AND '{$today}'";
            $date = "{$last7} - {$today}";
        elseif ($type == 'lastmonth') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$lastMonth}' AND '{$today}'";
            $date = "{$lastMonth} - {$today}";
        elseif ($type == 'nlm') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$llastmonth}' AND '{$lastMonth}'";
            $date = "{$llastmonth} - {$lastMonth}";
        elseif ($type == 'nl7') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$llast7}' AND '{$last7}'";
            $date = "{$llast7} - {$last7}";
        elseif ($type == 'nt') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$yesterday}' AND '{$yesterday}'";
            $date = "{$yesterday} - {$yesterday}";
        else :
            $date = '';
            $sql = '';
        endif;

        $this->db->select('ul.id,ul.completed_time,ul.status,ul.shop_id,total,uid,total');
        $this->db->from('order_user_list as ul');
        if (isset($sql) && !empty($sql)) :
            $this->db->where($sql);
        endif;
        $this->db->where('ul.completed_time IS NOT NULL', NULL, FALSE);
        $this->db->where('ul.status', 2);
        $this->db->where('ul.shop_id', $shop_id);

        if ($orderType != 0) {
            $this->db->where('ul.order_type', $orderType);
        }

        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            $query = $query->result();
            $total_order = sizeof($query);
            $total = 0;
            foreach ($query as $key => $row) :
                $total = ($total + (float) $row->total);
            endforeach;

            return (object)['amount' => $total, 'count' => $total_order, 'date' => $date];
        } else {
            return (object)['amount' => 0, 'count' => 0, 'date' => ''];
        }
    }


    public function get_daily_statistics($shop_id, $orderType = 0)
    {

        $today = today();

        $last7 = make_day('7', 'days');
        $llast7 = get_last_date('7', 'days', make_day('7', 'days'));

        $yesterday = make_day('1', 'days');

        $lastMonth = make_day('1', 'month');
        $llastmonth = get_last_date('7', 'month', make_day('1', 'month'));

        $type = $_GET['days'] ?? 'today';


        if ($type == 'today') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
        elseif ($type == 'last7') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$last7}' AND '{$today}'";
        elseif ($type == 'lastmonth') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$lastMonth}' AND '{$today}'";
        elseif ($type == 'nlm') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$llastmonth}' AND '{$lastMonth}'";
        elseif ($type == 'nl7') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$llast7}' AND '{$last7}'";
        elseif ($type == 'nt') :
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$yesterday}' AND '{$yesterday}'";
        elseif (isset($_GET['days']) && is_array($_GET['days'])) :
            $startDate = $_GET['days']['start_date'];
            $endDate = $_GET['days']['end_date'];
            $sql = "DATE_FORMAT(ul.completed_time,'%Y-%m-%d') BETWEEN '{$startDate}' AND '{$endDate}'";
        else :
            $sql = '';
        endif;

        $this->db->select('COUNT(ul.id) as Total_order');
        $this->db->select('SUM(ul.total) as total_price');
        $this->db->from('order_user_list as ul');
        if (isset($sql) && !empty($sql)) :
            $this->db->where($sql);
        endif;
        $this->db->where('ul.completed_time IS NOT NULL', NULL, FALSE);
        $this->db->where('ul.status', 2);
        $this->db->where('ul.shop_id', $shop_id);
        if ($orderType != 0) {
            $this->db->where('ul.order_type', $orderType);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return (object)['amount' => $query->row()->total_price ?? 0, 'count' => $query->row()->Total_order];
        } else {
            return (object)['amount' => 0, 'count' => 0];
        }
    }


    /*----------------------------------------------
    Statistics for pending/approved/completed status 
----------------------------------------------*/

    public function get_daily_order_statistics($shop_id, $orderType = 0, $status = 0, $is_deliveried = 0)
    {


        $today = today();
        $last7 = make_day('7', 'days');
        $llast7 = get_last_date('7', 'days', make_day('7', 'days'));

        $yesterday = make_day('1', 'days');

        $lastMonth = make_day('1', 'month');
        $llastmonth = get_last_date('7', 'month', make_day('1', 'month'));

        $type = $_GET['days'] ?? 'today';


        if ($type == 'today') :
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$today}' AND '{$today}'";
        elseif ($type == 'last7') :
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$last7}' AND '{$today}'";
        elseif ($type == 'lastmonth') :
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$lastMonth}' AND '{$today}'";
        elseif ($type == 'nlm') :
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$llastmonth}' AND '{$lastMonth}'";
        elseif ($type == 'nl7') :
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$llast7}' AND '{$last7}'";
        elseif ($type == 'nt') :
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$yesterday}' AND '{$yesterday}'";
        elseif (isset($_GET['days']) && is_array($_GET['days'])) :
            $startDate = $_GET['days']['start_date'];
            $endDate = $_GET['days']['end_date'];
            $sql = "DATE_FORMAT(ul.created_at,'%Y-%m-%d') BETWEEN '{$startDate}' AND '{$endDate}'";
        else :
            $sql = '';
        endif;

        $this->db->select('COUNT(ul.id) as Total_order');
        $this->db->select('SUM(ul.total) as total_price');
        $this->db->from('order_user_list as ul');
        if (isset($sql) && !empty($sql)) :
            $this->db->where($sql);
        endif;
        // $this->db->where('ul.completed_time IS NOT NULL', NULL, FALSE);

        $this->db->where('ul.status', $status);

        if ($is_deliveried != 0) {
            $this->db->where('ul.is_db_completed', 1);
        }

        if ($orderType != 0) {
            $this->db->where('ul.order_type', $orderType);
        }

        $this->db->where('ul.shop_id', $shop_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return (object)['amount' => $query->row()->total_price ?? 0, 'count' => $query->row()->Total_order];
        } else {
            return (object)['amount' => 0, 'count' => 0];
        }
    }


    public function get_dboy_statistics($dboy_id)
    {
        $this->db->select('or.*,sl.name as staff_name,sl.phone as staff_phone,sl.country_id,rl.id as shop_id,rl.name as shop_name');
        $this->db->from('order_user_list or');
        $this->db->join('staff_list sl', 'sl.id=or.customer_id', 'LEFT');
        $this->db->join('restaurant_list rl', 'rl.id=or.shop_id', 'LEFT');
        $this->db->where('or.dboy_id', $dboy_id);
        $this->db->where_in('or.order_type', [1]);
        $this->db->where('or.is_db_completed', 1);
        if (isset($_GET['q']) && $_GET['q'] == 'all') {
        } else {
            if (isset($_GET['m']) && isset($_GET['y'])) {
                $this->db->where("DATE_FORMAT(or.completed_time,'%Y-%m')", $_GET['y'] . '-' . $_GET['m']);
            } else {
                $this->db->where("DATE_FORMAT(or.completed_time,'%Y-%m')", date('Y') . '-' . date('m'));
            }
        }


        $this->db->order_by('or.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result_array();
        foreach ($query as $key => $value) {
            $this->db->select('SUM(oi.qty) as total_item');
            $this->db->from('order_item_list oi');
            $this->db->where('oi.order_id', $value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->row_array();
            $query[$key]['total_item'] = $query2['total_item'];
        }


        return $query;
    }

    public function get_dboy_date($dboy_id)
    {
        $this->db->distinct('or.completed_time');
        $this->db->from('order_user_list or');
        $this->db->where('or.dboy_id', $dboy_id);
        $this->db->where_in('or.order_type', [1]);
        $this->db->where('or.is_db_completed', 1);
        $this->db->order_by('or.completed_time', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $get_datetime = $query->result_array();
            foreach ($get_datetime as $key => $value) {
                $year[] = year($value['completed_time']);
                $month[] = month($value['completed_time']);
                $day[] = day($value['completed_time']);
            }
            return ['day' => array_unique($day), 'month' => array_unique($month), 'year' => array_unique($year)];
        } else {
            return ['day' => '', 'month' => '', 'year' => ''];
        }
    }

    public function get_reports($shop_id)
    {

        

        if (!empty($this->input->get('q', TRUE)) && $this->input->get('q', TRUE) == 'expenseReport') :
            $sql = __daterange('ex.created_at');
            $expense_list = $this->get_my_expenses($shop_id,$sql);
            return $expense_list;
        else :

            $sql = __daterange('ul.completed_time');

            $orderList =   $this->db->select('ul.*')
                ->from('order_user_list ul')
                ->where('ul.shop_id', $shop_id)
                ->where('ul.status', 2)
                ->where($sql)
                ->get()
                ->result();

            $order_ids = [];
            if (sizeof($orderList) > 0) :
                foreach ($orderList as  $key => $row) :
                    $order_ids[] = $row->id;
                endforeach;
                $item_list = $this->get_item_by_order_id($order_ids);
            else :
                $item_list = [];
            endif;

            return ['order_details' => $orderList, 'item_list' => $item_list];
        endif;
    }

    public function get_item_by_order_id($order_ids)
    {
        $this->db->select('ol.*,i.title as item_name, SUM(ol.sub_total) AS total_amount, SUM(ol.qty) AS total_item');
        $this->db->from('order_item_list ol');
        $this->db->join('items i', 'i.id=ol.item_id', 'LEFT');
        $this->db->where_in('ol.order_id', $order_ids);
        $this->db->group_by('ol.item_id');
        $this->db->order_by('total_amount', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    public function get_my_expenses($shop_id, $sql = '')
    {
        $today = today();
        $this->db->select('ex.*,ex.id as expense_id,ec.category_name,ec.id as category_id');
        $this->db->from('expense_list ex');
        $this->db->join('expense_category_list ec', 'ec.id=ex.category_id', 'LEFT');

        $get = $_GET;
        if (!empty($get['category'])) {
            $this->db->where("ex.category_id", $get['category']);
        }
        $this->db->where($sql);
        $this->db->where('ex.shop_id', $shop_id);
        $this->db->order_by('ex.created_at', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }
}
