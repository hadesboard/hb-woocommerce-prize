<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Prize_Orders {

    public function __construct() {
        add_filter( 'manage_prize-order_posts_columns', array( $this, 'set_custom_columns' ) );
        add_action( 'manage_prize-order_posts_custom_column', array( $this, 'custom_column_content' ), 10, 2 );
    }

    public function set_custom_columns( $columns ) {
        // Remove the date column
        $date = $columns['date'];
        unset( $columns['date'] );

        // Add custom columns
        $columns['username'] = __( 'Username', 'hb-woocommerce-prize' );
        $columns['status'] = __( 'Status', 'hb-woocommerce-prize' );

        // Add the date column back at the end
        $columns['date'] = $date;

        return $columns;
    }

    public function custom_column_content( $column, $post_id ) {
        switch ( $column ) {
            case 'username':
                $user_id = get_post_meta( $post_id, '_user_id', true );
                $user_info = get_userdata( $user_id );
                if ( $user_info ) {
                    $user_edit_link = get_edit_user_link( $user_id );
                    echo '<a href="' . esc_url( $user_edit_link ) . '">' . esc_html( $user_info->user_login ) . '</a>';
                } else {
                    echo __( 'Unknown', 'hb-woocommerce-prize' );
                }
                break;
            case 'status':
                $status = get_post_meta( $post_id, '_prize_order_status', true );
                echo esc_html( $status );
                break;
        }
    }
}
?>
