<?php
 
class Hq_cart extends CI_Model {
 

    function __construct()
    { 
        parent::__construct();
    }


    function retrieve_products(){
        $query = $this->db->get('products'); // Select the table products
        return $query->result_array(); // Return the results in a array.
    }  

    function validate_add_cart_item()
    {	     
	    $id = $this->input->post('product_id'); // Assign posted product_id to $id
	    $cty = $this->input->post('quantity'); // Assign posted quantity to $cty
	     
	    $this->db->where('id', $id); // Select where id matches the posted id
	    $query = $this->db->get('products', 1); // Select the products where a match is found and limit the query by 1
	 
	    // Check if a row has matched our product id
	    if($query->num_rows > 0){
	     
	    // We have a match!
	        foreach ($query->result() as $row)
	        { 
	        	$item_in_cart = FALSE;

        		$cart_items = $this->cart->contents();
        		
        		foreach ($cart_items as $key => $value) 
        		{
        			if($value['id']==$id)
        			{
        				$data = array(
    					 	'rowid' => $value['rowid'],
               				'qty'   => $cty,
               				'cur'   => $this->session->userdata('currency')
			            );
			            $this->cart->update($data);
        			}
        			else
        			{
    					$item_in_cart = FALSE;
        			}
        		}

        		if(!$item_in_cart)
        		{
		            // Create an array with product information
		            $data = array(
		                'id'      => $id,
		                'qty'     => $cty,
		                'price'   => $row->price,
		                'name'    => $row->name,
		                'cur'   => $this->session->userdata('currency')
		            );
		 
		            // Add the data to the cart using the insert function that is available because we loaded the cart library
		            $this->cart->insert($data);
	            }

	            return TRUE; // Finally return TRUE
	        }
	     
	    }else{
	        // Nothing found! Return FALSE!
	        return FALSE;
	    }
	}

	function validate_update_cart()
	{
     
	    // Get the total number of items in cart
	    $total = $this->cart->contents();
	     
	    // Retrieve the posted information
	    $item = $this->input->post('rowid');
	    $qty = $this->input->post('qty'); 

	    foreach ($total as $key => $value) 
		{
			for($i=0;$i < count($total);$i++)
			{
				if($value['rowid']==$item[$i])
				{
					$data = array(
					 	'rowid' => $value['rowid'],
	       				'qty'   => $qty[$i]
		            );
		            $this->cart->update($data);
				}
			}
		}
 
	}
     
}