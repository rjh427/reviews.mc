<?php
/*
 * Boilerplate to enable the child-theme
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
// post w/image
// http://reviews.motorcycles/?p=191743
// http://reviews.motorcycles/?p=190196
// http://reviews.motorcycles/?p=191181
// nocaptcha recaptcha
// P: 6LcPNxATAAAAAAnw_oylkn8_CyYex-1tMmzPgXNC
// S: 6LcPNxATAAAAADqRAv6EJbA0p1Dp7gg69gjFKqpA
// USP-Pro license key: 29f9c94a3f12ac2e8738722b04b55f0f
// Plugin-Planet (USP-Pro plugin)
// L: phillipb
// P: Dominion12!@
/*
 * Handle the custom display of year, make, & model data 
 */
add_filter('the_content', 'show_review_details');
function show_review_details($content) {
    $review = '';
    $meta = '';
    $upgrades = '';
    $ratings = '';
    $biometrics = '';
    $image = '';

// the_meta();

/*
    user_submit_image: http://reviews.motorcycles/wp-content/uploads/2015/11/209279902.jpg
    is_submission: 1
    user_submit_name: I'm me
    user_submit_email: no@way.org
    user_submit_ip: 127.0.0.1
*/
    if (get_field('cf_year') != null && get_field('cf_manufacturer') != null && get_field('cf_model') != null ) {
        $newTitle = get_field('cf_year') . ' ' . get_field('cf_manufacturer') . ' ' . get_field('cf_model') . ' ';
    }

    if (is_single()) {
        if (get_field('cf_upgrades') != null) {
            $upgrades = '<p>Upgrades:<br />' . get_field('cf_upgrades') . '</p>';
        }

        $ratings = '<table>
            <tr>
            <th colspan="2">Ratings</th>
            </tr>
            <tr>' . process_rating('cf_overall') . ' </tr>
            <tr>' . process_rating('cf_reliability') . '</tr>
            <tr>' . process_rating('cf_quality') . '</tr>
            <tr>' . process_rating('cf_performance') . '</tr>
            <tr>' . process_rating('cf_comfort') . '</tr>
            </table>';

        if (/*get_field('is_submission') != null && */ get_field('cf_user_picture') != '') {
            $image = '<p>Submitted image:<br />';
            $image .= '<img src="' . CDN_URL . get_field('cf_user_picture') . '" alt="User-submitted image" class="userPict" />';
        }

        $biometrics = $height = $weight = $milesHours = $location = '';

        if (get_field('cf_height') != null) {
            $height = '<td>Height:</td><td>' . get_field('cf_height') . '</td>';
        }

        if (get_field('cf_weight') != null) {
            $weight = '<td>Weight:</td><td>' . get_field('cf_weight') . '</td>';
        }

        if (get_field('cf_miles_or_hours') != null) {
            $milesHours = '<td>Miles or hours spent on the review:</td><td>' . get_field('cf_miles_or_hours') . '</td>';
        }

        if (get_field('cf_location') != null) {
           $location = '<td>Location</td><td>' . get_field('cf_location') . '</td>';
        }

        $biometrics = '<table><tr><th colspan="2">About the reviewer:</th></tr><tr>'
            . $height . '</tr><tr>'
            . $weight . '</tr><tr>'
            . $milesHours . '</tr><tr>'
            . $location . '</tr></table>';
    }

    $dateSubmitted = 'Submitted: ' . get_the_date('F, Y');

    return $meta . $ratings . $content . $image . $upgrades . $biometrics . $dateSubmitted;
} 

/*
 * Get the post meta data for the 1-5 star ratings and return
 * Helper function for show_review_details()
 */
function process_rating($param) {
    $str = '';
    $key = ucfirst(substr($param, 3));
    $value = get_field($param);

    if ($value != 0 && $value != null && $value != '') {
        $str .= '<td>' . $key . '</td><td>';
        for ($i = 0; $i < $value; $i++) {
            $str .= '&#9733; ';
        }

        $str .= '</td>';
    }

    return $str;
}

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
      year = form.find('#cf_year').val();
      make = form.find('#cf_manufacturer').val();
      model = form.find('#cf_model').val();
      id = jQuery.now();
      jQuery('#cf_review_id').val(id);
      jQuery('#usp-title').val(year + ' ' + make + ' ' + model + ' ' + '<span class=\"rId\">' + id + '</span>');
    });
  //-->
</script>";
}


/*
 * Custom shortcode to populate the page with the review submission form.
 * @TODO: Improve validation by extending form-to-post plugin
 * @TODO: Add select dropdown for categories
 * @TODO: Add input field for tags
 */
add_shortcode( 'user-review-create', 'addReviewForm_sc' );
function addReviewForm_sc() {
    return "trying to run addReviewForm_sc here";
}


