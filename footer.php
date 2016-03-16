<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

<?php // is_home() is_front_page() is_single() is_page() is_tag() is_tax() is_archive() is_search() is_singular() 
    // If none of the areas have widgets, bail early.
    if (   ! is_active_sidebar( 'first-footer-widget-area'  )
        && ! is_active_sidebar( 'second-footer-widget-area' )
        && ! is_active_sidebar( 'third-footer-widget-area'  )
        && ! is_active_sidebar( 'fourth-footer-widget-area' )
    )
        return;

if (   is_active_sidebar( 'first-footer-widget-area'  )
    && is_active_sidebar( 'second-footer-widget-area' )
    && is_active_sidebar( 'third-footer-widget-area'  )
    && is_active_sidebar( 'fourth-footer-widget-area' )
) : ?>
 
        <aside class="fatfooter" role="complementary">
            <div class="first quarter left widget-area">
                <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
            </div><!-- .first .widget-area -->

            <div class="second quarter widget-area">
                <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
            </div><!-- .second .widget-area -->

            <div class="third quarter widget-area">
                <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
            </div><!-- .third .widget-area -->

            <div class="fourth quarter right widget-area">
                <?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
            </div><!-- .fourth .widget-area -->
        </aside><!-- #fatfooter -->

<?php 
    elseif ( is_active_sidebar( 'first-footer-widget-area'  )
        && is_active_sidebar( 'second-footer-widget-area' )
        && is_active_sidebar( 'third-footer-widget-area'  )
        && ! is_active_sidebar( 'fourth-footer-widget-area' )
    ) : ?>
        <aside class="fatfooter" role="complementary">
            <div class="first one-third left widget-area">
                <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
            </div><!-- .first .widget-area -->
 
            <div class="second one-third widget-area">
                <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
            </div><!-- .second .widget-area -->
 
            <div class="third one-third right widget-area">
                <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
            </div><!-- .third .widget-area -->
 
        </aside><!-- #fatfooter -->

<?php
    elseif ( is_active_sidebar( 'first-footer-widget-area'  )
        && is_active_sidebar( 'second-footer-widget-area' )
        && ! is_active_sidebar( 'third-footer-widget-area'  )
        && ! is_active_sidebar( 'fourth-footer-widget-area' )
    ) : ?>
        <aside class="fatfooter" role="complementary">
            <div class="first half left widget-area">
                <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
            </div><!-- .first .widget-area -->
 
            <div class="second half right widget-area">
                <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
            </div><!-- .second .widget-area -->
 
        </aside><!-- #fatfooter -->

<?php
    elseif ( is_active_sidebar( 'first-footer-widget-area'  )
        && ! is_active_sidebar( 'second-footer-widget-area' )
        && ! is_active_sidebar( 'third-footer-widget-area'  )
        && ! is_active_sidebar( 'fourth-footer-widget-area' )
    ) :
    ?>
        <aside class="fatfooter" role="complementary">
            <div class="first full-width widget-area">
                <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
            </div><!-- .first .widget-area -->
        </aside><!-- #fatfooter -->
<?php 
    endif;?>

    	<div class="site-info">
    		<?php
    		/**
    		 * Fires before the Twenty Fifteen footer text for footer customization.
    		 *
    		 * @since Twenty Fifteen 1.0
    		 */
    		do_action( 'twentyfifteen_credits' );
    	?>
    		Affiliated with <a href="http://www.CycleTrader.com" rel="nofollow"><img class="footer-logo" alt="Cycle Trader Logo" src="http://cdn1.traderonline.com/v1/media/cycle-logo.png?height=23"></a>
    	</div><!-- .site-info -->

	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>
<?php echo do_shortcode('[google-analytics]') ?>

</body>
</html>
