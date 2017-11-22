<?php
/**
 * Interview sbuttons.
 *
 */




// adding shortcode button

add_action( 'init', 'KTT_interview_buttons' );
function KTT_interview_buttons() {
    add_filter( "mce_external_plugins", "KTT_interview_add_buttons" );
    add_filter( 'mce_buttons', 'KTT_interview_register_buttons' );
}
function KTT_interview_add_buttons( $plugin_array ) {
    $plugin_array['interview_buttons'] = plugins_url( '/includes/buttons_src/js/interview_buttons.js', dirname(__FILE__) );
    return $plugin_array;
}
function KTT_interview_register_buttons( $buttons ) {
    array_push( $buttons, 'question', 'answer' );
    return $buttons;
}





// Shortcodes functions

function KTT_question_shortcode( $atts, $content = null ) {
	return '<p class="question font-weight-700">' . do_shortcode($content) . '</p>';
}
add_shortcode( 'question', 'KTT_question_shortcode' );



function KTT_answer_shortcode( $atts, $content = null ) {
	return '<p class="answer">' . do_shortcode($content) . '</p>';
}
add_shortcode( 'answer', 'KTT_answer_shortcode' );
