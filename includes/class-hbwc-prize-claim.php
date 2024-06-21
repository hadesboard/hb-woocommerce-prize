<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Prize_Claim {

    public function __construct() {
        add_action( 'init', array( $this, 'handle_prize_claim' ) );
    }

    public function handle_prize_claim() {
        if ( isset( $_POST['action'] ) && $_POST['action'] == 'claim_prize' && isset( $_POST['prize_id'] )
             && isset( $_POST['claim_prize_nonce'] ) && wp_verify_nonce( $_POST['claim_prize_nonce'], 'claim_prize_action' ) ) {

            $prize_id = intval( $_POST['prize_id'] );
            $user_id = get_current_user_id();

            if ( $this->user_can_claim_prize( $user_id, $prize_id ) ) {
                $this->create_prize_order( $user_id, $prize_id );
                $this->redirect_to_thank_you_page();
            } else {
                // Add an error message or redirect to an error page
            }
        }
    }

    private function user_can_claim_prize( $user_id, $prize_id ) {
        $user_score = get_user_meta( $user_id, 'user_score', true );
        $prize_score = get_post_meta( $prize_id, '_prize_score', true );

        return $user_score >= $prize_score;
    }

    private function create_prize_order( $user_id, $prize_id ) {
        $user = get_userdata( $user_id );
        $prize = get_post( $prize_id );

        $order_data = array(
            'post_title'   => $prize->post_title,
            'post_content' => '',
            'post_status'  => 'publish',
            'post_author'  => $user_id,
            'post_type'    => 'prize-order',
        );

        $order_id = wp_insert_post( $order_data );

        if ( $order_id ) {
            update_post_meta( $order_id, '_prize_id', $prize_id );
            update_post_meta( $order_id, '_user_id', $user_id );
            update_post_meta( $order_id, '_prize_order_status', 'in_progress' );
            
            // Add the user's nickname if it exists, otherwise use the username
            $nickname = get_user_meta( $user_id, 'nickname', true );
            $username = $user->user_login;
            $name_to_use = !empty( $nickname ) ? $nickname : $username;
            update_post_meta( $order_id, '_user_nickname_or_username', $name_to_use );

            // Optionally reduce the user's score
            $user_score = get_user_meta( $user_id, 'user_score', true );
            $prize_score = get_post_meta( $prize_id, '_prize_score', true );
            update_user_meta( $user_id, 'user_score', $user_score - $prize_score );
        }
    }

    private function redirect_to_thank_you_page() {
        wp_redirect( home_url( '/thank-you' ) );
        exit;
    }
}
?>
