<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<ul class="review-results">
<a href="<?php esc_url( the_permalink())?>" class="view-result">Read Review</a>
<?php 
    the_title( sprintf( '<li><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); 
    echo '<br />', post_custom('cf_review_title'), '<br /> ', get_the_date();
    if (post_custom('cf_overall') != null)
        echo ' ';
        for ($i = 0; $i < post_custom('cf_overall'); $i++) {
            echo '&#9733;';
        }
    echo '</li>';
    
?>
</ul>
<!-- #post-## -->
