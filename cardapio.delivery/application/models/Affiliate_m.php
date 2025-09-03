<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Affiliate_m extends CI_Model
{
    protected $site_lang;
    protected $language;
    public function __construct()
    {
        $this->db->query("SET sql_mode = ''");
        $this->site_lang = site_lang();
        $this->language = 'english';
    }

    public function get_affiliate_transaction($shop_id)
    {
        $this->db->select('vf.*');
        $this->db->from('vendor_affiliate_list vf');
        $this->db->where('vf.refer_from_id', $shop_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_affiliate_transaction()
    {
        $this->db->select('vf.*,r.username,r.name,u.username as subscriber_username, u.name as subscriber_name');
        $this->db->from('vendor_affiliate_list vf');
        $this->db->join('restaurant_list r', 'r.id=vf.refer_from_id', 'INNER');
        $this->db->join('users u', 'u.id=vf.subscriber_id', 'INNER');
        $this->db->order_by('vf.created_at', "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function check_existing_referal_code($code)
    {
        $this->db->select();
        $this->db->from('restaurant_list r');
        $this->db->where('r.referal_code', $code);
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            $data = $query->row();
        else:
            $data = '';
        endif;
        return $data;
    }

    public function get_my_referal_list($shop_id = 0)
    {
        $shop_id = $shop_id != 0 ? $shop_id : $_ENV['ID'];
        $this->db->select('va.*,u.username,u.name');
        $this->db->from('vendor_affiliate_list va');
        $this->db->join('users u', 'u.id=va.subscriber_id', "INNER");
        $this->db->where('va.refer_from_id', $shop_id);
        $this->db->where('va.is_payment', 1);
        $this->db->order_by('va.created_at', "DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0):
            $data = $query->result();
        else:
            $data = [];
        endif;
        return $data;
    }

    public function get_affiliate_info_by_code($ref_code, $subscriber_id)
    {
        $this->db->select('vf.*');
        $this->db->from('vendor_affiliate_list vf');
        $this->db->where('vf.referal_code', $ref_code);
        $this->db->where('vf.subscriber_id', $subscriber_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_affiliate_info_by_id($ref_id, $subscriber_id)
    {
        $this->db->select('vf.*');
        $this->db->from('vendor_affiliate_list vf');
        $this->db->where('vf.referal_code', $ref_id);
        $this->db->where('vf.subscriber_id', $subscriber_id);
        $this->db->order_by('vf.created_at', "DESC");
        $query = $this->db->get();
        return $query->row();
    }

    public function check_existing_payment_by_subscriber($subscriber_id, $pacakge_id, $txn_id)
    {
        $this->db->select('vf.*');
        $this->db->from('payment_info vf');
        $this->db->where('vf.account_type', $pacakge_id);
        $this->db->where('vf.user_id', $subscriber_id);
        $this->db->where('vf.txn_id', $txn_id);
        $this->db->order_by('vf.created_at', "DESC");
        $query = $this->db->get();
        return $query->row();
    }

    public function get_affiliate_income($shop_id = '', $type = 'month')
    {
        $thisMonth = year_month(d_time());
        $this->db->select('SUM(vf.commision_amount) as balance, 
        SUM(vf.package_price) as total_package_price, COUNT(vf.id) as total_referal');

        $this->db->from('vendor_affiliate_list vf');
        if ($type == 'month'):
            $this->db->where('SUBSTRING(vf.created_at,1,7)', $thisMonth);
        endif;

        if (!empty($shop_id)) {
            $this->db->where('vf.refer_from_id', $shop_id);
        }

        $this->db->where('is_payment', 1);
        if ($type == 'month'):
            $this->db->where('is_request', 0);
        endif;

        $this->db->order_by('vf.created_at', "DESC");
        $query = $this->db->get();
        return !empty($query->row()) ? $query->row() : '';
    }

    public function get_affiliate_by_month($shop_id)
    {
        $query = $this->db->query("
            SELECT
            DATE_FORMAT(created_at,'%Y-%m') as monthYear,
            SUM(commision_amount) as balance, 
            SUM(package_price) as total_package_price,
            COUNT(id) as total_referal,
            created_at,refer_from_id
            FROM vendor_affiliate_list  WHERE is_payment = 1 AND refer_from_id = {$shop_id}
            GROUP BY monthYear
            ORDER BY monthYear DESC
        ");

        $query = $query->result();

        foreach ($query as $key => $result) {
            $ym = $result->year . '-' . $result->month;
            $this->db->select('vf.*');
            $this->db->from('vendor_affiliate_list vf');
            $this->db->where("DATE_FORMAT(vf.created_at,'%Y-%m')", $ym);
            $this->db->where('vf.refer_from_id', $result->refer_from_id);
            $this->db->where('vf.is_payment', 1);
            $query2 = $this->db->get();
            $query2 = $query2->result();
            $query[$key]->details = $query2;
        }
        return $query;
    }

    public function get_affiliate_by_vendor($shop_id)
    {
        $query = $this->db->query("
            SELECT
            DATE_FORMAT(created_at,'%Y-%m') as monthYear,
            SUM(commision_amount) as balance, 
            SUM(package_price) as total_package_price,
            COUNT(id) as total_referal,
            created_at,refer_from_id,id
            FROM vendor_affiliate_list  WHERE is_payment = 1 AND refer_from_id = {$shop_id} AND is_request = 0
            GROUP BY monthYear
            ORDER BY monthYear DESC
        ");

        $query = $query->result();
        $sum = $count = 0;
        foreach ($query as $key => $result) {
            $sum = +$result->balance;
            $count = +$result->total_referal;
            $query[$key]->grand_balance = $sum;
            $query[$key]->grand_referal = $count;
        }

        foreach ($query as $key => $result) {
            $this->db->select('vf.*');
            $this->db->from('vendor_affiliate_list vf');
            $this->db->where("DATE_FORMAT(vf.created_at,'%Y-%m')", $result->monthYear);
            $this->db->where('vf.refer_from_id', $result->refer_from_id);
            $this->db->where('vf.is_payment', 1);
            $query2 = $this->db->get();
            $query2 = $query2->result();
            $query[$key]->details = $query2;
        }
        return $query;
    }




    public function get_payout_request_by_date_ids($shop_id, $monthYear)
    {
        $monthYear  = "'" . implode("','", $monthYear) . "'";

        $query = $this->db->query("
            SELECT
            DATE_FORMAT(created_at,'%Y-%m') as monthYear,
            SUM(commision_amount) as balance, 
            SUM(package_price) as total_package_price,
            COUNT(id) as total_referal,
            created_at,refer_from_id
            FROM 
                vendor_affiliate_list 
            WHERE 
                refer_from_id = {$shop_id}
                AND is_request = 0
                AND  DATE_FORMAT(created_at, '%Y-%m') IN ($monthYear)
            GROUP BY 
                monthYear

        ");

        $query = $query->result();
        foreach ($query as $key => $result) {
            $this->db->select('vf.id,created_at,refer_from_id');
            $this->db->from('vendor_affiliate_list vf');
            $this->db->where("DATE_FORMAT(vf.created_at,'%Y-%m')", $result->monthYear);
            $this->db->where('vf.refer_from_id', $result->refer_from_id);
            $this->db->where('vf.is_payment', 1);
            $query2 = $this->db->get();
            $query2 = $query2->result();
            $ids = [];
            foreach ($query2 as $key2 => $result2) {
                $ids[] = $result2->id;
            }
            $query[$key]->ids = json_encode($ids);
        }
        return $query;
    }

    public function get_payout_request($shop_id = 0, $is_encrypt = false)
    {
        $this->db->select('a.*');
        $this->db->select('r.username,r.name as vendor_name');
        $this->db->from('affiliate_payout_list a');
        if ($shop_id != 0) {
            if ($is_encrypt == true) {
                $this->db->where('md5(a.request_id)', $shop_id);
            } else {
                $this->db->where('a.request_id', $shop_id);
            }
            $this->db->order_by('a.request_date,complete_date', "DESC");
        } else {
            $this->db->order_by('a.request_date', "DESC");
        }

        $this->db->join("restaurant_list r", "r.id=a.request_id", "left");

        $query = $this->db->get();
        return $query->result();
    }


    public function get_payout_by_id_month($shop_id, $monthYear, $status)
    {
        $this->db->select('a.*');
        $this->db->from('affiliate_payout_list a');
        $this->db->where('md5(a.request_id)', $shop_id);
        $this->db->where('a.payout_month', $monthYear);

        //status 1 for approved the request. status 0 for holding the status
        if ($status == 1) {
            $this->db->where('a.is_payment', 0);
        }

        $query = $this->db->get();
        return $query->row();
    }


    public function get_payout_request_list()
    {
        $query = $this->db->query("
            SELECT
                val.*,
                SUM(val.balance) as total_balance, 
                SUM(val.total_referel) as total_referels,
                res.id as vendor_id,
                res.username,
                res.name,
                res.thumb
            FROM 
                affiliate_payout_list val
            JOIN
                restaurant_list res ON val.request_id = res.id
            WHERE 
                val.is_payment = 0
            GROUP BY 
                val.request_id
            ORDER BY 
                val.request_date DESC;
        ");

        $query = $query->result();
        return $query;
    }

    public function get_payout_details($shop_id, $monthYear)
    {
        $this->db->select('a.*');
        $this->db->select('r.username,r.name as vendor_name,r.thumb,u.name as subscriber_name,u.username as subscriber_username');
        $this->db->from('vendor_affiliate_list a');
        $this->db->join("restaurant_list r", "r.id=a.refer_from_id", "left");
        $this->db->join("users u", "u.id=a.subscriber_id", "left");
        $this->db->where('a.is_payment', 1);
        $this->db->where('md5(a.refer_from_id)', $shop_id);
        $this->db->where("DATE_FORMAT(a.created_at,'%Y-%m')", $monthYear);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    public function complete_payout_list()
    {
        $this->db->select('a.*');
        $this->db->select('r.username,r.name as vendor_name');
        $this->db->from('affiliate_payout_list a');
        $this->db->join("restaurant_list r", "r.id=a.request_id", "left");
        $this->db->where('a.is_payment', 1);
        $this->db->where('a.status', 1);
        $this->db->order_by('complete_date', "DESC");
        $query = $this->db->get();
        return $query->result();
    }
}
