<?php
/**
 * Plugin Name: HB WooCommerce Prize
 * Plugin URI:  https://hadesboard.com
 * Description: A WooCommerce extension to offer prizes.
 * Version:     1.0.0
 * Author:      Mohamad Gandomi
 * Author URI:  https://hadesboard.com
 * Text Domain: hb-woocommerce-prize
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants
define( 'HBWC_PRIZE_VERSION', '1.0.0' );
define( 'HBWC_PRIZE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HBWC_PRIZE_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

// Include the main class
include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-prize.php';

// Initialize the plugin
function hbwc_prize_init() {
    new HBWC_Prize();
    load_plugin_textdomain( 'hb-woocommerce-prize', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'hbwc_prize_init' );

?>