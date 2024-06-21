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
            __( 'Prize Order Details', 'hb-woocommerce-prize' ),
            array( $this, 'render_prize_order_meta_box' ),
            'prize-order',
            'normal',
            'high'
        );
    }

    public function render_prize_order_meta_box( $post ) {
        wp_nonce_field( 'hbwc_save_prize_order_meta', 'hbwc_prize_order_meta_nonce' );

        $status = get_post_meta( $post->ID, '_prize_order_status', true );
        $prize_id = get_post_meta( $post->ID, '_prize_id', true );
        $user_id = get_post_meta( $post->ID, '_user_id', true );
        $nickname_or_username = get_post_meta( $post->ID, '_user_nickname_or_username', true );

        $prize_post = get_post($prize_id);
        $prize_title = $prize_post ? get_the_title($prize_post) : '';
        $prize_edit_link = $prize_post ? get_edit_post_link($prize_post) : '';
        $user_edit_link = get_edit_user_link($user_id);

        ?>
        <p>
            <label for="prize_order_status"><strong><?php _e( 'Status', 'hb-woocommerce-prize' ); ?>:</strong></label>
            <select name="prize_order_status" id="prize_order_status">
                <option value="in_progress" <?php selected( $status, 'in_progress' ); ?>><?php _e( 'In Progress', 'hb-woocommerce-prize' ); ?></option>
                <option value="completed" <?php selected( $status, 'completed' ); ?>><?php _e( 'Completed', 'hb-woocommerce-prize' ); ?></option>
                <option value="canceled" <?php selected( $status, 'canceled' ); ?>><?php _e( 'Canceled', 'hb-woocommerce-prize' ); ?></option>
            </select>
        </p>
        <p>
            <strong><?php _e( 'Prize', 'hb-woocommerce-prize' ); ?>:</strong>
            <?php if ( $prize_edit_link ): ?>
                <a href="<?php echo esc_url( $prize_edit_link ); ?>"><?php echo esc_html( $prize_title ); ?></a>
            <?php else: ?>
                <?php echo esc_html( $prize_title ); ?>
            <?php endif; ?>
        </p>
        <p>
            <strong><?php _e( 'User Nickname/Username', 'hb-woocommerce-prize' ); ?>:</strong>
            <a href="<?php echo esc_url( $user_edit_link ); ?>"><?php echo esc_html( $nickname_or_username ); ?></a>
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
?>
