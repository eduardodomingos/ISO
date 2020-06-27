<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ISO
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function iso_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'iso_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function iso_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'iso_pingback_header' );


/**
 * Remove content editor support for specific pages
 */
add_action( 'admin_init', 'hide_editor' );
function hide_editor() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	if( !isset( $post_id ) ) return;
	$home = get_the_title($post_id);
	if($home == 'Home') { 
		remove_post_type_support('page', 'editor');
	}
}

/**
 * Define the rewrite_rules_array callback
 */
function filter_rewrite_rules_array( $rules ) { 
	// make filter magic happen here... 
	$newRules  = array();
	// portfolio/portugal/samouqueira -> index.php?portfolio=samouqueira
	$newRules['portfolio/(.+)/(.+)/?$'] = 'index.php?portfolio=$matches[2]';
	// portfolio/portugal -> index.php?location=portugal
	$newRules['portfolio/(.+)/?$'] = 'index.php?location=$matches[1]';

    return array_merge( $newRules, $rules );
}; 
         
// add the filter 
add_filter( 'rewrite_rules_array', 'filter_rewrite_rules_array', 10, 1 ); 
