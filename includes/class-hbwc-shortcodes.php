<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Shortcodes {

    public function __construct() {
        add_shortcode( 'hbwc_thank_you_message', array( $this, 'thank_you_message_shortcode' ) );
    }

    public function thank_you_message_shortcode() {
        $user_id = get_current_user_id();
        $user_score = get_user_meta( $user_id, 'user_score', true );
        ob_start();
        ?>
        <div class="hbwc-thank-you-message">
            <h1><?php _e( 'Thank You!', 'hb-woocommerce-prize' ); ?></h1>
            <p><?php _e( 'You have successfully claimed this prize.', 'hb-woocommerce-prize' ); ?></p>
            <p><strong><?php _e( 'Your remaining score:', 'hb-woocommerce-prize' ); ?></strong> <?php echo esc_html( $user_score ); ?></p>
            <p><a class="hbwc-back-link" href="<?php echo esc_url( home_url( '/prize' ) ); ?>"><?php _e( 'Back to Prize Category', 'hb-woocommerce-prize' ); ?></a></p>
        </div>
        <?php
        return ob_get_clean();
    }
}
?>
