<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Prize_Claim {

    public function __construct() {
        add_action( 'wp_ajax_hbwc_claim_prize', array( $this, 'handle_prize_claim' ) );
        add_action( 'wp_ajax_nopriv_hbwc_claim_prize', array( $this, 'handle_prize_claim' ) );
    }

    public function handle_prize_claim() {
        $user_id = get_current_user_id();
        $prize_id = intval( $_POST['prize_id'] );

        if ( ! $user_id || ! $prize_id ) {
            wp_send_json_error( 'Invalid request' );
        }

        $user_score = get_user_meta( $user_id, 'user_score', true );
        $prize_score = get_post_meta( $prize_id, '_prize_score', true );

        if ( $user_score >= $prize_score ) {
            $new_score = $user_score - $prize_score;
            update_user_meta( $user_id, 'user_score', $new_score );

            // Log prize claim
            add_post_meta( $prize_id, '_claimed_by', $user_id );

            wp_send_json_success( 'Prize claimed successfully!' );
        } else {
            wp_send_json_error( 'Not enough score to claim the prize.' );
        }
    }
}