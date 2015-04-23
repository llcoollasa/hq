<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function index()
	{ 
		//customer details		
		$customer['full_name'] = $this->input->post('full_name');

		//cc info
		$cc = array();
		$cc['cc_first_name'] = $this->input->post('cc_first_name');
		$cc['cc_last_name'] = $this->input->post('cc_last_name');
		$cc['cc_type'] = $this->input->post('cc_type');
		$cc['cc_number'] = $this->input->post('cc_number');
		$cc['cc_exp_month'] = $this->input->post('cc_exp_month');
		$cc['cc_exp_year'] = $this->input->post('cc_exp_year');
		$cc['cc_ccv'] = $this->input->post('cc_ccv'); 

		//$this->session->set_userdata('full_name', $full_name);

		$data = array('title'=>"Checkout");
		$data = array('checkout_data' => $this->session->all_userdata(), 'customer'=>$customer, 'cc'=>$cc);


		//payment		
		$this->load->model('payments/payment','payment_model');
		$this->payment_model->pay($data);


		exit;

		$body = $this->load->view('sale/checkout', $data, true);
		$data = array('body'=>$body);
 

		

		// $this->load->library('vendor');
		// $this->vendor->load('paypal'); 
		// $this->vendor->purchase();





		$this->load->view('page',$data);
		



		
	}
}


