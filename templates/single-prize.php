<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<div class="hbwc-prize-single">
    <div class="hbwc-container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="hbwc-prize-content">
                <div class="hbwc-prize-info">
                    <h1 class="hbwc-prize-title"><?php the_title(); ?></h1>
                    <div class="hbwc-prize-score">
                        <?php esc_html_e( 'Score Needed: ', 'hb-woocommerce-prize' ); ?><?php echo get_post_meta( get_the_ID(), '_prize_score', true ); ?>
                    </div>
                    <div class="hbwc-prize-description">
                        <?php the_content(); ?>
                    </div>
                    <a href="#" class="hbwc-get-prize" data-prize-id="<?php the_ID(); ?>"><?php esc_html_e( 'Get Prize', 'hb-woocommerce-prize' ); ?></a>
                </div>
                <div class="hbwc-prize-image">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'large' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<?php get_footer(); ?>
