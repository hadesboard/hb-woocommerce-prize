<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Prize {

    public function __construct() {
        // Load plugin text domain
        add_action( 'init', array( $this, 'load_textdomain' ) );

        // Enqueue scripts and styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // Includes
        $this->includes();

        // Add template loader.
        add_filter( 'template_include', array( $this, 'load_prize_templates' ) );
    }

    public function load_textdomain() {
        load_plugin_textdomain( 'hb-woocommerce-prize', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'hbwc-prize-styles', HBWC_PRIZE_PLUGIN_URI . 'assets/css/hbwc-prize-styles.css', array(), HBWC_PRIZE_VERSION );
        wp_enqueue_script( 'hbwc-prize-scripts', HBWC_PRIZE_PLUGIN_URI . 'assets/js/hbwc-prize-scripts.js', array( 'jquery' ), HBWC_PRIZE_VERSION, true );
        wp_localize_script( 'hbwc-prize-scripts', 'hbwc_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function includes() {
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-cpt.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-metaboxes.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-user-meta.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-order-handler.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-settings.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-prize-claim.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-account-tab.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-prize-orders.php';

        // Instantiate classes
        new HBWC_CPT();
        new HBWC_Metaboxes();
        new HBWC_User_Meta();
        new HBWC_Order_Handler();
        new HBWC_Settings();
        new HBWC_Prize_Claim();
        new HBWC_Account_Tab();
        new HBWC_Prize_Orders();
    }

    /**
     * Load custom templates for Prize post type.
     */
    public function load_prize_templates( $template ) {
        if ( is_singular( 'prize' ) ) {
            $template = HBWC_PRIZE_PLUGIN_DIR . 'templates/single-prize.php';
        } elseif ( is_post_type_archive( 'prize' ) ) {
            $template = HBWC_PRIZE_PLUGIN_DIR . 'templates/archive-prize.php';
        }
        return $template;
    }
    
}
