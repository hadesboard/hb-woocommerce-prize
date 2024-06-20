<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_User_Meta {

    public function __construct() {
        add_action( 'show_user_profile', array( $this, 'add_user_score_field' ) );
        add_action( 'edit_user_profile', array( $this, 'add_user_score_field' ) );
        add_action( 'personal_options_update', array( $this, 'save_user_score_field' ) );
        add_action( 'edit_user_profile_update', array( $this, 'save_user_score_field' ) );
    }

    public function add_user_score_field( $user ) {
        ?>
        <h3><?php _e( 'User Score', 'hb-woocommerce-prize' ); ?></h3>
        <table class="form-table">
            <tr>
                <th><label for="user_score"><?php _e( 'Score', 'hb-woocommerce-prize' ); ?></label></th>
                <td>
                    <input type="number" name="user_score" id="user_score" value="<?php echo esc_attr( get_user_meta( $user->ID, 'user_score', true ) ); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
        <?php
    }

    public function save_user_score_field( $user_id ) {
        if ( ! current_user_can( 'edit_user', $user_id ) ) {
            return false;
        }
        update_user_meta( $user_id, 'user_score', intval( $_POST['user_score'] ) );
    }
}