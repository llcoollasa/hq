<div>
	
	<?php echo form_open('products'); ?>
		<div>Product A</div>
		<div>Product Description</div>
		<div>
			<input type="text" name='qty' size="4" value="1" /> 
			<input type="hidden" name='pro_id' value="1" /> 
		</div>
		<div class='errors'>
			<?php echo validation_errors(); ?>
		</div>
		<div><input type="submit" name='add' value="Add" /> </div>
	</form>

</div>