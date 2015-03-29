<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_functions extends CI_Controller {

	public function index()
	{ 
		echo "functions";
	}

	public function cur()
	{	  
		echo getCurrency('symbol');
		 var_dump(getCurrency()); 
	}
 
}

