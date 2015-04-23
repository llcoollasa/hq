<?php
 
class Payment extends CI_Model {
 

    function __construct()
    { 
        parent::__construct();
    }
    
    function pay($params)
    {
    	$this->load->library('vendor');
		$this->vendor->load('paypal'); 
		$this->vendor->set_params($params);
		$this->vendor->purchase();
    }
}