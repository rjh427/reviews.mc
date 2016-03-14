<?php
// ini_set('display_errors', '0');
/*
 * Boilerplate to enable the child-theme
 */
/*
USP Pro
License Key: 29f9c94a3f12ac2e8738722b04b55f0f
License Domain: reviews.motorcycles
License Admin: reese.howell@dominionenterprises.com

posts w/image
http://reviews.motorcycles/?p=191743
http://reviews.motorcycles/?p=190196
http://reviews.motorcycles/?p=191181
Google nocaptcha recaptcha:
  P: 6LcPNxATAAAAAAnw_oylkn8_CyYex-1tMmzPgXNC
  S: 6LcPNxATAAAAADqRAv6EJbA0p1Dp7gg69gjFKqpA
Plugin-Planet (USP-Pro plugin)
  L: phillipb
  P: Dominion12!@
search-results url format: 
http://www.cycletrader.com/search-results?make=<url-safe-make-name>&model=<url-safe-model-name>&modelkeyword=1
Google Analytics ID: UA-18717971-22
*/

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/*
 * Child-theme add-ons
 */

define ('CDN_URL', 'https://media.traderonline.com/v1/media/');

/* Build the custom displays for review detail pages
 *
 * @return string
 */
function displayReviewDetails($content) {
    if ( is_front_page() || is_page()  ) 
       return $content;
} 
add_filter('the_content', 'displayReviewDetails');


/*
 * Custom shortcode for turning the provided year, make, & model data into
 * a post_title element. This is done client-side.
 * @TODO: This should be done server-side
 */
add_shortcode( 'create-post-title', 'createPostTitle_sc' );
function createPostTitle_sc() {
    return "
<script type='text/javascript'>
  <!--
    jQuery('#usp-form-12693').submit(function() {
      var year, make, model, id, form = null;
      form = jQuery('#usp-form-12693');
      year = form.find('#year').val();
      make = form.find('#manufacturer').val();
      model = form.find('#model').val();
      id = jQuery.now();
      jQuery('#review_id').val(id);
      jQuery('#usp-title').val(year + ' ' + make + ' ' + model + ' ' + id);
    });
  //-->
</script>";
}

add_shortcode( 'google-analytics', 'googleAnalytics_sc' );
function googleAnalytics_sc() {
    return "
<script>
<!--
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-18717971-22', 'auto');
  ga('send', 'pageview');
//-->
</script>";
}

function reviewsChild_widgets_init() {
    register_sidebar( array(
        'name' => __( 'First Footer Widget Area', 'reviewsChild' ),
        'id' => 'first-footer-widget-area',
        'description' => __( 'The first footer widget area', 'reviewsChild' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
 
    register_sidebar( array(
        'name' => __( 'Second Footer Widget Area', 'reviewsChild' ),
        'id' => 'second-footer-widget-area',
        'description' => __( 'The second footer widget area', 'reviewsChild' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
 
    register_sidebar( array(
        'name' => __( 'Third Footer Widget Area', 'reviewsChild' ),
        'id' => 'third-footer-widget-area',
        'description' => __( 'The third footer widget area', 'reviewsChild' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
 
    register_sidebar( array(
        'name' => __( 'Fourth Footer Widget Area', 'reviewsChild' ),
        'id' => 'fourth-footer-widget-area',
        'description' => __( 'The fourth footer widget area', 'reviewsChild' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
         
}

add_shortcode( 'count_published_posts', 'countPosts_sc' );
function countPosts_sc() {
    return number_format(wp_count_posts()->publish);
}
 
// Register sidebars by running reviewsChild_widgets_init() on the widgets_init hook.
add_action( 'widgets_init', 'reviewsChild_widgets_init' );
