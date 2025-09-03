<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Default_m extends CI_Model {
		public function __construct(){
			// parent::__construct();
			$this->db->query("SET sql_mode = ''");
		}

		public function add_payment($u_info=[],$package_info=[],$payment_type='',$ref_code='',$is_payment=0)
		{

			$tax = isset(__adminTax()->tax_percent)?__adminTax()->tax_percent:0;
			
			$ref_price = __invoice_total($package_info['price'],$tax,$ref_code,$discount=0);

			$final_price = isset($ref_price->total) && $ref_price->total !=0?$ref_price->total:$package_info['price'];

			$this->admin_m->update_by_user_id(['is_running'=>0],$u_info['user_id'],'payment_info');
			$random_number = random_string('alnum',16);

			$ref_info = $this->affliate($ref_code,$u_info['user_id'],$package_info['price'],$final_price,$package_info['id'],$is_payment);

			$data = array(
                'user_id' => $u_info['user_id'],
                'account_type' => $package_info['id'],
                'package_price' => $package_info['price'],
                'price' => $final_price,
                'txn_id' => $random_number,
                'payment_type' => !empty($payment_type)?$payment_type:0,
                'currency_code' => get_currency('currency_code'),
                'status' => $is_payment==0?'pending':'completed',
                'created_at' => d_time(),
                'expire_date' => add_year($package_info['package_type'],$package_info['duration'], $package_info['duration_period']),
                'is_running' => 1,
                'referal_code' => $ref_info['ref_code']??'',
                'ref_id' => $ref_info['ref_id']??0,
                'is_payment' => $is_payment,
            );
            $insert = $this->admin_m->insert($data,'payment_info');
	
            return $insert;
		}

		public function affliate($ref='',$subscriber_id='',$pacakge_price='',$final_price='',$package_id=0,$is_payment=0){
			if(__config('is_affiliate')==1):
				if(isset($ref) && !empty($ref)):
					$ref_code = $ref;
					$code = $this->affiliate_m->check_existing_referal_code($ref_code);
					if(!empty($code)):
						$commision_amount = __refer_price($pacakge_price,'refer')->amount;
						$codeData = [
							'uid' => uid(),
							'subscriber_id' => $subscriber_id,
							'refer_from_id' => $code->id,
							'commision_amount' => $commision_amount,
							'amount' => $final_price,
							'package_id' => $package_id,
							'package_price' => $pacakge_price,
							'ref_type' => 'registration',
							'referal_code' => $ref_code,
							'commision_rate' => __config('commision_rate'),
							'commision_type' => __config('commision_type'),
							'subscriber_commision_rate' => __config('subscriber_commision_rate'),
							'subscriber_commision_type' => __config('subscriber_commision_type'),
							'created_at' => d_time(),
							'status' => 1,
							'is_payment' => $is_payment,
							'is_request' =>0,
						];
						$ref_id = $this->admin_m->insert($codeData,'vendor_affiliate_list');
						return ['ref_code'=>$ref_code,'ref_id'=>$ref_id];
					else:
						return ['ref_code'=>$ref_code,'ref_id'=>0];
					endif;
				else:
					return ['ref_code'=>'','ref_id'=>0];
				endif;
			else:
				return ['ref_code'=>'','ref_id'=>0];
			endif;
		}

		public function single_select_by_id($id,$table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row_array();
		}

		public function single_select_by_row_id($id,$table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row();
		}

		public function update($data,$id,$table)
		{
			$this->db->where('id',$id);
			$this->db->update($table,$data);
			return $id;
		}



		public function delete($id,$table)
		{
			$this->db->delete($table,array('id'=>$id));
			return $id;
		}


		public function insert($data,$table)
		{
			$this->db->insert($table,$data);
			return $this->db->insert_id();
		}

		public function select($table)
		{
			$this->db->select();
			$this->db->from($table);
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

		public function select_row($table)
		{
			$this->db->select();
			$this->db->from($table);
			$query = $this->db->get();
			$query = $query->result();
			return $query;
		}

		public function select_desc($table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->order_by('id','DESC');
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

		public function update_by_type($data,$id,$type,$table)
		{
			$this->db->where($type,$id);
			$this->db->update($table,$data);
			return $id;
		}

		public function update_by_user_id($data,$user_id,$table)
		{
			$this->db->where('user_id',$user_id);
			$this->db->update($table,$data);
			return $user_id;
		}

		public function select_active_all($table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('status',1);
			$this->db->order_by('id','ASC');
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

		public function select_all_by_user_id($id,$table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('user_id',$id);
			$this->db->order_by('id','ASC');
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

		public function insert_all($data,$table) {
        // Insert order items
			$insert = $this->db->insert_batch($table, $data);

        // Return the status
			return $insert?true:false;
		}

		function delete_by_auth_id($id,$table)
		{
			$this->db->where('user_id',auth('id'));
			$this->db->delete($table,array('id'=>$id));
			return $id;
		}


		public function select_all_by_user($id,$table,$limit)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('user_id',$id);
			$this->db->where('status',1);
			$this->db->order_by('id','ASC');
			if($limit !=0){
				$this->db->limit($limit);
			}
			$query = $this->db->get();
			$query = $query->result_array();
			return $query;
		}

		function select_with_status($table)
		{
			$this->db->select();
			$this->db->from($table);
			$this->db->where('status',1);
			$this->db->order_by('id','ASC');
			$query = $this->db->get();
			$query = $query->result_array();  
			return $query;
		}


		public function get_settings()
		{
			$this->db->select();
			$this->db->from('settings');
			$query = $this->db->get();
			$query = $query->row_array();
			return $query;
		} 

		public function settings(){
	        $this->db->select();
	        $this->db->from('settings');
	        $query = $this->db->get();
	        return $query->row();
	    }

	    
	    public function get_user_info()
	    {
	    	$this->db->select('u.*');
	    	$this->db->from('users as u');
	    	$this->db->where('u.id',auth('id'));
	    	$query = $this->db->get();
	    	$query = $query->row_array();
	    	return $query;
	    }

	    public function get_all_users()
	    {
	    	$this->db->select('u.*,u.id as user_id');
	    	$this->db->select('sl.*,sl.id as sl_id');
	    	$this->db->select('pl.*,pl.id as package_id');
	    	$this->db->from('users as u');
	    	$this->db->join('subscription_list as sl','sl.user_id=u.id','left');
	    	$this->db->join('package_list as pl','pl.id=sl.package_id','left');
	    	$this->db->where('u.user_role','user');
	    	$query = $this->db->get();
	    	$query = $query->result_array();
	    	return $query;
	    }

	    public function user()
	    {
	    	$this->db->select('u.*,u.id as user_id');
	    	$this->db->select('sl.*,sl.id as sl_id');
	    	$this->db->select('pl.*,pl.id as package_id');
	    	$this->db->from('users as u');
	    	$this->db->join('subscription_list as sl','sl.user_id=u.id','left');
	    	$this->db->join('package_list as pl','pl.id=sl.package_id','left');
	    	$this->db->where('u.id',auth('id'));
	    	$this->db->where('u.user_role','user');
	    	$query = $this->db->get();
	    	$query = $query->row();
	    	return $query;
	    }

	    public function users()
	    {
	    	$this->db->select('u.*');
	    	$this->db->from('users as u');
	    	$this->db->where('u.id',auth('id'));
	    	$query = $this->db->get();
	    	$query = $query->row();
	    	return $query;
	    }

	    public function single_select($table)
	    {
	    	$this->db->select();
	    	$this->db->from($table);
	    	$query = $this->db->get();
	    	$query = $query->row_array();
	    	return $query;
	    }
	    public function single_select_row($table)
	    {
	    	$this->db->select();
	    	$this->db->from($table);
	    	$query = $this->db->get();
	    	$query = $query->row();
	    	return $query;
	    }

		public function get_user_info_by_id($id)
		{
			$this->db->select('u.*');
			$this->db->from('users u');
			$this->db->where('u.id',$id);
			$query = $this->db->get();
			$query = $query->row_array();
			return $query;
		}

		public function verify_password($password,$vpassword) {
			if (md5($password)== $vpassword) {
				return TRUE;
			} else {
				return FALSE;
			}
		}



		public function check_login_info($email,$password)
		{
			$this->db->select('u.*');
			$this->db->from('users u');
			$this->db->where("(u.email = '$email' OR u.username = '$email')");
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() ==1){
				$result = $query->result();
				foreach ($result as $row) {
					if ($this->verify_password($password, $row->password) == TRUE) {
						return $result;
					} else {
						return 0;
					}
				}
			}else{
				return 0;
			}

		}

	public function filter($ac ='ul',$type='all')
	{
		
		$today = today();
	    $last7 = make_day('7','days');
	    $llast7 = get_last_date('7','days',make_day('7','days'));
	    $yesterday = make_day('1','days');
	    $lastMonth = make_day('1','month');

	     $llastmonth = get_last_date('1','month',make_day('1','month'));

	     if($type=='today'):
	     	$start_date = $today;
	     	$end_date = $today;
	        $date = "{$today} - {$today}";

	     elseif($type=='last7'):
	     	$start_date = $last7;
	     	$end_date = $today;
	        $date = "{$last7} - {$today}";

	    elseif($type=='lastmonth'):
	    	$start_date = $lastMonth;
	     	$end_date = $today;
	        $date = "{$lastMonth} - {$today}";
	    elseif($type=='nlm'):
	    	$start_date = $llastmonth;
	     	$end_date = $lastMonth;
	        $date = "{$llastmonth} - {$lastMonth}";

	    elseif($type=='nl7'):
	    	$start_date = $llast7;
	     	$end_date = $last7;
	        $date = "{$llast7} - {$last7}";
	    elseif($type=='nt'):
	    	$start_date = $yesterday;
	     	$end_date = $yesterday;
	        $date = "{$yesterday} - {$yesterday}";

	    elseif($type=='yesterday'):
	    	$start_date = $yesterday;
	     	$end_date = $today;
	    else:
	    	$start_date = '';
	     	$end_date = '';

	        $date = '';
	        $sql = '';
	    endif;

	    if((isset($start_date) && !empty($start_date)) && (isset($end_date) && isset($end_date))){
	    	return $sql = "(DATE_FORMAT({$ac}.completed_time,'%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}') OR DATE_FORMAT({$ac}.created_at,'%Y-%m-%d') BETWEEN '{$start_date}' AND '{$end_date}'";
	    }else{
	    	return $sql = '';
	    }
		
	}
			

}