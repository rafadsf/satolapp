<?php
/* Responsive Slider Shortcode -

Use this shortcode to create a slider out of any HTML content. All it requires a UL element with children to show.

Usage:

[responsive_slider type="testimonials2" animation="slide" control_nav="true" direction_nav=false pause_on_hover="true" slideshow_speed=4500]

<ul>
	<li>Slide 1 content goes here.</li>
	<li>Slide 2 content goes here.</li>
	<li>Slide 3 content goes here.</li>
</ul>

[/responsive_slider]


Parameters -

type (string) - Constructs and sets a unique CSS class for the slider. (optional).
slideshow_speed - 5000 (number). Set the speed of the slideshow cycling, in milliseconds
animation_speed - 600 (number). Set the speed of animations, in milliseconds.
animation - fade (string). Select your animation type, "fade" or "slide".
pause_on_action - true (boolean). Pause the slideshow when interacting with control elements, highly recommended.
pause_on_hover - true (boolean). Pause the slideshow when hovering over slider, then resume when no longer hovering.
direction_nav - true (boolean). Create navigation for previous/next navigation? (true/false)
control_nav - true (boolean). Create navigation for paging control of each slide? Note: Leave true for manual_controls usage.
easing - swing (string). Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
loop - true (boolean). Should the animation loop?
slideshow - true (boolean). Animate slider automatically without user intervention.
controls_container - (string). Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
manualControls - (string). Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
style - (string) - The inline CSS applied to the slider container DIV element.
*/

function mo_responsive_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(
        array('type' => 'flex',
            'slideshow_speed' => 5000,
            'animation_speed' => 600,
            'animation' => 'fade',
            'pause_on_action' => 'false',
            'pause_on_hover' => 'true',
            'direction_nav' => 'true',
            'control_nav' => 'true',
            'easing' => 'swing',
            'loop' => 'true',
            'slideshow' => 'true',
            'controls_container' => false,
            'manual_controls' => false,
            'style' => ''),
        $atts));

    $output = '';

    $slider_container = $type . '-slider-container';

    if (empty($controls_container))
        $controls_container = $slider_container;
    $namespace = 'flex';

    $output .= '<script type="text/javascript">' . "\n";
    $output .= 'jQuery(document).ready(function($) {';
    $output .= 'jQuery(\'.' . $slider_container . ' .flexslider\'). flexslider({';
    $output .= 'animation: "' . $animation . '",';
    $output .= 'slideshowSpeed: ' . $slideshow_speed . ',';
    $output .= 'animationSpeed: ' . $animation_speed . ',';
    $output .= 'namespace: "' . $namespace . '-",';
    $output .= 'pauseOnAction:' . $pause_on_action . ',';
    $output .= 'pauseOnHover: ' . $pause_on_hover . ',';
    $output .= 'controlNav: ' . $control_nav . ',';
    $output .= 'directionNav: ' . $direction_nav . ',';
    $output .= 'prevText: ' . '"Previous' . '<span></span>",';
    $output .= 'nextText: ' . '"Next' . '<span></span>",';
    $output .= 'smoothHeight: false,';
    $output .= 'animationLoop: ' . $loop . ',';
    $output .= 'slideshow: ' . $slideshow . ',';
    $output .= 'easing: "' . $easing . '",';
    if (!empty($manual_controls))
        $output .= 'manualControls: "' . $manual_controls . '",';
    $output .= 'controlsContainer: "' . $controls_container . '"';
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";

    if (!empty($style))
        $style = ' style="' . $style . '"';

    $output .= '<div class="' . $slider_container . ($type == "flex" ? ' loading' : '') . '"' . $style . '>';

    $output .= '<div class="flexslider">';

    $styled_list = '<ul class="slides">';

    $slider_content = do_shortcode($content);

    $output .= str_replace('<ul>', $styled_list, $slider_content);

    $output .= '</div><!-- flexslider -->';
    $output .= '</div><!-- ' . $slider_container . ' -->';

    return $output;
}

