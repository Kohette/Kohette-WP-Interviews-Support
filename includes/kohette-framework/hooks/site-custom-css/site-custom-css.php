<?php
/**
* This hook allow us to add custom css code to our site
*/

function KTT_print_site_custom_css() {

    /**
    * first we extract all the custom css of our site
    */
    $result = KTT_get_site_custom_css();

    /**
    * We add a filter, util for modify the return of this function
    */
    $result = apply_filters('KTT_print_site_custom_css', $result);

    /**
    * We create the style tags and print the css
    */
    if ($result) {
      echo '<style id="site-custom-css">';
      echo $result;
      echo '</style>';
    };

}
add_action('wp_head', 'KTT_print_site_custom_css', 100000);
