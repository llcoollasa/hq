<h3>PAYMENT</h3>

<table>
	<tr>
		<td><label>Credit card holder First Name</label></td>
		<td><input type='text' name='cc_first_name' size="20"/></td>
	</tr>
	<tr>
		<td><label>Credit card holder Last Name</label></td>
		<td><input type='text' name='cc_last_name' size="20"/></td>
	</tr>
	<tr>
		<td><label>Credit card Type</label></td>
		<td>
			<select name="cc_type">
				<option value="visa">VISA</option>
				<option value="amex">AMEX</option>
				<option value="master">MASTER</option> 
			</select>
		</td>
	</tr>
	<tr>
		<td><label>Credit card number</label></td>
		<td><input type='text' name='cc_number' size="50"/></td>
	</tr>		
	<tr>
		<td><label>Credit card expiration <i>(Month/Year)</i> </label></td>
		<td><input type='text' name='cc_exp_month' size="2" maxlength="2" />/<input type='text' name='cc_exp_year' size="4" maxlength="4"/></td>
	</tr>
	<tr>
		<td><label>Credit card CCV</label></td>
		<td><input type='text' name='cc_ccv' size="4"/></td>
	</tr>			
</table>

 


<!--
'4417119669820331'
'visa' 
'11'; 
'2018'; 
$card->setCvv2('874'); $card->setF
irstName('Lasa'); 
$card->setLastName('dfdfdfdfdfd'); 
$card->setBillingAddress($addr);
-->