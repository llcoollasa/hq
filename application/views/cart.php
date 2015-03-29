<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HQ Test</title>
 
<link href="assets/css/main.css" media="screen" rel="stylesheet" type="text/css" />
<link href="assets/css/cart.css" media="screen" rel="stylesheet" type="text/css" />
 
<script type="text/javascript" src="assets/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="assets/js/core.js"></script>
</head>
<body>
 
<div id="wrap">
 
 	<?php $this->view($currency); ?>
 	
    <?php $this->view($content); ?>    
	
    <div class="cart_list">
	    <h3>SHOPPING CART</h3>
	    <div id="cart_content">
        <?php $this->view('cart/cart'); ?> 
    	</div>
    </div>
    
	<?php echo form_open('checkout',array("name"=>"nsds")); ?>
	<?php $this->view($customer); ?> 
	<p><?php echo form_submit('checkout', 'Checkout');?></p>
	<?php echo form_close(); ?>

	<code>	
	<?php echo anchor('', 'Homepage', 'title="Homepage"'); ?>
	</code>  

</div>
 
</body>
</html>