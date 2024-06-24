<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Settings {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
    }

    public function add_settings_page() {
        add_submenu_page(
            'woocommerce',
            __( 'Prize Settings', 'hb-woocommerce-prize' ),
            __( 'Prize Settings', 'hb-woocommerce-prize' ),
            'manage_options',
            'hbwc-prize-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'hbwc_prize_settings_group', 'hbwc_conversion_rate' );
        register_setting( 'hbwc_prize_settings_group', 'hbwc_points_per_rate' );
        register_setting( 'hbwc_prize_settings_group', 'hbwc_free_shipping_enabled' );
        register_setting( 'hbwc_prize_settings_group', 'hbwc_free_shipping_score_threshold' );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'Prize Settings', 'hb-woocommerce-prize' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'hbwc_prize_settings_group' ); ?>
                <?php do_settings_sections( 'hbwc_prize_settings_group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Conversion Rate (Toman)', 'hb-woocommerce-prize' ); ?></th>
                        <td><input type="number" name="hbwc_conversion_rate" value="<?php echo esc_attr( get_option( 'hbwc_conversion_rate', 1000000 ) ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Points per Rate', 'hb-woocommerce-prize' ); ?></th>
                        <td><input type="number" name="hbwc_points_per_rate" value="<?php echo esc_attr( get_option( 'hbwc_points_per_rate', 10 ) ); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable Free Shipping Based on Score', 'hb-woocommerce-prize' ); ?></th>
                        <td>
                            <input type="checkbox" name="hbwc_free_shipping_enabled" value="yes" <?php checked( get_option( 'hbwc_free_shipping_enabled', 'no' ), 'yes' ); ?> />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Score Threshold for Free Shipping', 'hb-woocommerce-prize' ); ?></th>
                        <td><input type="number" name="hbwc_free_shipping_score_threshold" value="<?php echo esc_attr( get_option( 'hbwc_free_shipping_score_threshold', 100 ) ); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}