<?php
get_header();

while ( have_posts() ) : the_post();
    $prize_score = get_post_meta( get_the_ID(), '_prize_score', true );
    $user_id = get_current_user_id();
    $user_score = get_user_meta( $user_id, 'user_score', true );
    $can_claim = $user_score >= $prize_score;
    ?>
    <div id="prize-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="prize-details">
            <div class="prize-description">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <p><strong><?php _e( 'Prize Score:', 'hb-woocommerce-prize' ); ?></strong> <?php echo esc_html( $prize_score ); ?></p>
                <?php if ( $can_claim ) : ?>
                    <form method="post" action="">
                        <input type="hidden" name="prize_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
                        <input type="hidden" name="action" value="claim_prize">
                        <?php wp_nonce_field( 'claim_prize_action', 'claim_prize_nonce' ); ?>
                        <input type="submit" class="btn-claim-prize" value="<?php _e( 'Get Prize', 'hb-woocommerce-prize' ); ?>">
                    </form>
                <?php else : ?>
                    <p><?php _e( 'You do not have enough score to claim this prize.', 'hb-woocommerce-prize' ); ?></p>
                <?php endif; ?>
            </div>
            <div class="prize-image">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
endwhile;

get_footer();
