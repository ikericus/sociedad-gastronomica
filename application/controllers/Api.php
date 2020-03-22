<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Admin_Controller 
{	
	var $secret_key = '';

	public function __construct()
	{
		parent::__construct();

		$this->data['page_title'] = 'Api';

		$this->load->model('model_sms');
		$this->load->model('model_payments');
		$this->load->model('model_users');
	}

	public function add($jwt = null)
	{
		//echo 'KAKA';
		$this->load->helper('jwt_helper');

		$key = $this->config->item('api_key');
		
		$decoded = JWT::decode($jwt, $key, false);
		//echo json_encode($decoded);
		
		$this->ManageSms($decoded->sender, $decoded->body);
		return;

		// if((ValidKey($key)){
		//  	ManageSms($sender, $body);
		// }
	}

	public function ManageSms($sender, $body)
	{
		// store sms
		$this->model_sms->add($sender, $body);

		// store payment
		$this->ManagePayment($sender, $body);

		return true;
	}

	public function ManagePayment($sender, $body)
	{
		if($sender and $sender == $this->config->item('bizum_sender'))
		{
			$start = "Has recibido un BIZUM de ";
			$second = " EUR de ";
			$third = " por ";
			if(substr($body, 0, strlen($start)) === $start)
			{
				$body = str_replace($start, "", $body);
				$amount = substr($body, 0, strpos($body, $second));
				
				$body = str_replace($amount, "", $body);
				$body = str_replace($second, "", $body);

				$username = substr($body, 0, strpos($body, $third));
				
				$body = str_replace($username, "", $body);
				$body = str_replace($third, "", $body);

				$concept = $body;

				$this->addPayment($username, $amount, $concept);
			}
		}
	}

	private function addPayment($username = null, $amount = null, $concept)
	{
		if($username){
			$user = $this->model_users->getUserFromUsername($username);
			if($user and $amount) {				
				$user_id = $user['id'];
				if($user_id)
				{		
					$payment = $this->model_payments->create($user_id, $amount);
					if($payment){
						echo $user['firstname'];
						echo ' ha pagado ';
						echo $amount;
						echo ' €';
						return;
					}
				}
				echo 'error en el pago';
				return;
			}
			else{						
				echo 'username incorrecto: ';
				echo $username;
			}
		}	
		else{						
			echo 'username vacio';
		}
	}
}