<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class HBWC_Metaboxes {

    /**
     * The single instance of the class.
     */
    protected static $_instance = null;

    /**
     * Main HBWC_Metaboxes Instance.
     *
     * Ensures only one instance of HBWC_Metaboxes is loaded or can be loaded.
     *
     * @return HBWC_Metaboxes - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * HBWC_Metaboxes Constructor.
     */
    public function __construct() {
        // Add metaboxes.
        add_action( 'add_meta_boxes', array( $this, 'add_metaboxes' ) );
        // Save metaboxes.
        add_action( 'save_post', array( $this, 'save_metaboxes' ) );
    }

    /**
     * Add custom metaboxes.
     */
    public function add_metaboxes() {
        add_meta_box(
            'hbwc_prize_score',
            __( 'Prize Score', 'hb-woocommerce-prize' ),
            array( $this, 'render_metabox' ),
            'prize',
            'side',
            'high'
        );
    }

    /**
     * Render the metabox.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'hbwc_prize_nonce_action', 'hbwc_prize_nonce' );

        // Retrieve existing value from the database.
        $prize_score = get_post_meta( $post->ID, '_prize_score', true );

        ?>
        <p>
            <label for="prize_score"><?php _e( 'Prize Score', 'hb-woocommerce-prize' ); ?></label>
            <input type="number" name="prize_score" id="prize_score" value="<?php echo esc_attr( $prize_score ); ?>" class="widefat">
        </p>
        <?php
    }

    /**
     * Save metaboxes.
     */
    public function save_metaboxes( $post_id ) {
        // Check if nonce is set.
        if ( ! isset( $_POST['hbwc_prize_nonce'] ) ) {
            return $post_id;
        }

        $nonce = $_POST['hbwc_prize_nonce'];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'hbwc_prize_nonce_action' ) ) {
            return $post_id;
        }

        // Check if this is an autosave.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'prize' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        // Sanitize user input.
        $prize_score = sanitize_text_field( $_POST['prize_score'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_prize_score', $prize_score );
    }
}

?>
