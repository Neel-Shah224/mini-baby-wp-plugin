<?php if(!defined('ABSPATH')) exit; ?>
<div class="cas-card"
     data-product="<?php echo esc_attr($product->get_id());?>"
     data-cart-url="<?php echo esc_url($product->add_to_cart_url()); ?>"
     data-cart-sku="<?php echo esc_attr($product->get_sku()); ?>">
<?php if(!$product->is_in_stock()):?><div class="cas-badge">OUT OF STOCK</div><?php endif;?>
<div class="cas-image"><a href="<?php the_permalink();?>"><?php echo $product->get_image('woocommerce_thumbnail');?></a></div>
<div class="cas-title"><?php the_title();?></div>
<div class="cas-price"><?php echo $product->get_price_html();?></div>

<?php if($product->is_in_stock()):?>
<?php if($product->is_type('variable')):?>
<a class="cas-btn view" href="<?php the_permalink();?>">View Options</a>
<?php else:?>
<div class="cas-qty">
<button type="button" class="cas-minus">-</button>
<input class="cas-qty-input" type="text" value="1">
<button type="button" class="cas-plus">+</button>
</div>
<button type="button" class="cas-btn cas-add-cart">Add To Cart</button>
<?php endif;?>
<?php endif;?>
</div>
