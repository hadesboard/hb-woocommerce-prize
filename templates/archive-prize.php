<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<div class="hbwc-prizes-archive">
    <div class="hbwc-container">
        <div class="hbwc-row">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="hbwc-col-3">
                        <div class="hbwc-prize-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="hbwc-prize-image">
                                        <?php the_post_thumbnail( 'medium' ); ?>
                                    </div>
                                <?php endif; ?>
                                <h2 class="hbwc-prize-title"><?php the_title(); ?></h2>
                            </a>
                            <div class="hbwc-prize-score">
                                <?php echo get_post_meta( get_the_ID(), '_prize_score', true ) . ' ' . __('Score', 'hb-woocommerce-prize'); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php esc_html_e( 'No prizes found.', 'hb-woocommerce-prize' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
