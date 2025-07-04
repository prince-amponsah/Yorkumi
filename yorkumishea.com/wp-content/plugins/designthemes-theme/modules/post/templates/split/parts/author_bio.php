<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php if( '' != get_the_author_meta('description') ) : ?>
    <!-- Entry Author Bio -->
    <div class="entry-author-bio">
        <div class="thumb">
            <?php echo get_avatar(get_the_author_meta('ID'), 110 );?>
        </div>

        <div class="details">
            <h3>
                <span><?php esc_html_e('About Author', 'designthemes-theme'); ?></span>
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a>
            </h3>
            <div class="desc"><?php echo nl2br( get_the_author_meta('description') ); ?></div>
        </div>
    </div><!-- Entry Author Bio -->
<?php endif; ?>