<h3>PRODUCTS</h3>
<div>
<ul class="products">
    <?php foreach($products as $p): ?>
    <li>
        <h3><?php echo $p['name']; ?></h3>
        <img src="assets/img/products/<?php echo $p['image']; ?>" alt="" height="60" width="80"/>
        <small><?php echo $cur_symbol.$p['price']; ?></small>
        <?php echo form_open('cart/add_cart_item'); ?>
            <fieldset>
                <label>Quantity</label>
                <?php echo form_input('quantity', '1', 'maxlength="2"'); ?>
                <?php echo form_hidden('product_id', $p['id']); ?>
                <?php echo form_submit('add', 'Add'); ?>
            </fieldset>
        <?php echo form_close(); ?>
    </li>
    <?php endforeach;?>
</ul>
</div>
<div style="clear:both" ></div>