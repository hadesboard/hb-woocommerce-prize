<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_CPT {

    public function __construct() {
        add_action( 'init', array( $this, 'register_prize_cpt' ) );
        add_action( 'init', array( $this, 'register_prize_order_cpt' ) );
    }

    public function register_prize_cpt() {
        $labels = array(
            'name'                  => _x( 'Prizes', 'Post type general name', 'hb-woocommerce-prize' ),
            'singular_name'         => _x( 'Prize', 'Post type singular name', 'hb-woocommerce-prize' ),
            'menu_name'             => _x( 'Prizes', 'Admin Menu text', 'hb-woocommerce-prize' ),
            'name_admin_bar'        => _x( 'Prize', 'Add New on Toolbar', 'hb-woocommerce-prize' ),
            'add_new'               => __( 'Add New', 'hb-woocommerce-prize' ),
            'add_new_item'          => __( 'Add New Prize', 'hb-woocommerce-prize' ),
            'new_item'              => __( 'New Prize', 'hb-woocommerce-prize' ),
            'edit_item'             => __( 'Edit Prize', 'hb-woocommerce-prize' ),
            'view_item'             => __( 'View Prize', 'hb-woocommerce-prize' ),
            'all_items'             => __( 'All Prizes', 'hb-woocommerce-prize' ),
            'search_items'          => __( 'Search Prizes', 'hb-woocommerce-prize' ),
            'parent_item_colon'     => __( 'Parent Prizes:', 'hb-woocommerce-prize' ),
            'not_found'             => __( 'No prizes found.', 'hb-woocommerce-prize' ),
            'not_found_in_trash'    => __( 'No prizes found in Trash.', 'hb-woocommerce-prize' ),
            'featured_image'        => _x( 'Prize Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'archives'              => _x( 'Prize archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'hb-woocommerce-prize' ),
            'insert_into_item'      => _x( 'Insert into prize', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'hb-woocommerce-prize' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this prize', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'hb-woocommerce-prize' ),
            'filter_items_list'     => _x( 'Filter prizes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'hb-woocommerce-prize' ),
            'items_list_navigation' => _x( 'Prizes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'hb-woocommerce-prize' ),
            'items_list'            => _x( 'Prizes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'hb-woocommerce-prize' ),
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
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-awards',
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
        );

        register_post_type( 'prize', $args );
    }

    public function register_prize_order_cpt() {
        $labels = array(
            'name'                  => _x( 'Prize Orders', 'Post type general name', 'hb-woocommerce-prize' ),
            'singular_name'         => _x( 'Prize Order', 'Post type singular name', 'hb-woocommerce-prize' ),
            'menu_name'             => _x( 'Prize Orders', 'Admin Menu text', 'hb-woocommerce-prize' ),
            'name_admin_bar'        => _x( 'Prize Order', 'Add New on Toolbar', 'hb-woocommerce-prize' ),
            'add_new'               => __( 'Add New', 'hb-woocommerce-prize' ),
            'add_new_item'          => __( 'Add New Prize Order', 'hb-woocommerce-prize' ),
            'new_item'              => __( 'New Prize Order', 'hb-woocommerce-prize' ),
            'edit_item'             => __( 'Edit Prize Order', 'hb-woocommerce-prize' ),
            'view_item'             => __( 'View Prize Order', 'hb-woocommerce-prize' ),
            'all_items'             => __( 'Prize Orders', 'hb-woocommerce-prize' ),
            'search_items'          => __( 'Search Prize Orders', 'hb-woocommerce-prize' ),
            'parent_item_colon'     => __( 'Parent Prize Orders:', 'hb-woocommerce-prize' ),
            'not_found'             => __( 'No prize orders found.', 'hb-woocommerce-prize' ),
            'not_found_in_trash'    => __( 'No prize orders found in Trash.', 'hb-woocommerce-prize' ),
            'featured_image'        => _x( 'Prize Order Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'hb-woocommerce-prize' ),
            'archives'              => _x( 'Prize Order archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'hb-woocommerce-prize' ),
            'insert_into_item'      => _x( 'Insert into prize order', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'hb-woocommerce-prize' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this prize order', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'hb-woocommerce-prize' ),
            'filter_items_list'     => _x( 'Filter prize orders list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'hb-woocommerce-prize' ),
            'items_list_navigation' => _x( 'Prize orders list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'hb-woocommerce-prize' ),
            'items_list'            => _x( 'Prize orders list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”. Added in 4.4', 'hb-woocommerce-prize' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => 'edit.php?post_type=prize', // Adds under prize post type
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'prize-order' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-clipboard',
            'supports'           => array( 'title' ),
        );

        register_post_type( 'prize-order', $args );
    }
}
?>
