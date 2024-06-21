<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Metaboxes {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_prize_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_prize_meta_boxes' ) );

        // Add metabox for prize-order
        add_action( 'add_meta_boxes', array( $this, 'add_prize_order_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_prize_order_meta_box' ) );
    }

    public function add_prize_meta_boxes() {
        add_meta_box(
            'hbwc_prize_details',
            __( 'Prize Details', 'hb-woocommerce-prize' ),
            array( $this, 'render_prize_meta_box' ),
            'prize',
            'normal',
            'high'
        );
    }

    public function render_prize_meta_box( $post ) {
        wp_nonce_field( 'hbwc_save_prize_meta', 'hbwc_prize_meta_nonce' );

        $prize_score = get_post_meta( $post->ID, '_prize_score', true );
        ?>
        <p>
            <label for="prize_score"><?php _e( 'Prize Score', 'hb-woocommerce-prize' ); ?></label>
            <input type="number" name="prize_score" id="prize_score" value="<?php echo esc_attr( $prize_score ); ?>" />
        </p>
        <?php
    }

    public function save_prize_meta_boxes( $post_id ) {
        if ( ! isset( $_POST['hbwc_prize_meta_nonce'] ) || ! wp_verify_nonce( $_POST['hbwc_prize_meta_nonce'], 'hbwc_save_prize_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['prize_score'] ) ) {
            update_post_meta( $post_id, '_prize_score', sanitize_text_field( $_POST['prize_score'] ) );
        }
    }

    public function add_prize_order_meta_box() {
        add_meta_box(
            'hbwc_prize_order_status',
            __( 'Prize Order Status', 'hb-woocommerce-prize' ),
            array( $this, 'render_prize_order_meta_box' ),
            'prize-order',
            'normal',
            'high'
        );
    }

    public function render_prize_order_meta_box( $post ) {
        wp_nonce_field( 'hbwc_save_prize_order_meta', 'hbwc_prize_order_meta_nonce' );

        $status = get_post_meta( $post->ID, '_prize_order_status', true );
        ?>
        <p>
            <label for="prize_order_status"><?php _e( 'Status', 'hb-woocommerce-prize' ); ?></label>
            <select name="prize_order_status" id="prize_order_status">
                <option value="in_progress" <?php selected( $status, 'in_progress' ); ?>><?php _e( 'In Progress', 'hb-woocommerce-prize' ); ?></option>
                <option value="completed" <?php selected( $status, 'completed' ); ?>><?php _e( 'Completed', 'hb-woocommerce-prize' ); ?></option>
                <option value="canceled" <?php selected( $status, 'canceled' ); ?>><?php _e( 'Canceled', 'hb-woocommerce-prize' ); ?></option>
            </select>
        </p>
        <?php
    }

    public function save_prize_order_meta_box( $post_id ) {
        if ( ! isset( $_POST['hbwc_prize_order_meta_nonce'] ) || ! wp_verify_nonce( $_POST['hbwc_prize_order_meta_nonce'], 'hbwc_save_prize_order_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST['prize_order_status'] ) ) {
            update_post_meta( $post_id, '_prize_order_status', sanitize_text_field( $_POST['prize_order_status'] ) );
        }
    }
}

new HBWC_Metaboxes();
