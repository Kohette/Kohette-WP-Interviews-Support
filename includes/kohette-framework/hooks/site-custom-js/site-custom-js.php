<?php
/**
* This hook allow us to add custom js code to our site
*/
function KTT_print_site_custom_js_footer() {

    /**
    * first we extract all the custom css of our site
    */
    $result = KTT_get_site_custom_js_footer();

    /**
    * We add a filter, util for modify the return of this function
    */
    $result = apply_filters('KTT_print_site_custom_js_footer', $result);

    /**
    * We create the style tags and print the css
    */
    if ($result) {
      echo '<script>';
      echo $result;
      echo '</script>';
    };

}
add_action('wp_footer', 'KTT_print_site_custom_js_footer', 100000);


/**
* The same but for the header
*/
function KTT_print_site_custom_js_header() {

    /**
    * first we extract all the custom css of our site
    */
    $result = KTT_get_site_custom_js_header();

    /**
    * We add a filter, util for modify the return of this function
    */
    $result = apply_filters('KTT_print_site_custom_js_header', $result);

    /**
    * We create the style tags and print the css
    */
    if ($result) {
      echo '<script>';
      echo $result;
      echo '</script>';
    };

}
add_action('wp_head', 'KTT_print_site_custom_js_header', 100000);
