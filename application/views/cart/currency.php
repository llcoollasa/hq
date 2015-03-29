<h3>CURRENCY</h3>
<?php echo form_open('cart/change_currency'); ?>
<?php $currency =  $this->session->userdata('currency'); ?>
<span></span>
<select name="cur" onchange="this.form.submit()">
	<?php echo getCurrencyList();?>	
</select>
<?php echo form_close(); ?>