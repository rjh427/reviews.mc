<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<?php
	// Post thumbnail.
	twentyfifteen_post_thumbnail();
?>
<?php
    if ( !is_single() ) {
	    echo '<div class="entry-content hentry">';
//	    the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' );
//	    echo ': ' . post_custom('review_title'), ', ', get_the_date();
//      if (post_custom('overall') != null)
//          echo ', ', post_custom('overall') . ' Stars';
        ?>
        <ul class="review-results">
            <a href="<?php esc_url( the_permalink())?>" class="view-result">Read Review</a>
            <?php 
                the_title( sprintf( '<li><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); 
                echo '<br />', post_custom('cf_review_title'), '<br /> ', get_the_date();
                if (post_custom('overall') != null)
                    echo ' ';
                    for ($i = 0; $i < post_custom('cf_overall'); $i++) {
                        echo '&#9733;';
                    }
                echo '</li>';
            ?>
        </ul>
        <?php
	    echo '</div>';
    }

        if ( is_single() ) {?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php }?>

	<?php
		if ( is_single() ) :
    	    echo '<header class="entry-header">';
			the_title( '<h1 class="entry-title">', ' Review</h1>' );
			echo "Review Title: <strong>" . post_custom('cf_review_title') . "</strong>";
			echo '</header><!-- .entry-header -->';

            echo '<div class="entry-content post type-post format-standard hentry">';

		    /* translators: %s: Name of current post */
		    the_content( sprintf(
			    __( 'Continue reading %s', 'twentyfifteen' ),
			    the_title( '<span class="screen-reader-text">', '</span>', false )
		    ) );

		    wp_link_pages( array(
			    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
			    'after'       => '</div>',
			    'link_before' => '<span>',
			    'link_after'  => '</span>',
			    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
			    'separator'   => '<span class="screen-reader-text">, </span>',
		    ) );
	    ?>
	    </div><!-- .entry-content -->

	    <?php
		    // Author bio.
//		    if ( is_single() && get_the_author_meta( 'description' ) ) :
//			    get_template_part( 'author-bio' );
//		    endif;
	    ?>

	    <footer class="entry-footer">
		    <?php twentyfifteen_entry_meta(); ?>
		    <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	    </footer><!-- .entry-footer -->

    </article><!-- #post-## -->
    <?php		
		endif;
	?>


