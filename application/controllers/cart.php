<?php
class Cart extends CI_Controller { 
     
  	function __construct()
    {
        parent::__construct();
        $this->load->model('cart/hq_cart','cart_model');
    }

	public function index()
	{
		$data['products'] = $this->cart_model->retrieve_products();      
	    $data['content'] = 'cart/products';
	    $data['currency'] = 'cart/currency';
	    $data['customer'] = 'customer/customer';
	    $data['payment'] = 'customer/payment';
	    $data['cur_symbol'] = getCurrency('symbol');
	    $this->load->view('cart', $data);
	}

	public function add_cart_item()
	{
     
	    if($this->cart_model->validate_add_cart_item() == TRUE)
	    {

	        if($this->input->post('ajax') != '1')
	        {
	            redirect('cart');
	        }
	        else
	        {
	            echo 'true';
	        }
	    }     
	}

	public function show_cart()
	{
	    $this->load->view('cart/cart');
	}

	public function update_cart()
	{
	    $this->cart_model->validate_update_cart();
	    redirect('cart');
	}

	public function empty_cart()
	{
	    $this->cart->destroy(); // Destroy all cart data
	    redirect('cart'); // Refresh te page
	}

	public function change_currency()
	{
		changeCurrency();
	    $this->update_cart();
	}
	
}