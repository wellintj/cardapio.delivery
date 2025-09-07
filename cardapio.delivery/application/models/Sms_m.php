<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use GuzzleHttp\Client;
class Sms_m extends CI_Model {


	public function __construct()
	{
		// parent::__construct();
		
	}

	public function send_smg()
	{
		
			require_once('vendor/autoload.php');



				$api_key = '404668Aezy3eVE64edbca8P1';
				$endpoint = 'https://api.msg91.com/api/sendhttp.php';

				$client = new Client();

				$params = [
				    'authkey' => $api_key,
				    'mobiles' => '1685576546',
				    'message' => 'Your message here',
				    'sender' => '123456',
				    'route' => '2',  // Route for transactional messages
				    'country' => '880',  // Country code
				];

				$response = $client->post($endpoint, [
				    'form_params' => $params
				]);

			echo $response->getBody();

			exit();

			$client = new \GuzzleHttp\Client();

			$response = $client->request('POST', 'https://control.msg91.com/api/v5/flow/', [
			  'body' => '{"template_id":"EntertemplateID","short_url":"1","recipients":[{"mobiles":"8801685576546","VAR1":"Your OTP is 1234","VAR2":"text"}]}',
			  'headers' => [
			    'accept' => 'application/json',
			    'authkey' => '404668Aezy3eVE64edbca8P1',
			    'content-type' => 'application/json',
			  ],
			]);

		echo $response->getBody();
	}

}

/* End of file Sms_m.php */
/* Location: ./application/models/Sms_m.php */