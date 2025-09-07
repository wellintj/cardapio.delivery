<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Updated_queries extends CI_Model
{
	private $custom_db = null;
	private $custom_dbforge = null;
	public function __construct()
	{
		// parent::__construct();
		$this->db->query("SET sql_mode = ''");
		$this->load->dbforge();
	}

	public function set_custom_db($config)
	{
		try {
			// Load the custom database
			$this->custom_db = $this->load->database($config, TRUE);

			// Load dbforge for the custom database connection
			$this->load->dbforge($this->custom_db);
			$this->custom_dbforge = $this->dbforge;

			return ['st' => 1, 'msg' => 'Database connected successfully'];
		} catch (Exception $e) {
			return ['st' => 0, 'msg' => 'Database connection failed: ' . $e->getMessage()];
		}
	}


	public function install_version($version, $current_version = null, $is_custom = false)
	{
		// Switch database connection if custom
		if ($is_custom && $this->custom_db) {
			$original_db = $this->db;
			$original_dbforge = $this->dbforge;
			$this->db = $this->custom_db;
			$this->dbforge = $this->custom_dbforge;
		}

		$data = [];

		$settings = $is_custom ? [] : settings();
		$language = isset($settings['language']) ? $settings['language'] : 'english';
		$current_version = $is_custom ? $current_version : NEW_VERSION;

		do {


			if ($version > 1.2 && $version < 2.4) {
				$new_version = 2.4;
				$data = ['st' => 3, "msg" => 'You have to update it from using YOUR_URL/update', 'version' => $new_version];
				break;
			}


			if (!function_exists('check_versions')) {
				include APPPATH . "config/update_logs.php";
			}


			$update_result = check_versions($version, $this);
			if ($update_result) {
				$data = $update_result;
				break;
			}



			if ($version < '3.2.7') {
				$new_version = '3.2.7';



				$addColumnQueries = [

					'site_services' => [
						'language' => "VARCHAR(50) NOT NULL DEFAULT '$language'",
					],

					'item_extras' => [
						'status' => "TINYINT NOT NULL DEFAULT 1",
					],



				];


				$addColumn = $this->sql_command($addColumnQueries);



				if (!$this->db->table_exists('restaurant_offline_payemnt_list')) :
					$this->db->query(
						'CREATE TABLE `restaurant_offline_payemnt_list` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` VARCHAR(200) NOT NULL,
					`user_id` INT(11) NOT NULL,
					`shop_id` INT(11) NOT NULL,
					`status` int(2) NOT NULL DEFAULT 1,
					PRIMARY KEY (`id`)) 
					ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
					);
				endif;


				if (!$this->db->table_exists('order_counters')) :
					$this->db->query(
						'CREATE TABLE `order_counters` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`restaurant_id` INT(11) NOT NULL,
						`order_number` VARCHAR(50) NOT NULL,
						`created_at` DATETIME NOT NULL,
						PRIMARY KEY (`id`)) 
						ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
					);
				endif;



				$this->drop_foreign_keys();






				$keywords = ['seperate_tax', 'previous_total', 'current_total'];
				$check_keywords = $this->check_keywords($keywords);
				if ($check_keywords == 0) :
					$this->db->query("INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) VALUES
						('seperate_tax','admin','Percentage separately','Percentage separately'),
						('sorry_invalid_user','admin','Sorry, invalid user','Sorry, invalid user'),
						('your_account_is_not_active_due_to_payment_issue','admin','Your account is not active due to payment issue','Your account is not active due to payment issue'),
						('your_account_is_expired','admin','Your account already Expired','Your account already Expired'),
						('your_account_is_not_verified','admin','Your Account is not verified','Your Account is not verified'),
						('your_account_is_not_active','admin','Your Account is not active','Your Account is not active'),
						('merged_total','admin','Merged total','Merged total'),
						('previous_total','admin','Previous total','Previous total'),
						('current_total','admin','Current Total','Current Total');
						");

				endif;


				if (isset($addColumn['st']) && $addColumn['st'] == 0) :
					$data = ["st" => 0, "msg" => $addColumn['msg'], 'version' => $new_version];
				else :

					$data = ['st' => 1, "msg" => 'Updated Successfully', 'version' => $new_version];
				endif;
			}


			if ($version < '3.2.8') {
				$new_version = '3.2.8';



				$addColumnQueries = [

					'customer_list' => [
						'otp' => "VARCHAR(50) NULL",
						'last_attempt_at' => "VARCHAR(90) NULL",
						'otp_expire_time' => "VARCHAR(90) NULL",
						'attempts' => "INT(11) DEFAULT 0",
					],

					'item_extras' => [
						'status' => "TINYINT NOT NULL DEFAULT 1",
					],

					'vendor_slider_list' => [
						'external_url' => "VARCHAR(255) NULL",
					],



				];


				$addColumn = $this->sql_command($addColumnQueries);



				if (!$this->db->table_exists('restaurant_offline_payemnt_list')) :
					$this->db->query(
						'CREATE TABLE `restaurant_offline_payemnt_list` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` VARCHAR(200) NOT NULL,
							`user_id` INT(11) NOT NULL,
							`shop_id` INT(11) NOT NULL,
							`status` int(2) NOT NULL DEFAULT 1,
							PRIMARY KEY (`id`)) 
							ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
					);
				endif;


				if (!$this->db->table_exists('order_counters')) :
					$this->db->query(
						'CREATE TABLE `order_counters` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`restaurant_id` INT(11) NOT NULL,
						`order_number` VARCHAR(50) NOT NULL,
						`created_at` DATETIME NOT NULL,
						PRIMARY KEY (`id`)) 
						ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
					);
				endif;



				$this->drop_foreign_keys();



				$keywords = ['maximum_otp_requests_exceeded', 'use_email_insist_of_phone', 'login_with_otp'];
				$check_keywords = $this->check_keywords($keywords);
				if ($check_keywords == 0) :
					$this->db->query("INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) VALUES
						('session_expired_request_a_new_otp','admin','Session expired. Please request a new OTP.','Session expired. Please request a new OTP.'),
							('maximum_otp_requests_exceeded','admin','Maximum OTP requests for today reached. Please try again tomorrow.','Maximum OTP requests for today reached. Please try again tomorrow.'),
							('use_email_insist_of_phone','admin','Use Email insist of phone','Use Email instead of phone'),
							('login_with_otp','admin','Login with OTP','Login with OTP'),
							('verify_otp','admin','Verify OTP','Verify OTP'),
							('sms_otp','admin','SMS OTP','SMS OTP'),
							('email_otp','admin','Email OTP','Email OTP'),
							('system_based','admin','System based','System based'),
							('checkout_login','admin','Checkout login','Checkout login');
						");

				endif;


				if (isset($addColumn['st']) && $addColumn['st'] == 0) :
					$data = ["st" => 0, "msg" => $addColumn['msg'], 'version' => $new_version];
				else :

					$data = ['st' => 1, "msg" => 'Updated Successfully', 'version' => $new_version];
				endif;
			}
			/*----------------------------------------------
		  				VERSION END 
		  				----------------------------------------------*/
		} while ($version == $current_version);

		// Restore original database connection if using custom
		if ($is_custom && $this->custom_db) {
			$this->db = $original_db;
			$this->dbforge = $original_dbforge;
		}


		return $data;
	} //install_version


	/*----------------------------------------------
	  		ADD Fields SQL Comments
	  		----------------------------------------------*/
	public function sql_command($addColumnQueries = [])
	{
		if (!empty($addColumnQueries)) :
			try {
				foreach ($addColumnQueries as $tableName => $queryValue) {
					foreach ($queryValue as $fieldName => $attribute) {
						if ($this->checkExistFields($tableName, $fieldName) == 0) {
							$this->dbforge->add_column($tableName, $fieldName . ' ' . $attribute);;
						}
					}
				}
			} catch (Exception $e) {
				return ['st' => 0, 'msg' => $e->getMessage()];
			}


		endif;
	}

	public function drop_foreign_keys()
	{
		// Check if first foreign key exists
		$check1 = $this->db->query("
        SELECT COUNT(1) as count
        FROM information_schema.TABLE_CONSTRAINTS 
        WHERE CONSTRAINT_SCHEMA = DATABASE()
        AND TABLE_NAME = 'staff_order_activity_logs'
        AND CONSTRAINT_NAME = 'staff_order_activity_logs_ibfk_1'
    ")->row();

		if ($check1->count > 0) {
			$this->db->query("
            ALTER TABLE staff_order_activity_logs 
            DROP FOREIGN KEY staff_order_activity_logs_ibfk_1
        ");
		}

		// Check if second foreign key exists
		$check2 = $this->db->query("
        SELECT COUNT(1) as count
        FROM information_schema.TABLE_CONSTRAINTS 
        WHERE CONSTRAINT_SCHEMA = DATABASE()
        AND TABLE_NAME = 'staff_order_activity_logs'
        AND CONSTRAINT_NAME = 'staff_order_activity_logs_ibfk_2'
    ")->row();

		if ($check2->count > 0) {
			$this->db->query("
            ALTER TABLE staff_order_activity_logs 
            DROP FOREIGN KEY staff_order_activity_logs_ibfk_2
        ");
		}
	}

	public function add_user_permissions()
	{
		$permissionList = [
			'kds' => [
				'title' => 'KDS',
				'slug' => 'kds',
				'role' => 'user',
			],

			'reports' => [
				'title' => 'Reports',
				'slug' => 'reports',
				'role' => 'user',
			],

			'menu' => [
				'title' => 'Menu',
				'slug' => 'menu',
				'role' => 'user',
			],

			'affiliate' => [
				'title' => 'Affiliate',
				'slug' => 'affiliate',
				'role' => 'user',
			],


			'coupon' => [
				'title' => 'Coupon List',
				'slug' => 'coupon',
				'role' => 'user',
			],

			'customer' => [
				'title' => 'Customer List',
				'slug' => 'customer',
				'role' => 'user',
			],

			'pages' => [
				'title' => 'Page List',
				'slug' => 'pages',
				'role' => 'user',
			],
		];

		foreach ($permissionList as $key => $value) :
			$check_slug = $this->check_slug($key, 'permission_list');
			if ($check_slug == 0) :
				$data = [
					'title' => $value['title'],
					'slug' => $key,
					'status' => 1,
					'role' => $value['role'],
				];
				$this->db->insert('permission_list', $data);
			endif;
		endforeach;
	}


	public function indexNumbers()
	{

		$data = [
			'order_user_list' => ['uid', 'order_type', 'shop_id'],

			'users' => [
				"username",
				"account_type",
			],

			'order_item_list' => [
				"order_id",
				"shop_id",
				"item_id"
			],

			'staff_list' => [
				"uid",
				"shop_id"
			]
		];

		$this->makeIndex($data);
	}

	protected function makeIndex($data)
	{

		foreach ($data as  $tableName => $tableNameValue) :
			foreach ($tableNameValue as  $key => $columnName) :
				if ($this->db->field_exists($columnName, $tableName)) {
					if ($this->checkIndex($tableName, $columnName) == 0) {
						$this->db->query("CREATE INDEX {$columnName} 
	  								ON {$tableName} ({$columnName})");
					}
				}
			endforeach;
		endforeach;
	}


	protected function checkIndex($tableName, $columnName)
	{
		// Check if the desired index is present
		$query = $this->db->query("SHOW INDEX FROM $tableName WHERE Column_name = '$columnName'");
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	public function  checkExistFields($table, $fields)
	{
		if ($this->db->field_exists($fields, $table)) {
			return 1;
		} else {
			return 0;
		}
	}


	public function check_keywords($keywords)
	{
		$this->db->select();
		$this->db->from('language_data');
		$this->db->or_where_in('keyword', $keywords);
		$query = $this->db->get();
		if ($query->num_rows() > 1) {
			return 1;
		} else {
			return 0;
		}
	}

	function activeFeatures()
	{
		$data = ['is_header' => 0];
		$ids = ['5', '6', '7', '10', '11', '12', '13'];
		$this->admin_m->in_update($data, $ids, 'features');
	}

	public function check_slug($slug, $table)
	{
		$this->db->select();
		$this->db->from($table);
		$this->db->where('slug', $slug);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	public function check_id($id, $table)
	{
		$this->db->select();
		$this->db->from($table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	public function add_permissions($type = null)
	{
		if ($type == 'qpos') :
			$check_slug = $this->check_slug('pos-order', 'permission_list');
			if ($check_slug == 0) :
				$this->db->query("INSERT INTO permission_list(id,title,slug,status) VALUES 
	  						('9','POS Order','pos-order','1')");
			endif;

			$check_slug = $this->check_slug('pos-settings', 'permission_list');
			if ($check_slug == 0) :
				$this->db->query("INSERT INTO permission_list(id,title,slug,status) VALUES 
	  						('10','POS Settings','pos-settings','1')");
			endif;
		endif;
	}

	public function add_features($type = null)
	{
		if ($type == 'qpos') :
			$check_slug = $this->check_slug('pos', 'features');
			if ($check_slug == 0) :
				$this->db->query("INSERT INTO features(id,features,slug,status,is_features,created_at) VALUES 
	  						('12','POS','pos','1','1','2022-11-25 23:04:31')");
			endif;
		endif;

		if ($type == 'affiliate') :
			$check_slug = $this->check_slug('affiliate', 'features');
			if ($check_slug == 0) :
				$this->db->query("INSERT INTO features(id,features,slug,status,is_features,created_at) VALUES 
	  						('13','Affiliate','affiliate','1','1','2024-01-05 23:04:31')");
			endif;
		endif;

		if ($type == 'dboy') :
			$check_slug = $this->check_slug('dboy', 'features');
			if ($check_slug == 0) :
				$this->db->query("INSERT INTO features(id,features,slug,status,is_features,created_at) VALUES 
	  						('14','Delivery Staff','dboy','1','1','2024-08-20 23:04:31')");
			endif;
		endif;
	}




	public function transfer_pacakge()
	{
		$this->load->model('custom_m');
		$this->custom_m->transfer_data('item_packages', 'item_packages_list', 'package_id');
		return true;
	}



	public function change_price()
	{
		$payment_info = $this->admin_m->select('payment_info');
		foreach ($payment_info as $key => $value) {
			@$this->admin_m->update(['package_price' => $value['price']], $value['id'], 'payment_info');
		}

		return true;
	}


	public function get_customers()
	{
		$customer_list = $this->admin_m->get_customers();
		$data = [];
		if (sizeof($customer_list) > 1) :
			foreach ($customer_list as $key => $row) :
				$data[] = [
					'old_id' => $row->id,
					'user_id' => $row->user_id,
					'customer_name' => $row->name,
					'phone' => $row->phone,
					'email' => $row->email,
					'password' => $row->password,
					'country_id' => $row->country_id,
					'thumb' => $row->thumb,
					'images' => $row->images,
					'address' => $row->address,
					'gmap_link' => $row->gmap_link,
					'question' => $row->question,
					'is_pos' => 0,
				];
			endforeach;

			$insert = $this->admin_m->insert_all($data, 'customer_list');
		else :
			$insert = 1;
		endif;

		if ($insert) {
			$new_customer_list = $this->admin_m->get_new_customers();  // new customers

			foreach ($new_customer_list as $key => $row) :
				$new_customer_data = 	$this->admin_m->get_order_by_customer_id($row->old_id);  // order list by old customer id


				foreach ($new_customer_data as $key => $c) :
					if (!empty($c)) {
						$is_order_update = $this->admin_m->update(['customer_id' => $row->id], $c->id, 'order_user_list'); //update cusotmer id in order table	

					}

				endforeach;


				$update_customer = 	$this->admin_m->update(['is_update' => 1], $row->id, 'customer_list');  // update new custoemr table after


				if ($update_customer) {
					$del_id = 	$this->admin_m->delete($row->old_id, 'staff_list');
				}

			endforeach;
		}
	}

	public function get_staff_from_order()
	{
		$order_details = $this->common_m->get_orders_for_staff_details();
		if (!empty($order_details)) :
			foreach ($order_details as $key => $row) {
				$data[] = [
					'order_id' => $row->id,
					'staff_id' => $row->staff_id,
					'shop_id' => $row->shop_id,
					'staff_role' => 'staff',
					'action_type' => $row->staff_action == 0 ? 'accept' : $row->staff_action,
					'created_at' => $row->created_at,
				];
			}
			$check = $this->default_m->select('staff_order_activity_logs');
			if (empty($check)) {
				$this->default_m->insert_all($data, 'staff_order_activity_logs');
			}
		endif;
	}


	public function addMaxQty()
	{
		$addColumnQueries = [
			'extra_title_list' => [
				'max_qty' => "INT(11) NOT NULL DEFAULT 0",
			],


			'settings' => [
				'tax_system' => "VARCHAR(20) NOT NULL DEFAULT 'percentage'",
			],

		];


		$keywords = ['max_qty', 'tax_system'];
		$check_keywords = $this->check_keywords($keywords);
		if ($check_keywords == 0) :
			$this->db->query("INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) VALUES
				('including_tax','admin','Tax including Formula (EU)','Tax including Formula (EU)'),
				('tax_system','admin','Tax System','Tax System'),
				('default','admin','default','Default'),
				('max_qty','admin','Maximum quantity selecting limit','Maximum quantity selecting limit');");

		endif;


		$this->sql_command($addColumnQueries);
	}

	public function close_custom_db()
	{
		if ($this->custom_db) {
			$this->custom_db->close();
			$this->custom_db = null;
		}
	}
}
