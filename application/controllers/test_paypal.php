<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_paypal extends CI_Controller {

	public function index()
	{ 
		echo "paypal tests";
	}

	public function pay()
	{	
		
		$this->load->library('vendor');
		$this->vendor->load('paypal'); 
		$this->vendor->purchase();
		var_dump("sds");
	}
 
}