add_shortcode('responsive_slider', 'mo_responsive_slider_shortcode');

function mo_responsive_carousel_shortcode($atts, $content = null) {
    $args = shortcode_atts(
        array('slideshow_speed' => 3000,
            'animation_speed' => 600,
            'pauseOnHover' => 'true',
            'easing' => 'swing',
            'item_width' => 210,
            'item_margin' => 30,
            'max_items' => 5,
            'min_items' => 2,
            'post_type' => null,
            'post_count' => 4,
            'layout_class' => 'post-snippets',
            'display_title' => false,
            'display_summary' => false,
            'show_excerpt' => true,
            'excerpt_count' => 100,
            'show_meta' => false,
            'hide_thumbnail' => false,
            'image_size' => 'medium',
            'terms' => '',
            'taxonomy' => ''),
        $atts);

    extract($args);

    $output = '';

    $controls_container = 'carousel-container';

    $output .= '<script type="text/javascript">' . "\n";
    $output .= 'jQuery(document).ready(function($) {';
    $output .= 'jQuery(\'.' . $controls_container . ' .slides\').bxSlider({';
    $output .= 'mode: "horizontal",';
    $output .= 'infiniteLoop: false,';
    $output .= 'slideWidth: ' . $item_width . ',';
    $output .= 'slideMargin: ' . $item_margin . ',';
    $output .= 'maxSlides: ' . $max_items . ',';
    $output .= 'minSlides: ' . $min_items . ',';
    $output .= 'autoStart: false,';
    $output .= 'moveSlides: ' . $min_items . ',';
    $output .= 'pause: ' . $slideshow_speed . ',';
    $output .= 'speed: ' . $animation_speed . ',';
    $output .= 'easing: "' . $easing . '"';
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";

    $output .= '<div class="carousel-wrap loading">';

    $output .= '<div class="' . $controls_container . '">';

    $styled_list = '<ul class="slides image-grid ' . $layout_class . '">';

    $slider_content = mo_get_post_snippets_list($args);

    $output .= str_replace('<ul>', $styled_list, $slider_content);

    $output .= '</div><!-- ' . $controls_container . ' -->';

    $output .= '</div><!-- carousel-wrap -->';

    return $output;
}

add_shortcode('responsive_carousel', 'mo_responsive_carousel_shortcode');

/* Device Slider Shortcode -

Use this shortcode to create a image slider part of a container that looks like a browser, smartphone, tablet or a desktop. Possible sliders are

[browser_slider], [imac_slider], [macbook_slider], [ipad_slider], [iphone_slider], [galaxys4_slider], [htcone_slider].

The image URLs are provided via a comma separated list of URLs pointing to the images.

Usage:

[browser_slider
animation="slide"
browser_url="http://portfoliotheme.org/extinct"
direction_nav=true
control_nav=false
slideshow_speed=4000
animation_speed=600
pause_on_action=true
pause_on_hover=true
easing="swing"
style="margin-bottom:20px;"
image_urls="http://portfoliotheme.org/austin/wp-content/uploads/2014/03/web-slide3.jpg,http://portfoliotheme.org/austin/wp-content/uploads/2014/03/web-slide1.jpg,http://portfoliotheme.org/austin/wp-content/uploads/2014/03/web-slide2.jpg,http://portfoliotheme.org/austin/wp-content/uploads/2014/03/web-slide4.jpg"]


Parameters -


style - (string) - The inline CSS applied to the slider container DIV element.
device - iphone (string) - The device type - valid values are iphone, galaxys4, htcone, ipad, imac, macbook, browser.
slideshow_speed - 5000 (number). Set the speed of the slideshow cycling, in milliseconds
animation_speed - 600 (number). Set the speed of animations, in milliseconds.
animation - fade (string). Select your animation type, "fade" or "slide".
pause_on_action - true (boolean). Pause the slideshow when interacting with control elements, highly recommended.
pause_on_hover - true (boolean). Pause the slideshow when hovering over slider, then resume when no longer hovering.
direction_nav - true (boolean). Create navigation for previous/next navigation? (true/false)
control_nav - true (boolean). Create navigation for paging control of each slide? Note: Leave true for manual_controls usage.
easing - swing (string). Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
loop - true (boolean). Should the animation loop?
image_urls (string) - Comma separated list of URLs pointing to the images.
browser_url (string) - If the device specified is browser or if [browser_slider], this provides the URL to be displayed in the address bar of the browser.
*/


