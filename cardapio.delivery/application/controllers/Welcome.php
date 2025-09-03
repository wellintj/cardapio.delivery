<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function remove_old_images()
	{
		$folder_name = 'uploads/orders_qr';
		// Path to the folder
		$folder_path = FCPATH . $folder_name;

		// Check if the folder exists
		if (!is_dir($folder_path)) {
			// echo "Folder does not exist.\n";
			return;
		}

		// Get current time
		$now = time();

		// Open the directory
		if ($handle = opendir($folder_path)) {
			// Loop through files in the directory
			while (false !== ($file = readdir($handle))) {
				$file_path = $folder_path . '/' . $file;

				// Check if it is a file (not a directory)
				if (is_file($file_path)) {
					// Get file modification time
					$file_mtime = filemtime($file_path);

					// Calculate age of file in days
					$file_age_days = number_format(($now - $file_mtime) / (60 * 60 * 24),0);

					// Debugging output
					// echo "File: $file, Age: $file_age_days days\n";
				

					// If file is older than 7 days, delete it
					if ($file_age_days > 7) {
						if (unlink($file_path)) {
							// echo "Deleted: $file_path\n";
							return true;
						} else {
							// echo "Failed to delete: $file_path\n";
							return true;
						}
					}
				}
			}
			closedir($handle);
		} else {
			// echo "Failed to open directory: $folder_path\n";
			return true;
		}
	}


	public function remove_old_data()
	{
		$tables = ['customer_list', 'staff_order_activity_logs', 'order_item_list', 'order_user_list'];
		$date_column = 'created_at';


		// Validate input
		if (empty($tables) || !is_array($tables)) {
			// echo "No tables provided or invalid input.";
			return;
		}

		// Get the date 7 days ago
		$seven_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));

		// Iterate over each table and delete old records
		foreach ($tables as $table) {
			// Validate table name (avoid SQL injection)
			if (!$this->db->table_exists($table)) {
				// echo "Table $table does not exist.\n";
				continue;
			}

			// Build the query
			$this->db->where($date_column . ' <', $seven_days_ago);
			$this->db->delete($table);

			if ($this->db->affected_rows() > 0) {
				// echo "Deleted old records from $table.\n";
				return true;
			} else {
				// echo "No old records found in $table or deletion failed.\n";
				return true;
			}
		}

		$this->remove_id_data();
		$this->remove_user_id_data();
		$this->remove_old_images();
	}


	public function remove_id_data()
	{
		$tables = ['users']; // Array of table names
		$user_ids = [1, 8, 19]; // Array of user IDs to exclude

		// Validate input
		if (empty($tables) || !is_array($tables)) {
			echo "No tables provided or invalid input.";
			return;
		}

		// Iterate over each table and delete records
		foreach ($tables as $table) {
			// Validate table name (avoid SQL injection)
			if (!$this->db->table_exists($table)) {
				echo "Table $table does not exist.\n";
				continue;
			}

			// Build the query using NOT IN
			$this->db->where_not_in('id', $user_ids);
			$this->db->delete($table);

			if ($this->db->affected_rows() > 0) {
				return true;
				// echo "Deleted records from $table where user_id NOT IN (" . implode(',', $user_ids) . ").\n";
			} else {
				return true;
				// echo "No matching records found in $table or deletion failed.\n";
			}
		}
	}

	public function remove_user_id_data()
	{
		$tables = ['user_settings', 'users_active_order_types', 'users_active_features', 'restaurant_list']; // Array of table names
		$user_ids = [1, 8, 19]; // Array of user IDs to exclude

		// Validate input
		if (empty($tables) || !is_array($tables)) {
			echo "No tables provided or invalid input.";
			return;
		}

		// Iterate over each table and delete records
		foreach ($tables as $table) {
			// Validate table name (avoid SQL injection)
			if (!$this->db->table_exists($table)) {
				echo "Table $table does not exist.\n";
				continue;
			}

			// Build the query using NOT IN
			$this->db->where_not_in('user_id', $user_ids);
			$this->db->delete($table);

			if ($this->db->affected_rows() > 0) {
				// echo "Deleted records from $table where user_id NOT IN (" . implode(',', $user_ids) . ").\n";
				return true;
			} else {
				// echo "No matching records found in $table or deletion failed.\n";
				return true;
			}
		}
	}
}
