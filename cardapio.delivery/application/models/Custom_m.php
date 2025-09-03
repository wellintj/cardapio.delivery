<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_m extends CI_Model
{
	public function __construct()
	{
		// parent::__construct();
		$this->db->query("SET sql_mode = ''");
	}

	public function insert_features($user_id)
	{
		$fetaures = $this->default_m->select('feature_list');
		$check_feature = $this->default_m->select_all_by_user_id($user_id, 'subscribe_features');

		if (count($check_feature) == 0) {
			foreach ($fetaures as $key => $row) {
				$data =  array(
					'feature_id' => $row['id'],
					'user_id' => $user_id,
					'status' => 1,
					'created_at' => d_time(),
				);
				$this->default_m->insert($data, 'subscribe_features');
			}
		} elseif (count($check_feature) == count($fetaures)) {
			return true;
		} elseif (count($check_feature) < count($fetaures)) {

			foreach ($fetaures as $key => $row) {
				$feature_id = $this->admin_m->get_users_active_features($row['id'], $user_id);

				if ($feature_id['feature_id'] != $row['id']) {
					$data =  array(
						'feature_id' => $row['id'],
						'user_id' => $user_id,
						'status' => 1,
						'created_at' => d_time(),
					);
					$this->default_m->insert($data, 'subscribe_features');
				}
			}
		}

		return true;
	}

	public function transfer_data($old_table, $new_table, $type)
	{

		$new_table_data = $this->admin_m->select($new_table);
		if (sizeof($new_table_data) == 0 || empty($new_table_data)) :
			$old_table_data = $this->admin_m->select($old_table);
			$language_list = $this->admin_m->select('languages');
			if (isset($old_table_data) && sizeof($old_table_data) > 0) :
				foreach ($old_table_data as $key => $data1) {
					$data[] = [
						'id' => $data1['id'],
						'shop_id' => $data1['shop_id'],
						'user_id' => $data1['user_id'],
						'language' => st()->language,
						'created_at' => $data1['created_at'],
						'is_special' => $data1['is_special'],
					];
					$updateData = [
						'uid' => uid(),
						$type => $data1['id'],
						'language' => st()->language,
					];
					$this->admin_m->update($updateData, $data1['id'], $old_table);
				}
				$this->admin_m->insert_all($data, $new_table);
			endif;
		endif;

		return true;
	}

	public function get_data($data, $lang)
	{
		$dt =  array_merge($lang, $data);
		return $dt;
	}

	public function getMailTepmlate()
	{

		$tempData = '{
					"recovery_mail": {
						"subject": "Recovery Mail",
						"message": "<p>A Recovery mail from {SITE_NAME},<p>Hello {USERNAME}, Use this <b>{PASSWORD} password to login.<p>Please don\'t share this password anyone.<p>Thank you!<p><br><p>"
					},
					"contact_mail": {
						"subject": "Contact Mail",
						"message": "<p>Contact Mail form {NAME} on {SITE_NAME},<p>Name: {NAME}<p>Email: {EMAIL}<p>Message: {MESSAGE}"
					},
					"resend_verify_mail": {
						"subject": "Resend Verification Mail",
						"message": "<p>Account Verification Mail from {SITE_NAME},<p>Hello {USERNAME}<p>Click\u00a0 verify link to verify your account {LINK}<p><br>"
					},
					"email_verification_mail": {
						"subject": "Account Verification Mail",
						"message": "<p>Account Verification Mail From {SITE_NAME},<p>Congratulations {USERNAME},<p>Name: {USERNAME}<p>Email: {EMAIL}<p>Package: {PACKAGE_NAME}<p>Password: {PASSWORD}<p>Click \/ Copy the verification link {VERIFY_LINK}<p>Thank you!"
					},
					"account_create_invoice": {
						"subject": "Registration Invoice",
						"message": "<p>Subscription Invoice From {SITE_NAME},<p><br><table class=\"table table-bordered\"><tr><td>#<td>Description<br><td>Package name<br><td>Qty<br><td>Price<br><td>Total<br><tr><td>1<td><p>Thank you {Username}<p>for registration on {SITE_NAME}<p>Please pay to continue your account live<br><td><p>{PACKAGE_NAME}<br><td>1<td>{PRICE}<td>{PRICE} USD<br><tr><td><br><td><br><td><br><td><br><td><br><td>{PRICE} \/=<p><br>"
					},
					"new_user_mail": {
						"subject": "New subscriber mail",
						"message": "<p>New Subscriber on {SITE_NAME}.<br>A New subscriber found\u00a0<p>Username: {USERNAME},<p>Email: {EMAIL}<p>Package Name: {PACKAGE_NAME}<p><br><p>Thank you!"
					},
					"offline_payment_request_mail": {
						"subject": "Offline Payment Request",
						"message": "<p>Payment Request on {SITE_NAME}<p><em><b>An Offline payment request from <b> {USERNAME}<p>Name: {USERNAME}\u00a0 \u00a0 \u00a0 Email:\u00a0 \u00a0{EMAIL}\u00a0 \u00a0 Package Name: {PACKAGE_NAME}<p>Price {PRICE} USD\u00a0 \u00a0Txn ID:\u00a0 {TXNID}<p><br><p>Thank you!<p><br>"
					},
					"send_payment_verified_email": {
						"subject": "Payment Invoice",
						"message": "<p>Payment Invoice {SITE_NAME},<p>Name: {USERNAME}\u00a0<p>Email: {EMAIL}\u00a0 <p>Payment method: {PAYMENT_METHOD}<p>Payment Date: {PAYMENT_DATE}\u00a0 <p>Txn ID: {TXNID}<p><br><table class=\"table table-bordered\" style=\"width: 468.656px;\"><tr><td style=\"line-height: 1.42857;\">#<td style=\"line-height: 1.42857;\">Description<br><td style=\"line-height: 1.42857;\">Package name<br><td style=\"line-height: 1.42857;\">Qty<br><td style=\"line-height: 1.42857;\">Price<br><td style=\"line-height: 1.42857;\">Total<br><tr><td style=\"line-height: 1.42857;\">1<td style=\"line-height: 1.42857;\"><p>Your payment has been completed successfully.<p>Your account will be expired on {EXPIRE_DATE}<td style=\"line-height: 1.42857;\"><p>{PACKAGE_NAME}<br><td style=\"line-height: 1.42857;\">1<td style=\"line-height: 1.42857;\">{PRICE}<td style=\"line-height: 1.42857;\">{PRICE} USD<br><tr><td style=\"line-height: 1.42857;\"><br><td style=\"line-height: 1.42857;\"><br><td style=\"line-height: 1.42857;\"><br><td style=\"line-height: 1.42857;\"><br><td style=\"line-height: 1.42857;\"><br><td style=\"line-height: 1.42857;\">{PRICE} \/=<p><br>"
					},
					"expire_reminder_mail": {
						"subject": "Account Expire reminder mail",
						"message": "<p>An\u00a0Account Expire reminder from\u00a0 {SITE_NAME},<p>Name: {USERNAME}\u00a0 \u00a0 \u00a0Email: {EMAIL}<p>Expire date: {EXPIRE_DATE}\u00a0 Day left: {REMAINING_DAYS}"
					},
					"account_expire_mail": {
						"subject": "Account Expired Mail",
						"message": "<p>An Account Expire reminder from {SITE_NAME},<p>Hello {USERNAME},<p>Your account already expired on {EXPIRE_DATE}<p>Email: {EMAIL}"
					}
				}';
		return  $tempData;
	}




	public function add_default_data($shop_id, $user_id)
	{
		$this->removeId($shop_id, $user_id);
	}


	public function removeId($shop_id, $user_id)
	{
		// First, insert data into the item_category_list table
		$categoryData = array(
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'status' => '1', 'is_default' => '1'),
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'status' => '1', 'is_default' => '1')
		);

		$categoryIds =  $this->admin_m->insert_batch_data($categoryData, 'item_category_list');


		// Prepare data for menu_type table using the retrieved category IDs
		$menuTypeData = array(
			array('shop_id' => $shop_id, 'user_id' => $user_id, 'type' => 'others', 'name' => 'Pizza', 'details' => '', 'orders' => '1', 'status' => '1', 'created_at' => d_time(), 'thumb' => null, 'images' => null, 'language' => !empty(site_lang()) ? site_lang() : 'english', 'category_id' => $categoryIds[0], 'is_pos_only' => '0', 'is_default' => '1'),
			array('shop_id' => $shop_id, 'user_id' => $user_id, 'type' => 'others', 'name' => 'Burger', 'details' => '', 'orders' => '2', 'status' => '1', 'created_at' => d_time(), 'thumb' => null, 'images' => null, 'language' => !empty(site_lang()) ? site_lang() : 'english', 'category_id' => $categoryIds[1], 'is_pos_only' => '0', 'is_default' => '1')
		);

		$menuTypeIds = $this->admin_m->insert_batch_data($menuTypeData, 'menu_type');


		// item_list
		$item_list = [
			['shop_id' => $shop_id, 'user_id' => $user_id, "status" => "1", "uid" => time() . random_string('numeric', 3), 'is_default' => 1],
			['shop_id' => $shop_id, 'user_id' => $user_id, "status" => "1", "uid" => time() . random_string('numeric', 3), 'is_default' => 1],
			['shop_id' => $shop_id, 'user_id' => $user_id, "status" => "1", "uid" => time() . random_string('numeric', 3), 'is_default' => 1],
			['shop_id' => $shop_id, 'user_id' => $user_id, "status" => "1", "uid" => time() . random_string('numeric', 3), 'is_default' => 1]
		];

		$itemListIds = $this->admin_m->insert_batch_data($item_list, 'item_list');

		// items

		$items = [
			['shop_id' => $shop_id, 'user_id' => $user_id, "cat_id" => $categoryIds[0], "allergen_id" => "null", "title" => "Cheese Pizza", "images" => "", "thumb" => "", "veg_type" => "2", "price" => "{\"variant_name\":\"Size\",\"variant_options\":[{\"name\":\"S\",\"price\":\"5\",\"slug\":\"slug_0\"},{\"name\":\"M\",\"price\":\"10\",\"slug\":\"slug_1\"},{\"name\":\"L\",\"price\":\"15\",\"slug\":\"slug_2\"},{\"name\":\"XL\",\"price\":\"20\",\"slug\":\"slug_3\"}]}", "is_size" => "1", "details" => "", "overview" => "Pizza.......", "is_features" => "1", "status" => "1", "created_at" => d_time(), "remaining" => "0", "in_stock" => "0", "img_type" => "1", "img_url" => "", "extra_images" => null, "orders" => "1", "tax_fee" => "0", "tax_status" => "0", "language" => !empty(site_lang()) ? site_lang() : 'english', "item_id" => $itemListIds[0], "uid" => "14681", "is_pos_only" => "0", "is_default" => 1],
			['shop_id' => $shop_id, 'user_id' => $user_id, "cat_id" => $categoryIds[0], "allergen_id" => "null", "title" => "Beef Pizza", "images" => "", "thumb" => "", "veg_type" => "2", "price" => "40", "is_size" => "0", "details" => "", "overview" => "Beef Pizza, Size: Family", "is_features" => "1", "status" => "1", "created_at" => d_time(), "remaining" => "0", "in_stock" => "0", "img_type" => "1", "img_url" => "", "extra_images" => null, "orders" => "2", "tax_fee" => "0", "tax_status" => "0", "language" => !empty(site_lang()) ? site_lang() : 'english', "item_id" => $itemListIds[1], "uid" => "18947", "is_pos_only" => "0", "is_default" => 1],

			['shop_id' => $shop_id, 'user_id' => $user_id, "cat_id" => $categoryIds[1], "allergen_id" => "null", "title" => "cheese Burger", "images" => "", "thumb" => "", "veg_type" => "2", "price" => "20", "is_size" => "0", "details" => "", "overview" => "Cheese Burger", "is_features" => "1", "status" => "1", "created_at" => d_time(), "remaining" => "0", "in_stock" => "0", "img_type" => "1", "img_url" => "", "extra_images" => null, "orders" => "3", "tax_fee" => "0", "tax_status" => "0", "language" => !empty(site_lang()) ? site_lang() : 'english', "item_id" => $itemListIds[2], "uid" => "10819", "is_pos_only" => "0", "is_default" => 1],

			['shop_id' => $shop_id, 'user_id' => $user_id, "cat_id" => $categoryIds[1], "allergen_id" => "null", "title" => "Vegetables Burger", "images" => "", "thumb" => "", "veg_type" => "1", "price" => "4", "is_size" => "0", "details" => "", "overview" => "Vegetables Burger.....", "is_features" => "0", "status" => "1", "created_at" => d_time(), "remaining" => "0", "in_stock" => "0", "img_type" => "1", "img_url" => "", "extra_images" => null, "orders" => "4", "tax_fee" => "0", "tax_status" => "0", "language" => !empty(site_lang()) ? site_lang() : 'english', "item_id" => $itemListIds[3], "uid" => "14958", "is_pos_only" => "0", "is_default" => 1]
		];

		// Insert data into the menu_type table
		$itemListIds = $this->admin_m->insert_batch_data($items, 'items');

		// Prepare data for extra_title_list table using the first menu type ID
		$extraTitleListData = array(
			array('title' => 'Addons', 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'is_required' => '1', 'is_single_select' => '0', 'orders' => '1', 'is_radio_btn' => '1', 'select_limit' => '1', 'select_max_limit' => '3', 'language' => !empty(site_lang()) ? site_lang() : 'english', 'created_at' => d_time(), 'is_default' => '1'),
			array('title' => 'Sizes', 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'is_required' => '1', 'is_single_select' => '1', 'orders' => '2', 'is_radio_btn' => '1', 'select_limit' => '1', 'select_max_limit' => '1', 'language' => !empty(site_lang()) ? site_lang() : 'english', 'created_at' => d_time(), 'is_default' => '1')
		);

		$extraTitleListIds = $this->admin_m->insert_batch_data($extraTitleListData, 'extra_title_list');



		// Prepare data for item_extras table using the retrieved menu type and extra title list IDs
		$itemExtrasData = array(
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'ex_name' => 'Extra Cheese', 'ex_price' => '0.5', 'ex_id' => '0', 'extra_title_id' => $extraTitleListIds[0], 'is_default' => '1'),
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'ex_name' => 'Extra spices', 'ex_price' => '0.5', 'ex_id' => '0', 'extra_title_id' => $extraTitleListIds[0], 'is_default' => '1'),
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'ex_name' => 'Souces', 'ex_price' => '1', 'ex_id' => '0', 'extra_title_id' => $extraTitleListIds[0], 'is_default' => '1'),
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'ex_name' => 'Small', 'ex_price' => '20', 'ex_id' => '0', 'extra_title_id' => $extraTitleListIds[1], 'is_default' => '1'),
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'ex_name' => 'Large', 'ex_price' => '25', 'ex_id' => '0', 'extra_title_id' => $extraTitleListIds[1], 'is_default' => '1'),
			array('user_id' => $user_id, 'shop_id' => $shop_id, 'item_id' => $itemListIds[1], 'ex_name' => 'Family', 'ex_price' => '30', 'ex_id' => '0', 'extra_title_id' => $extraTitleListIds[1], 'is_default' => '1')
		);

		$extraTitleListIds = $this->admin_m->insert_batch_data($itemExtrasData, 'item_extras');

		// Optionally, you can check if the inserts were successful and handle any errors
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}


	protected function removeId__($data, $shop_id, $user_id)
	{
		$allExistingIds = [];

		foreach ($data as $tableName => $records) {


			$updatedRecords = array_map(function ($record) use ($shop_id, $user_id) {
				$record['shop_id'] = $shop_id;
				$record['user_id'] = $user_id;
				$record['is_default'] = 1;
				return $record;
			}, $records);

			// Check if the same data already exists
			$existingData = $this->db->where_in('shop_id', array_column($updatedRecords, 'shop_id'))
				->where_in('user_id', array_column($updatedRecords, 'user_id'))
				->where_in('is_default', array_column($updatedRecords, 'is_default'))
				->get($tableName)
				->result_array();

			$existingIds = array_column($existingData, 'shop_id');

			$newRecords = array_filter($updatedRecords, function ($record) use ($existingIds) {
				if (isset($record['shop_id'])) {
					return !in_array($record['shop_id'], $existingIds);
				}
				return true;
			});

			if (!empty($newRecords)) {
				$this->db->insert_batch($tableName, $newRecords);

				if ($this->db->affected_rows() > 0) {
					$allExistingIds = array_merge($allExistingIds, array_column($newRecords, 'shop_id'));
				} else {
					// echo "Error inserting new records into $tableName\n";
					return false;
				}
			} else {
				$allExistingIds = array_merge($allExistingIds, $existingIds);
			}
		}

		return true;
	}

	public function removeTablesData($shop_id, $user_id)
	{
		// Specify the table names
		$tables = ['item_category_list', 'menu_type', 'item_list', 'items', 'extra_title_list', 'item_extras'];

		foreach ($tables as $table) {
			if ($this->db->field_exists('user_id', $table)) {
				$this->db->where('user_id', $user_id);
			} elseif ($this->db->field_exists('shop_id', $table)) {
				$this->db->where('shop_id', $shop_id);
			}
			$this->db->where('is_default', 1);
			$this->db->delete($table);
		}

		return true;
	}

	public function tables()
	{
		$tables = array('users_active_features', 'user_settings', 'allergens', 'menu_type', 'users_active_order_types', 'items', 'item_list', 'coupon_list', 'delivery_area_list', 'expense_category_list', 'expense_list', 'extra_libraries', 'hotel_list', 'item_category_list', 'item_packages', 'order_item_list', 'staff_order_activity_logs', 'extra_title_list', 'item_extras', 'reservation_date', 'restaurant_city_list', 'restaurant_list', 'users', 'settings', '	about', 'about_content', 'addons_list', 'admin_config', 'admin_notification', 'admin_notification_list', 'admin_tutorial_list', 'affiliate_payout_list', 'allergens', 'call_waiter_list', 'coupon_list', 'customer_list', '	data_queue', 'delivery_area_list', 'email_template', 'expense_category_list', 'expense_list', 'extra_libraries');
		foreach ($tables as $table) {
			$this->db->truncate($table);
		}

		return true;
	}

	public function generate()
	{
		$urls = $this->admin_m->select('sitemap_list');

		$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
		$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach ($urls as $row) {
			$sitemap .= '<url>';
			$sitemap .= '<loc>' . prep_url($row['url']) . '</loc>';
			$sitemap .= '<lastmod>' . $row['created_at'] . '</lastmod>';
			$sitemap .= '<changefreq>'.$row['changefreq'].'</changefreq>';
			$sitemap .= '<priority>0.8</priority>';
			$sitemap .= '</url>';
		}
		$sitemap .= '</urlset>';

		// Save the XML content to a file
		file_put_contents(FCPATH . 'sitemap.xml', $sitemap);
	}
}
