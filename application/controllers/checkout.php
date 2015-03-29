<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function index()
	{ 
		$full_name = $this->input->post('full_name');
		$this->session->set_userdata('full_name', $full_name);
		$data = array('title'=>"Checkout");
		$data = array('checkout_data' => $this->session->all_userdata(), 'customer'=>$full_name);
		$body = $this->load->view('sale/checkout', $data, true);
		$data = array('body'=>$body);
 
		$this->load->view('page',$data);
		



		
	}
}


