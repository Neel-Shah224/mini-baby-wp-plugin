<?php

if (!defined('ABSPATH')) {
    exit;
}
$type=$product->get_type();
$stock=$product->is_in_stock();

?>

<div class="cas-card">
    
<?php if(!$stock): ?><div class="cas-badge">OUT OF STOCK</div><?php endif; ?>
<div class="cas-image"><a href="<?php the_permalink();?>"><?php echo $product->get_image('woocommerce_thumbnail');?></a></div>
<div class="cas-title"><?php the_title();?></div>
<div class="cas-price"><?php echo $product->get_price_html();?></div>

<?php if($stock): ?>
<?php if($product->is_type('variable')): ?>
<a class="cas-btn view" href="<?php the_permalink();?>">View Options</a>
<?php else: ?>
<div class="cas-qty">
<button type="button" class="cas-minus">-</button>
<input type="text" value="1">
<button type="button" class="cas-plus">+</button>
</div>
<button type="button" class="cas-btn">Add To Cart</button>
<?php endif; ?>
<?php endif; ?>
</div>