function mo_device_slider_shortcode($atts) {
    extract(shortcode_atts(
        array('slideshow_speed' => 5000,
            'device' => 'iphone', /* valid values - iphone, galaxys4, htcone, ipad */
            'animation_speed' => 600,
            'animation' => 'fade',
            'pause_on_action' => 'false',
            'pause_on_hover' => 'true',
            'direction_nav' => 'true',
            'control_nav' => 'true',
            'easing' => 'swing',
            'loop' => 'true',
            'style' => '',
            'image_urls' => '',
            'browser_url' => ''),
        $atts));

    $output = '';

    // Check if one or more image URLs are specified, else no point continuing
    if (empty($image_urls))
        return $output;

    if (!empty($style))
        $style = ' style="' . $style . '"';

    $output .= '<div class="'. $device .'-slider-container smartphone-slider"' . $style . '>';

    if ($device === 'browser' && !empty($browser_url))
        $output .= '<div class="address-bar">' . $browser_url . '</div>';

    $output .= '<img src="' . get_template_directory_uri(). '/images/sliders/'. $device .'-slider-stage.png" alt="'. $device .' Slider"/>';

    /* Start: Construct the slider */
    $slider = '[responsive_slider ';
    $slider .= 'direction_nav=' . $direction_nav . ' ';
    $slider .= 'control_nav=' . $control_nav . ' ';
    $slider .= 'animation=' . $animation . ' ';
    $slider .= 'type=flex ';
    $slider .= 'slideshow_speed=' . $slideshow_speed . ' ';
    $slider .= 'animation_speed=' . $animation_speed . ' ';
    $slider .= 'pause_on_action=' . $pause_on_action . ' ';
    $slider .= 'pause_on_hover=' . $pause_on_hover . ' ';
    $slider .= 'loop=' . $loop . ' ';
    $slider .= 'easing=' . $easing . ' ';
    $slider .= ']';
    $slider .= '<ul>';
    $image_urls = explode(',', $image_urls);
    foreach ($image_urls as $image_url) {
        $slider .= '<li><div class="img-wrap"><img alt="App Slide" src="';
        $slider .= $image_url;
        $slider .= '"></div></li>';
    }
    $slider .= '</ul>';
    $slider .= '[/responsive_slider]';
    /* END: Construct the slider */

    $output .= do_shortcode($slider);
    $output .= '</div>';

    return $output;
}

function mo_galaxys4_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'galaxys4'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_htcone_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'htcone'), $atts);
    return mo_device_slider_shortcode($atts);
}


function mo_ipad_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'ipad'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_macbook_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'macbook'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_imac_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'imac'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_browser_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'browser'), $atts);
    return mo_device_slider_shortcode($atts);
}

add_shortcode('iphone_slider', 'mo_device_slider_shortcode');

add_shortcode('galaxys4_slider', 'mo_galaxys4_slider_shortcode');

add_shortcode('htcone_slider', 'mo_htcone_slider_shortcode');

add_shortcode('ipad_slider', 'mo_ipad_slider_shortcode');

add_shortcode('macbook_slider', 'mo_macbook_slider_shortcode');

add_shortcode('imac_slider', 'mo_imac_slider_shortcode');

add_shortcode('browser_slider', 'mo_browser_slider_shortcode');

add_shortcode('smartphone_slider', 'mo_device_slider_shortcode');

