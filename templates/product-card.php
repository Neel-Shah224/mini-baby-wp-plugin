 <?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="cas-card">

    <a href="<?php echo esc_url(get_permalink()); ?>">

        <?php echo $product->get_image('woocommerce_thumbnail'); ?>

    </a>

    <h3 class="cas-title">

        <?php echo esc_html(get_the_title()); ?>

    </h3>

    <div class="cas-price">

        <?php echo $product->get_price_html(); ?>

    </div>

</div> 

