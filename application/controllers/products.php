<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	public function index()
	{
		//$data = array('title'=>"Products"); 
		$data['title'] = "Products";

		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('qty', 'qty', 'required');
		$this->form_validation->set_rules('pro_id', 'pro_id', 'required'); 

		if ($this->form_validation->run() == FALSE)
		{
			$body = $this->load->view('products/products', '', true);
			$data['body'] = $body;	
			$this->load->view('page',$data);
		}
		else
		{
			$id = uniqid($this->input->ip_address(), TRUE);
			$product = array(
                   'qty'  => $this->input->post('qty'),
                   'pro_id'     => $this->input->post('pro_id'),
                   'my_session_id'=>md5($id)
               );

			// $exist_product=$this->session->all_userdata();

			// if(isset($exist_product['user_data']))
			// {
				 
			// }
			 
			$this->session->set_userdata($product);
			redirect('checkout');
		}
	}
}


