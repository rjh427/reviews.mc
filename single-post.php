<?php
/**
* A post template for displaying m/c reviews
*
* @package WordPress
* @subpackage Twenty_Fifteen
* @subsubpackate Reviews-Child, a child-theme of Twenty_Fifteen
* @since Twenty Fifteen 1.0
*/
/*
echo 'is_front_page: ', var_dump(is_front_page()), PHP_EOL;
echo 'is_home: ', var_dump(is_home()), PHP_EOL;
echo 'is_single: ', var_dump(is_single()), PHP_EOL;
echo 'is_page: ', var_dump(is_page()), PHP_EOL;
echo 'is_page_template: ', var_dump(is_page_template()), PHP_EOL;
echo 'is_search: ', var_dump(is_search()), PHP_EOL;
echo 'is_singular: ', var_dump(is_singular()), PHP_EOL;
echo 'in_the_loop: ', var_dump(in_the_loop()), PHP_EOL;
*/

get_header();?>

<div id="primary" class="content-area">
<main id="main" class="site-main" role="main">

<?php
// Start the loop.
while ( have_posts() ) : the_post();
/*
* Include the post format-specific template for the content. If you want to
* use this in a child theme, then include a file called called content-___.php
* (where ___ is the post format) and that will be used instead.
*/
//	get_template_part( 'content', get_post_format() );


$review = '';
// see output of var_dump($post) at bottom
global $post;
$review = '';
$upgrades = '';
$image = '';
$height = '';
$weight = '';
$milesHours = '';
$location = '';
$ctol_url = '';
$imageSubmitted = '';

$postTitle = substr(get_the_title(), 0, strrpos(get_the_title(), ' '));
$reviewTitle =  post_custom('review_title');

$make = htmlentities(post_custom('manufacturer'));
$model = htmlentities(post_custom('model'));
$overall = getRating('overall');
$overallRaw = getRatingRaw('overall');
$reliability = getRating('reliability');
$quality = getRating('quality');
$performance = getRating('performance');
$comfort = getRating('comfort');

// for PSN photos on our CDN only, WP handles uploaded photos natively
if (post_custom('user_picture_filename') != '') {
    $imageSubmitted = '<small class="review_date">Submitted ' . get_the_date('F Y') . ':</small><br />';
    $image = '<img src="' . CDN_URL . post_custom('user_picture_filename') . '" alt="User-submitted image" class="userPict" /><br /><br >';
} elseif (post_custom('usp-file-single') != '') {
    $imageSubmitted = '<small class="review_date">Submitted ' . get_the_date('F Y') . ':</small><br />';
    $image = '<img src="' .  post_custom('usp-file-single') . '" alt="User-submitted image" class="userPict" /><br /><br >';
}

if (post_custom('upgrades') != null) {
    $upgrades = '<p>Upgrades:<br />' . post_custom('upgrades') . '</p>';
}

if (post_custom('anon') == 'Y') {
    $author = '<td> Author:</td><td itemprop="author">Anonymous</td>';
} else {
    $author = '<td>Author:</td><td itemprop="author">' . post_custom('reviewer_name') . '</td>';
}

if (post_custom('height') != null) {
    $height = '<td>Height:</td><td>' . post_custom('height') . '</td>';
}

if (post_custom('weight') != null) {
    $weight = '<td>Weight:</td><td>' . post_custom('weight') . '</td>';
}

if (post_custom('miles_or_hours') != null) {
    $milesHours = '<td>Miles or hours spent on the review:</td><td>' . post_custom('miles_or_hours') . '</td>';
}

if (post_custom('location') != null) {
    $location = '<td>Location</td><td>' . post_custom('location') . '</td>';
}

// http://www.cycletrader.com/search-results?make=<url-safe-make-name>&model=<url-safe-model-name>&modelkeyword=1
// @TODO: move this into a URL-builder function
$ctol_url = 'View ' . '<a href="http://www.cycletrader.com/search-results?make=' . $make . '&model=' .
$model . '&modelkeyword=1">' . $make . ' '. $model . '</a> Motorcycles For Sale on ' .
'<a href="http://www.cycletrader.com">CycleTrader.com</a><br />';