/*
 * Binds to the form_to_post_before_create_post hook.
 * We can't trust that post_status will not be fiddled with on the 
 * client-side so set it to 'pending' status on the server. Setting 
 * the status to 'pending' distinguishes between drafts by authorized 
 * users and product review submissions from the general public.
 */
add_filter('form_to_post_before_create_post', 'form_to_post_set_values');
function form_to_post_set_values($post) {
    $post['post_status'] = 'pending';
    return $post;
}



/*



Thank you. You're Awesome!

Once your review has been approved it will be posted online. You will receive an email with a link to your review within 24 hours. Reviews like yours make this site great.

<a href="http://reviews.motorcyclesindex.php/search-for-a-review/">Search for other reviews!</a>



USP Pro
License Key: 29f9c94a3f12ac2e8738722b04b55f0f
License Domain: reviews.motorcycles
License Admin: reese.howell@dominionenterprises.com


<input id="_usp_review_id" name="_usp_review_id" type="hidden" value="1234" />
<input id="usp-title" name="usp-title" type="hidden" value="test" />

<fieldset>
    <legend>Mandatory Fields:</legend>
    <input id="_usp_year" name="_usp_year" placeholder="Year" type="text" value="" />
    <input id="_usp_manufacturer" placeholder="Manufacturer" name="_usp_manufacturer" type="text" value="" />
    <input id="_usp_model" placeholder="Model" name="_usp_model" type="text" value="" />
    <input id="_usp_review_title" placeholder="Review Title" name="_usp_review_title" type="text" value="" />
    [usp_content placeholder="" label="Your Review:" required="" max="" richtext=""]
</fieldset>



<fieldset>
    <legend>Optional Fields:</legend>

    <input name="_usp_location" type="text" value="" placeholder="Your Location" />
    <input name="_usp_height" type="text" value="" placeholder="Your Height" />
    <input name="_usp_weight" type="text" value="" placeholder="Your Weight" />
    <input name="_usp_name" type="text" value="" placeholder="Your Name" />

    <input name="_usp_email" type="text" value="" placeholder="Your Email" />
    <label for="">Do you wish to remain anonymous?</label>
    <input name="_usp_anon" type="radio" value="Y" /> Yes 
    <input name="_usp_anon" type="radio" value="N" /> No
</fieldset>

Ratings:
With 1 as worst and 5 as best, your ratings on...
<fieldset>
    <legend>Overall:</legend>
    <input name="_usp_overall" type="radio" value="1" /> 1
    <input name="_usp_overall" type="radio" value="2" /> 2
    <input name="_usp_overall" type="radio" value="3" /> 3
    <input name="_usp_overall" type="radio" value="4" /> 4
    <input name="_usp_overall" type="radio" value="5" /> 5
</fieldset>

<fieldset><legend>Reliability:</legend>
    <input name="_usp_reliability" type="radio" value="1" /> 1
    <input name="_usp_reliability" type="radio" value="2" /> 2
    <input name="_usp_reliability" type="radio" value="3" /> 3
    <input name="_usp_reliability" type="radio" value="4" /> 4
    <input name="_usp_reliability" type="radio" value="5" /> 5
</fieldset>

<fieldset><legend>Quality:</legend>
    <input name="_usp_quality" type="radio" value="1" /> 1
    <input name="_usp_quality" type="radio" value="2" /> 2
    <input name="_usp_quality" type="radio" value="3" /> 3
    <input name="_usp_quality" type="radio" value="4" /> 4
    <input name="_usp_quality" type="radio" value="5" /> 5
</fieldset>

<fieldset>
    <legend>Performance:</legend>
    <input name="_usp_performance" type="radio" value="1" /> 1
    <input name="_usp_performance" type="radio" value="2" /> 2
    <input name="_usp_performance" type="radio" value="3" /> 3
    <input name="_usp_performance" type="radio" value="4" /> 4
    <input name="_usp_performance" type="radio" value="5" /> 5
</fieldset>

<fieldset>
    <legend>Comfort:</legend>
    <input name="_usp_comfort" type="radio" value="1" /> 1
    <input name="_usp_comfort" type="radio" value="2" /> 2
    <input name="_usp_comfort" type="radio" value="3" /> 3
    <input name="_usp_comfort" type="radio" value="4" /> 4
    <input name="_usp_comfort" type="radio" value="5" /> 5
</fieldset>

<fieldset>
    <legend>Misc.</legend>
    <label>How reviewed?</label>
    <input name="_usp_miles_or_hours" type="text" value="" placeholder="Miles or Hours spent" />
    <label for="upgrades">Upgrades</label>
    <textarea cols="20" name="_usp_upgrades" rows="10"></textarea>
</fieldset>

<fieldset>
    <label>Would you like to provide an image of your ride?</label>
    <input name="_usp_user_picture" type="file" value="" placeholder="Your image" />
    [usp_files label="Your Photo" multiple="false" required="false"]
</fieldset>
*/
