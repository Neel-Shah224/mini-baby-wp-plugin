<?php
/*
Plugin Name: Custom AJAX Shop
Description: AJAX Category Filter + Product Grid
Version: 1.0.0
Author: Neel Shah
*/

if (!defined('ABSPATH')) {
    exit;
}

define('CAS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CAS_PLUGIN_PATH', plugin_dir_path(__FILE__));

require_once CAS_PLUGIN_PATH . 'includes/ajax.php';

function cas_enqueue_assets()
{
   wp_enqueue_style(
        'cas-style',
        CAS_PLUGIN_URL . 'assets/style.css',
        [],
        filemtime(CAS_PLUGIN_PATH . 'assets/style.css')
    );

    wp_enqueue_script(
        'cas-script',
        CAS_PLUGIN_URL . 'assets/script.js',
        ['jquery'],
        filemtime(CAS_PLUGIN_PATH . 'assets/script.js'),
        true
    );

    if (function_exists('wc')) {

        wp_enqueue_script('wc-add-to-cart');

        wp_enqueue_script('wc-cart-fragments');

    }

    wp_localize_script(
        'cas-script',
        'cas_ajax',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cas_nonce')
        ]
    );
}

add_action('wp_enqueue_scripts', 'cas_enqueue_assets');


function cas_product_grid_shortcode()
{
    ob_start();
    ?>

    <div id="cas-product-grid">

        <div class="cas-loading">

            Loading products...

        </div>

    </div>

    <?php

    return ob_get_clean();
}

add_shortcode(
    'custom_ajax_products',
    'cas_product_grid_shortcode'
);