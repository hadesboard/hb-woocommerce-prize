<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_CPT {

    /**
     * The single instance of the class.
     */
    protected static $_instance = null;

    /**
     * Main HBWC_CPT Instance.
     *
     * Ensures only one instance of HBWC_CPT is loaded or can be loaded.
     *
     * @return HBWC_CPT - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * HBWC_CPT Constructor.
     */
    public function __construct() {
        // Register the custom post type.
        add_action( 'init', array( $this, 'register_prize_cpt' ) );
    }

    /**
     * Register the custom post type.
     */
    public function register_prize_cpt() {
        $labels = array(
            'name'               => _x( 'Prizes', 'post type general name', 'hb-woocommerce-prize' ),
            'singular_name'      => _x( 'Prize', 'post type singular name', 'hb-woocommerce-prize' ),
            'menu_name'          => _x( 'Prizes', 'admin menu', 'hb-woocommerce-prize' ),
            'name_admin_bar'     => _x( 'Prize', 'add new on admin bar', 'hb-woocommerce-prize' ),
            'add_new'            => _x( 'Add New', 'prize', 'hb-woocommerce-prize' ),
            'add_new_item'       => __( 'Add New Prize', 'hb-woocommerce-prize' ),
            'new_item'           => __( 'New Prize', 'hb-woocommerce-prize' ),
            'edit_item'          => __( 'Edit Prize', 'hb-woocommerce-prize' ),
            'view_item'          => __( 'View Prize', 'hb-woocommerce-prize' ),
            'all_items'          => __( 'All Prizes', 'hb-woocommerce-prize' ),
            'search_items'       => __( 'Search Prizes', 'hb-woocommerce-prize' ),
            'parent_item_colon'  => __( 'Parent Prizes:', 'hb-woocommerce-prize' ),
            'not_found'          => __( 'No prizes found.', 'hb-woocommerce-prize' ),
            'not_found_in_trash' => __( 'No prizes found in Trash.', 'hb-woocommerce-prize' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'prize' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
        );

        register_post_type( 'prize', $args );
    }
}

?>
