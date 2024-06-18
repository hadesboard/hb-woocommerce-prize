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

// Define plugin constants.
define( 'HBWC_PRIZE_VERSION', '1.0.0' );
define( 'HBWC_PRIZE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Include the main class file.
include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-prize.php';

// Initialize the plugin.
function hbwc_prize_init() {
    return HBWC_Prize::instance();
}

// Hook into plugins_loaded to initialize the plugin.
add_action( 'plugins_loaded', 'hbwc_prize_init' );

?>

