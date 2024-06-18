<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Prize {

    /**
     * The single instance of the class.
     */
    protected static $_instance = null;

    /**
     * Main HBWC_Prize Instance.
     *
     * Ensures only one instance of HBWC_Prize is loaded or can be loaded.
     *
     * @return HBWC_Prize - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * HBWC_Prize Constructor.
     */
    public function __construct() {
        // Load plugin text domain.
        add_action( 'init', array( $this, 'load_textdomain' ) );

        // Enqueue scripts and styles.
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        // Include CPT and metaboxes.
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-cpt.php';
        include_once HBWC_PRIZE_PLUGIN_DIR . 'includes/class-hbwc-metaboxes.php';

        // Initialize CPT and metaboxes.
        HBWC_CPT::instance();
        HBWC_Metaboxes::instance();

        // Add template loader.
        add_filter( 'template_include', array( $this, 'load_prize_templates' ) );
    }

    /**
     * Load plugin text domain for translations.
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'hb-woocommerce-prize', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages/' );
    }

    /**
     * Enqueue plugin scripts and styles.
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'hbwc-prize-styles', plugins_url( '../assets/css/hbwc-prize-styles.css', __FILE__ ), array(), HBWC_PRIZE_VERSION );
        wp_enqueue_script( 'hbwc-prize-scripts', plugins_url( '../assets/js/hbwc-prize-scripts.js', __FILE__ ), array( 'jquery' ), HBWC_PRIZE_VERSION, true );
    }

    /**
     * Load custom archive template for Prize post type.
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

?>