if (post_custom('user_picture_filename') == '') {
    $dateSubmitted = '<small class="review_date">Submitted: ' . get_the_date('F, Y') . '</small>';
} else {
    $dateSubmitted = '';
}

$review = <<<EOT
<div class="entry-content hentry" itemscope itemtype="http://schema.org/Review">
    <header>
        <h1 itemprop="itemReviewed" itemscope itemtype="http://schema.org/Motorcycle" class="entry-title" itemprop="name"> <span itemprop="name"> $postTitle Review</h1>
        Review Title: <strong><span itemprop="name"> $reviewTitle </span></strong>
    </header>

    <table>
        <tbody>
            <tr><th colspan="2">Ratings</th></tr>
            <tr> $overall </tr>
            <tr colspan="2" class="hidden">
                <span class="hidden" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                    <span itemprop="ratingValue"> $overallRaw stars</span>
                </span>
            </tr>
            <tr> $reliability </tr>
            <tr> $quality </tr>
            <tr> $performance </tr>
            <tr> $comfort </tr>
        </tbody>
    </table>

    <span itemprop="reviewBody"> $post->post_content </span>
    <br />
    $imageSubmitted
    $image
    $upgrades

    <table>
        <tbody>
            <tr><th colspan="2">About the reviewer:</th></tr>
            <tr> $author  </tr>
            <tr> $height  </tr>
            <tr> $weight </tr>
            <tr> $milesHours </tr>
            <tr> $location </tr>
        </tbody>
    </table>

    $ctol_url
    $dateSubmitted

</div> <!-- .entry-content itemReviewed -->

EOT;

    echo $review;

	// Previous/next post navigation.
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentyfifteen' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
			'<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentyfifteen' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
			'<span class="post-title">%title</span>',
	) );

// End the loop.
endwhile;
?>

	</main><!-- .site-main -->
</div><!-- .content-area --><?php

get_footer();

/* Helper function for displayReviewDetails()
 * Get the post meta data for the 1-5 star ratings and return 
 *
 * @return string
 */
function getRating($param) {
    global $post;
    $str = '';
    $key = ucfirst($param);
    $value = (int)post_custom($param);

    if ($value != 0 && $value != null && $value != '' && is_int($value)) {
        $str .= '<td>' . $key . '</td><td>';
        for ($i = 0; $i < $value; $i++) {
            $str .= '&#9733; ';
        }

        $str .= '</td>';
    }

    return $str;
}


/* Helper function for microformats/schema.org
 * Get the overall rating numberical value;
 * if blank, zero or null, assume 5
 *
 * @return string
 */
function getRatingRaw($param) {
    global $post;
    $value = (int)post_custom($param);

    if ($value != 0 && $value != null && $value != '' && is_int($value)) {
        return $value;
    }

    return 5;
}


/*
the $post object contains:
    object(WP_Post)[260]
        public 'ID' => int 38591:
        public 'post_author' => string '1' (length=1)
        public 'post_date' => string '2015-02-15 20:23:00' (length=19)
        public 'post_date_gmt' => string '2015-02-15 20:23:00' (length=19)
        public 'post_content' => string '<p>I have had this bike sinc... (length=529)
        public 'post_title' => string '2015 Honda NM4 (NC700J) 74612' (length=29)
        public 'post_excerpt' => string '' (length=0)
        public 'post_status' => string 'publish' (length=7)
        public 'comment_status' => string 'open' (length=4)
        public 'ping_status' => string 'open' (length=4)
        public 'post_password' => string '' (length=0)
        public 'post_name' => string '2015-honda-nm4-nc700j-74612' (length=27)
        public 'to_ping' => string '' (length=0)
        public 'pinged' => string '' (length=0)
        public 'post_modified' => string '2015-02-15 20:23:00' (length=19)
        public 'post_modified_gmt' => string '2015-02-15 20:23:00' (length=19)
        public 'post_content_filtered' => string '' (length=0)
        public 'post_parent' => int 0
        public 'guid' => string 'http://reviews.motorcycles/index.php/2015/02/15/2015-honda-nm4-nc700j-74612/' (length=76)
        public 'menu_order' => int 0
        public 'post_type' => string 'post' (length=4)
        public 'post_mime_type' => string '' (length=0)
        public 'comment_count' => string '0' (length=1)
  public 'filter' => string 'raw' (length=3)
*/

