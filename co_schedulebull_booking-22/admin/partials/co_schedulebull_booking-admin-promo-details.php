<?php 
	$promo_code = get_post_meta( $_GET['post'], 'cos_promo_code', true); 
	$promo_type = get_post_meta( $_GET['post'], 'cos_promo_type', true); 
	$promo_amount = get_post_meta( $_GET['post'], 'cos_promo_amount', true);
?>
<div class="cos-promo-meta-main">
	<div class="cos-meta_field">
		<label>Code</label>
		<input class="cos_promo_code" name="cos_promo_code" type="text" value="<?php echo ($promo_code)?$promo_code:''; ?>">
	</div>
	<div class="cos-meta_field">
		<label>Type</label>
		<select class="cos_promo_type" name="cos_promo_type">
			<option value="Flat" <?php echo ($promo_type == 'Flat')?'selected':''; ?>>Flat</option>
			<option value="Precentage" <?php echo ($promo_type == 'Precentage')?'selected':''; ?>>Precentage</option>
		</select>
	</div>
	
	<div class="cos-meta_field">
		<label>Amount</label>
		<input class="cos_promo_amount" name="cos_promo_amount" type="number" min="0" step=".01" value="<?php echo ($promo_amount)?$promo_amount:0; ?>">
	</div>
</div>