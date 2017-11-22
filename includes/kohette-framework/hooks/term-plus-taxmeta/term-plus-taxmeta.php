<?php
/**
 *	Funcion encargada de completar la informacion de un termino con los taxmetas vinculados a el
 *
 *
 * @package printcore
 */


add_action('get_term', 'complete_term_with_taxmetas', 5, 1);
function complete_term_with_taxmetas($_term) {
	global $wpdb;
	global $table_prefix;

	$prefix = '';
	if ($table_prefix) $prefix = $table_prefix;
	if (!$prefix && isset($wpdb->table_prefix)) $prefix = $wpdb->table_prefix;
	if (!$prefix) $prefix = $wpdb->base_prefix;
	$taxmetas = $wpdb->get_results('SELECT meta_key, meta_value FROM ' . $prefix . 'taxonomymeta WHERE taxonomy_id = ' . $_term->term_id);


	foreach($taxmetas as $nodo => $meta ) {
		$key = ktt_remove_prefix($meta->meta_key);
		$value = maybe_unserialize($meta->meta_value);

		$_term->$key = $value;
	}

	return $_term;
}


add_action('get_term', 'complete_term_with_taxmetas_NEW', 6, 1);
function complete_term_with_taxmetas_NEW($_term) {
	global $wpdb;
	global $table_prefix;

	$prefix = '';
	if ($table_prefix) $prefix = $table_prefix;
	if (!$prefix && isset($wpdb->table_prefix)) $prefix = $wpdb->table_prefix;
	if (!$prefix) $prefix = $wpdb->base_prefix;
	$taxmetas = $wpdb->get_results('SELECT meta_key, meta_value FROM ' . $prefix . 'termmeta WHERE term_id = ' . $_term->term_id);


	foreach($taxmetas as $nodo => $meta ) {
		$key = ktt_remove_prefix($meta->meta_key);
		$value = maybe_unserialize($meta->meta_value);

		$_term->$key = $value;
	}

	return $_term;
}




/*
add_action('get_terms_fields', 'complete_terms_with_taxmetas', 1);
function complete_terms_with_taxmetas($terms) {
	global $wpdb;
	$taxmetas = $wpdb->get_results('SELECT meta_key, meta_value FROM wp_taxonomymeta WHERE taxonomy_id = ' . $_term->term_id);

	echo '<pre>';
	print_r($terms);
	echo '</pre>';

	return $_term;
}
*/




?>
