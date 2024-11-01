<?php
/**
* Plugin Name: TMD AFF
* Plugin URI: http://tmduc.com/
* Description: This plugin for aff amazon niche.
* Version: 1.2.0
* Author: keyduc
* Author URI: http://tmduc.com/
* License: GPL2
*/

function TMD_styles_with_the_lot()
{
    wp_register_style( 'custom-style', plugins_url( '/css/style.css', __FILE__ ), array(), '20120208', 'all' );
    wp_enqueue_style( 'custom-style' );
}
add_action( 'wp_enqueue_scripts', 'TMD_styles_with_the_lot' );


//reg css js for admin edit page
function tmd_my_enqueue($hook) {
  global $pagenow;
  if (! empty($pagenow) && ('post-new.php' === $pagenow || 'post.php' === $pagenow ))
      add_action('admin_enqueue_scripts', 'enqueue_my_scripts');
      wp_enqueue_script( 'tmd-ajax-call', plugin_dir_url( __FILE__ ) . 'js/ajax-call.js' );
}
add_action( 'admin_enqueue_scripts', 'tmd_my_enqueue' );


//reg ajax
function sb_admin_style_and_script() {
    wp_enqueue_script('sb-admin', '/js/sb-admin-script.js', array('jquery'), false, true);
    wp_localize_script('sb-admin', 'sb_admin_ajax', array('url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'sb_admin_style_and_script');


// Load Plugin Notice
require_once (dirname(__FILE__) . '/inc/notice.php');

// Load Plugin Option
require_once (dirname(__FILE__) . '/inc/options.php');

// Load Meta Box
require_once (dirname(__FILE__) . '/inc/meta-box.php');

// Load Info To Meta Box
require_once (dirname(__FILE__) . '/inc/ajax-call.php');

// Products Info
require_once (dirname(__FILE__) . '/inc/products.php');

?>