<?php $cur_symbol = getCurrency('symbol'); ?>

<?php if(!$this->cart->contents()):
    echo 'You don\'t have any items yet.';
else:
?>
 
<?php echo form_open('cart/update_cart'); ?>
<table width="100%" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <td><strong>Qty</strong></td>
            <td><strong>Item Description</strong></td>
            <td><strong>Item Price</strong></td>
            <td><strong>Sub Total</strong></td>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach($this->cart->contents() as $items): ?>         
        
        <tr <?php if($i&1){ echo 'class="alt"'; }?>>
            <td>
                <?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
                <?php echo form_hidden('rowid[]', $items['rowid']); ?>
            </td>
             
            <td><?php echo $items['name']; ?></td>
             
            <td><?php echo $cur_symbol.$this->cart->format_number($items['price']); ?></td>
            <td><?php echo $cur_symbol.$this->cart->format_number($items['subtotal']); ?></td>
        </tr>
         
        <?php $i++; ?>
        <?php endforeach; ?>
         
        <tr>
            <td></td>
            <td></td>
            <td><strong>Total</strong></td>
            <td><strong><?php echo $cur_symbol.$this->cart->format_number($this->cart->total()); ?></strong></td>
        </tr>
    </tbody>
</table>
 
<p><?php echo form_submit('', 'Update your Cart');?></p><p><?php echo anchor('cart/empty_cart', 'Empty Cart', 'class="empty"');?></p>
<p><small>If the quantity is set to zero, the item will be removed from the cart.</small></p>

<?php
echo form_close();
endif;
?> 
