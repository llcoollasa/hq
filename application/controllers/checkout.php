<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function index()
	{ 
		$data = array('title'=>"Checkout");
		$data = array('checkout_data' => $this->session->all_userdata());
		$body = $this->load->view('sale/checkout', $data, true);
		$data = array('body'=>$body);

		
 		
		$this->load->view('page',$data);
		



		
	}
}


