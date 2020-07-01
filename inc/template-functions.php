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
function hide_editor() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	if( !isset( $post_id ) ) return;
	$home = get_the_title($post_id);
	if($home == 'Home') { 
		remove_post_type_support('page', 'editor');
	}
}
// add the action 
add_action( 'admin_init', 'hide_editor' );

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

/**
 * define the post_type_link callback 
 */
function filter_post_type_link( $post_link, $post, $leavename, $sample ) { 
	// make filter magic happen here... 
	if ( $post->post_type == 'portfolio' ) {
		if ( $cats = get_the_terms( $post->ID, 'location' ) ) {
		  $post_link = str_replace( '%location%', current( $cats )->slug, $post_link );
		}
	  }
    return $post_link; 
}; 
         
// add the filter 
add_filter( 'post_type_link', 'filter_post_type_link', 10, 4 );

/*
 * Prefix tags with an # symbol
*/
add_filter( 'term_links-post_tag', function ( $links )
{

    // Return if $links are empty
    if ( empty( $links ) )
        return $links;

    // Reset $links to an empty array
    unset ( $links );
    $links = [];

    // Get the current post ID
    $id = get_the_ID();
    // Get all the tags attached to the post
    $taxonomy = 'post_tag';
	$terms = get_the_terms( $id, $taxonomy );
	

    // Make double sure we have tags
    if ( !$terms )
        return $links; 

    // Loop through the tags and build the links
    foreach ( $terms as $term ) {
        $link = get_term_link( $term, $taxonomy );

        // Here we add our hastag, so we get #Tag Name with link
        $links[] = '<a href="' . esc_url( $link ) . '" rel="tag">#' . $term->name . '</a>';
    }

    return $links;
});

/*
 * Add support for custom post type "portfolio" tags
 *  (https://wordpress.stackexchange.com/questions/108067/custom-post-type-taxonomy-tag-archive-no-post-found)
*/
function iso_cpt_tags( $query ) {
    if ( $query->is_tag() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post', 'portfolio' ) );
    }
}
add_action( 'pre_get_posts', 'iso_cpt_tags' );


/*
 * Remove prefix from archive titles
 *  (https://wordpress.stackexchange.com/questions/179585/remove-category-tag-author-from-the-archive-title)
*/
add_filter( 'get_the_archive_title', function ($title) {    
    if ( is_tax('location') ) {
        $title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
    } 
    elseif ( is_post_type_archive('portfolio') ) {
        $title = post_type_archive_title( '', false );
    } 
    return $title;
});

/**
 * Get template part with passed arguments.
 * @return file
 */
function iso_get_template_part( $slug, $name = null, $data = array() ) {
    extract( $data );
    if ( $name )
        $file = "{$slug}-{$name}.php";
    else
        $file = "{$slug}.php";
    include locate_template( $file );
}
