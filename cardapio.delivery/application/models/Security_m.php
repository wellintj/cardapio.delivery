<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Security_m extends CI_Model
{


	protected $cookie_name = 'rate_limiter_';
	protected $table = 'user_action_attempts';
	protected $cookie_expire = 86400; // 24 hours
	protected $xss_log = false;
	protected $action_configs;
	protected $is_attempts;
	protected $is_allow_spam;

	protected $default_config = [
		'max_cookie_attempts' => 3,
		'max_db_attempts' => 5,
		'block_time' => 300, // 5 minutes in seconds
	];

	private $log_file = APPPATH . 'logs/xss_cleaner.log';
	// xss cleaning functions
	protected $max_attempts;
	private $allowed_tags = '<b><i><img><table><td><tr><th><video><p><strong><em><blockquote><code><pre><li><ul><ol><br><a><s><u>';

	private $script_patterns = [
		'/<script\b[^>]*>(.*?)<\/script>/is', // Capture <script> tags
		'/<[^>]*\bjavascript:[^>]*>/is',      // Capture JavaScript URIs
		'/<[^>]+on\w+=["\'][^"\']*["\']/is'   // Capture inline event handlers
	];


	private $sql_patterns = [
		'/\b(UNION\s+SELECT|INSERT\s+INTO|UPDATE\s+\w+\s+SET|DELETE\s+FROM|DROP\s+TABLE|TRUNCATE\s+TABLE|ALTER\s+TABLE|CREATE\s+TABLE)\b/',
		'/\b(WHERE|AND|GROUP\s+BY|ORDER\s+BY|HAVING|LIMIT)\b/',
		'/\b(SLEEP|BENCHMARK|DELAY|WAITFOR)\b/',
		'/\b(XOR|IF|CASE|WHEN|THEN|ELSE|END)\b/',
		'/\b(CONCAT|CHAR|SUBSTR|ASCII)\b/',
		'/\b(LOAD_FILE|INFILE|OUTFILE)\b/',
		'/\b(INFORMATION_SCHEMA|SCHEMA_NAME|TABLE_NAME)\b/',
		'/\b(NOW\(\)|SYSDATE\(\))\b/',
		'/\b\w+\(\)\s*=\s*\w+\(\)/',
		'/\b\w+\(\)\b/'
	];





	public function __construct()
	{
		// parent::__construct();
		$this->load->database();
		$this->load->helper('security');
		$this->db->query("SET sql_mode = ''");
		$this->initializeActionConfigs();
	}

	private function log_message($message)
	{
		$timestamp = date('Y-m-d H:i:s');
		$log_entry = "[$timestamp] $message" . PHP_EOL;
		file_put_contents($this->log_file, $log_entry, FILE_APPEND);
	}

	protected function initializeActionConfigs()
	{
		$s = $this->db->get('settings')->row_array();
		$app =  isset($s['attempt_config']) && isJson($s['attempt_config']) ? json_decode($s['attempt_config']) : "";

		$this->is_attempts = isset($app->is_user_attempts) && $app->is_user_attempts == 1 ? 1  : 0;
		$this->is_allow_spam = isset($app->is_spam) && $app->is_spam == 1 ? 1  : 0;
		$this->max_attempts = isset($app->spam_attempts)  ? $app->spam_attempts  : 3;

		$this->action_configs = [
			'registration' => [
				'max_cookie_attempts' => 2,
				'max_db_attempts' => 2,
				'block_time' => 86400, // 24 hours in seconds
			],
			'checkout' => [
				'max_cookie_attempts' => 3,
				'max_db_attempts' => $app->user_attempts ?? 10,
				'block_time' => 300, // 5 minutes in seconds
			],

			'reservation' => [
				'max_cookie_attempts' => 3,
				'max_db_attempts' => 5,
				'block_time' => 300, // 5 minutes in seconds
			],
		];
	}


	public function clean($data)
	{
		$original_data = $data;
		$cleaned_data = $this->xss_clean($data);

		$threats = $this->get_threats($original_data);
		if (!empty($threats)) {
			$this->log_single_attempt(implode(' | ', $threats));
			if (!$this->can_insert()) {
				log_message('error', 'Multiple attack attempts detected from IP: ' . $this->input->ip_address());
				return false; // Block further operations
			}
		}
		return $cleaned_data;
	}
	public function xss_clean($data)
	{
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = $this->xss_clean($value);
			}
		} else if (is_string($data)) {
			if ($this->xss_log == true) {
				$this->log_message("Original data (truncated): " . substr($data, 0, 100));
			}

			$data = preg_replace_callback('/\{[^}]+\}/', function ($matches) {
				return $matches[0]; // Preserve placeholders
			}, $data);

			$data = html_entity_decode($data, ENT_QUOTES, "UTF-8");

			if ($this->xss_log == true) {
				$this->log_message("Data after html_entity_decode (truncated): " . substr($data, 0, 100));
			}

			$data = $this->remove_unwanted_tags($data, $this->allowed_tags);

			if ($this->xss_log == true) {
				$this->log_message("Data after remove_unwanted_tags (truncated): " . substr($data, 0, 100));
			}

			$data = preg_replace_callback(
				'/<img\b([^>]*)>/i',
				function ($matches) {
					$attributes = $matches[1];
					$sanitizedAttributes = '';

					// Allow both regular URLs and data:image base64 src
					if (preg_match('/src=["\']?((?:https?:\/\/|data:image\/[a-zA-Z]+;base64,)[^"\']+)["\']?/i', $attributes, $srcMatch)) {
						$sanitizedAttributes .= ' src="' . $srcMatch[1] . '"';
						if ($this->xss_log == true) {
							$this->log_message("Matched src attribute (truncated): " . substr($srcMatch[1], 0, 100));
						}
					}

					// Preserve style attribute
					if (preg_match('/style=["\']([^"\']+)["\']/', $attributes, $styleMatch)) {
						$sanitizedStyle = $this->sanitize_style($styleMatch[1]);
						if (!empty($sanitizedStyle)) {
							$sanitizedAttributes .= ' style="' . $sanitizedStyle . '"';
						}
					}

					// Preserve other allowed attributes
					$allowedAttrs = ['alt', 'width', 'height', 'data-filename', 'title'];
					foreach ($allowedAttrs as $attr) {
						if (preg_match('/' . $attr . '=["\']?([^"\']+)["\']?/i', $attributes, $attrMatch)) {
							$sanitizedAttributes .= ' ' . $attr . '="' . $attrMatch[1] . '"';
						}
					}

					if ($this->xss_log == true) {
						$this->log_message("Sanitized IMG tag: <img" . $sanitizedAttributes . ">");
					}

					return '<img' . $sanitizedAttributes . '>';
				},
				$data
			);

			if ($this->xss_log == true) {
				$this->log_message("Data before threat detection (truncated): " . substr($data, 0, 100));
			}

			// Detect and remove threats
			$threats = $this->get_threats($data);
			if (!empty($threats)) {
				foreach ($threats as $threat) {
					$data = str_replace($threat, '', $data);
					if ($this->xss_log == true) {
						$this->log_message("Removed threat: " . $threat);
					}
				}
			}

			if ($this->xss_log == true) {
				$this->log_message("Final data after processing (truncated): " . substr($data, 0, 100));
			}
		}

		return $data;
	}

	private function sanitize_style($style)
	{
		$allowedStyles = [
			'width',
			'height',
			'max-width',
			'max-height',
			'color',
			'background-color',
			'font-size',
			'font-family',
			'font-weight',
			'text-align',
			'margin',
			'padding',
			'border',
			'display',
			'float'
		];

		$sanitized = [];
		$styles = explode(';', $style);
		foreach ($styles as $declaration) {
			$parts = explode(':', $declaration, 2);
			if (count($parts) == 2) {
				$property = trim($parts[0]);
				$value = trim($parts[1]);
				if (in_array($property, $allowedStyles)) {
					// Less restrictive value sanitization
					$value = preg_replace('/[^\w\-\#\(\)\.\s\%\,:]/', '', $value);
					$sanitized[] = $property . ':' . $value;
				}
			}
		}

		return implode(';', $sanitized);
	}





	private function remove_unwanted_tags($html, $allowed_tags)
	{
		// Convert the allowed tags string into an array of tag names
		$allowed_tags_array = explode('><', trim($allowed_tags, '<>'));

		// Allow specific attributes for certain tags
		$allowed_attributes = [
			'img' => ['src', 'alt', 'width', 'height', 'style', 'data-filename', 'title'],
		];

		$tag_patterns = [];
		foreach ($allowed_tags_array as $tag) {
			if (isset($allowed_attributes[$tag])) {
				$attr_pattern = implode('|', array_map('preg_quote', $allowed_attributes[$tag]));
				$tag_patterns[] = sprintf('<%s\b[^>]*(%s=["\']?(data:image\/[a-zA-Z]+;base64,[^"\']*|[^"\'>]*)["\']?)?[^>]*>', preg_quote($tag), $attr_pattern);
			} else {
				$tag_patterns[] = sprintf('<%s\b[^>]*>', preg_quote($tag));
			}
		}

		// Create a regex pattern that matches any tag not in the allowed list
		$pattern = sprintf('#<(?!/?(%s)\b)[^>]*>#i', implode('|', $allowed_tags_array));

		// Remove all tags not in the allowed list
		$cleaned_html = preg_replace($pattern, '', $html);

		if ($cleaned_html !== $html) {
			$this->log_message("Tags removed by remove_unwanted_tags:");
			$this->log_message("Before: " . $html);
			$this->log_message("After: " . $cleaned_html);
		}

		return $cleaned_html;
	}







	private function get_threats($data)
	{
		$threats = [];
		if (is_string($data)) {
			// Preserve placeholders
			$cleaned_data = preg_replace_callback('/\{[^}]+\}/', function ($matches) {
				return $matches[0];
			}, $data);

			// Check for script patterns
			foreach ($this->script_patterns as $pattern) {
				if (preg_match_all($pattern, $cleaned_data, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$this->log_message('Script threat detected: ' . $match[0] . ' with pattern: ' . $pattern);
						$threats[] = $match[0];
					}
				}
			}

			// Check for SQL patterns (case-sensitive)
			foreach ($this->sql_patterns as $pattern) {
				if (preg_match_all($pattern, $cleaned_data, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						// Check if the matched string is in uppercase
						if (strtoupper($match[0]) === $match[0]) {
							$this->log_message('SQL threat detected: ' . $match[0] . ' with pattern: ' . $pattern);
							$threats[] = $match[0];
						}
					}
				}
			}
		}
		return array_unique($threats);
	}

	private function log_single_attempt($keyword)
	{
		$ip_address = $this->input->ip_address();
		$record = $this->db->get_where('security_attempts', ['ip_address' => $ip_address])->row();

		if ($record) {
			// Update existing record
			$this->db->where('ip_address', $ip_address);
			$this->db->update('security_attempts', [
				'keywords' => $record->keywords . ' | ' . $keyword,
				'total_attempts' => $record->total_attempts + 1
			]);
		} else {
			// Insert new record
			$this->db->insert('security_attempts', [
				'ip_address' => $ip_address,
				'created_at' => date('Y-m-d H:i:s'),
				'keywords' => $keyword,
				'total_attempts' => 1
			]);
		}
	}

	private function get_attempt_info()
	{
		$ip_address = $this->input->ip_address();

		$record = $this->db->get_where('security_attempts', ['ip_address' => $ip_address])->row();
		if ($record) {
			return (object)[
				'recent_attempts' => $record->total_attempts,
				'total_attempts' => $record->total_attempts
			];
		}

		return (object)['recent_attempts' => 0, 'total_attempts' => 0];
	}

	public function can_insert()
	{
		if ($this->is_allow_spam == 1) {
			$attempt_info = $this->get_attempt_info();
			return $attempt_info->recent_attempts < $this->max_attempts;
		} else {
			return true;
		}
	}

	public function update_in($data, $ids, $table)
	{
		$cleaned_data = $this->clean($data);

		if ($cleaned_data === false) {
			return false; // Block the update operation
		}

		$this->db->where_in('id', $ids);
		$this->db->update($table, $cleaned_data);
		return true;
	}

	public function insert($data, $table)
	{
		$cleaned_data = $this->clean($data);

		if ($cleaned_data === false) {
			return false; // Block the insert operation
		}

		$this->db->insert($table, $cleaned_data);
		return $this->db->insert_id();
	}

	public function update($data, $id, $table)
	{
		$cleaned_data = $this->clean($data);
		if ($cleaned_data === false) {
			return false; // Block the update operation
		}

		$this->db->where('id', $id);
		$this->db->update($table, $cleaned_data);
		return $id;
	}




	/*----------------------------------------------
              User_action_attempts
    ----------------------------------------------*/

	public function check_limit($action)
	{
		
		if ($this->is_attempts == 0) {
			return true;
			exit();
		}


		$config = $this->get_action_config($action);
		$ip_address = $this->input->ip_address();
		$cookie_key = $this->cookie_name . $ip_address . '_' . $action;

		// Check database first for permanent ban
		$db_attempts = $this->get_db_attempts($ip_address, $action);
		if ($db_attempts >= $config['max_db_attempts']) {
			return FALSE; // Permanently banned
		}

		// Check cookie
		$cookie_data = $this->input->cookie($cookie_key);

		if ($cookie_data === NULL) {
			$cookie_data = array(
				'attempts' => 1,
				'last_attempt' => time()
			);
			$this->input->set_cookie($cookie_key, json_encode($cookie_data), $this->cookie_expire);
			return TRUE; // First attempt, allow action
		} else {
			$cookie_data = json_decode($cookie_data, TRUE);
			$time_since_last_attempt = time() - $cookie_data['last_attempt'];
		
			if ($time_since_last_attempt >= $config['block_time']) {
				// Reset cookie after block time
				$cookie_data = array(
					'attempts' => 1,
					'last_attempt' => time()
				);
				$this->input->set_cookie($cookie_key, json_encode($cookie_data), $this->cookie_expire);
				$this->insert_db_attempt($ip_address, $action); // Increment DB attempts after block time
				return TRUE; // Allow action after block time
			}

			$cookie_data['attempts']++;
			$cookie_data['last_attempt'] = time();

			if ($cookie_data['attempts'] > $config['max_cookie_attempts']) {
				$this->input->set_cookie($cookie_key, json_encode($cookie_data), $this->cookie_expire);
				return FALSE; // Block action
			} else {
				$this->input->set_cookie($cookie_key, json_encode($cookie_data), $this->cookie_expire);
				return TRUE; // Allow action
			}
		}
	}

	private function insert_db_attempt($ip_address, $action)
	{
		$existing_record = $this->db->get_where($this->table, array(
			'ip_address' => $ip_address,
			'action' => $action
		))->row();

		if ($existing_record) {
			$this->db->where('id', $existing_record->id);
			$this->db->set('total_attempts', 'total_attempts + 1', FALSE);
			$this->db->set('created_at', d_time());
			$this->db->update($this->table);
		} else {
			$data = array(
				'ip_address' => $ip_address,
				'action' => $action,
				'total_attempts' => 1,
				'created_at' => d_time()
			);
			$this->db->insert($this->table, $data);
		}
	}

	private function get_db_attempts($ip_address, $action)
	{
		$query = $this->db->get_where($this->table, array(
			'ip_address' => $ip_address,
			'action' => $action
		));
		$result = $query->row();
		return $result ? $result->total_attempts : 0;
	}

	private function get_action_config($action)
	{
		return isset($this->action_configs[$action]) ? $this->action_configs[$action] : $this->default_config;
	}
}
