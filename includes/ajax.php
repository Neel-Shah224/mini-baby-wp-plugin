<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_cas_load_products', 'cas_load_products');
add_action('wp_ajax_nopriv_cas_load_products', 'cas_load_products');

function cas_load_products()
{
    check_ajax_referer('cas_nonce', 'nonce');

    $category = '';

    if (!empty($_POST['category'])) {
        $category = sanitize_text_field($_POST['category']);
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 12,
        'post_status' => 'publish'
    );

    if (!empty($category) && $category != 'all') {

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category
            )
        );

    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {

        echo '<div class="cas-grid">';

        while ($query->have_posts()) {

            $query->the_post();

            $product = wc_get_product(get_the_ID());

            include CAS_PLUGIN_PATH . 'templates/product-card.php';

        }

        echo '</div>';

    } else {

        echo '<div class="cas-no-products">No Products Found</div>';

    }

    wp_reset_postdata();

    wp_send_json_success(array(
        'html' => ob_get_clean()
    ));

}