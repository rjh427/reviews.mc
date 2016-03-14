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
    $title = substr(get_the_title(), 0, strrpos(get_the_title(), ' '));
    echo '<li><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>';
    echo '<br />', post_custom('review_title'), '<br /> ', get_the_date();
    if (post_custom('overall') != null)
        echo ' ';
        for ($i = 0; $i < post_custom('overall'); $i++) {
            echo '&#9733;';
        }
    echo '</li>';

?>
</ul>
<!-- #post-## -->