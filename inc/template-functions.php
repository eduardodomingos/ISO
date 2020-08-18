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

/**
 * Customize ellipsis at end of excerpts.
 */
function iso_excerpt_more( $more ) {
	return "…";
}
add_filter( 'excerpt_more', 'iso_excerpt_more' );



/**
 * Customize length of excerpts.
 */
function iso_custom_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'iso_custom_excerpt_length', 999 );







function iso_aspect_ratio($float) {
    // 1/2, 1/4, 1/8, 1/16, 1/3 ,2/3, 3/4, 3/8, 5/8, 7/8, 3/16, 5/16, 7/16,
    // 9/16, 11/16, 13/16, 15/16
    $whole = floor ( $float );
    $decimal = $float - $whole;
    $leastCommonDenom = 48; // 16 * 3;
    $denominators = array (2, 3, 4, 8, 16, 24, 48 );
    $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;
    if ($roundedDecimal == 0)
        return $whole;
    if ($roundedDecimal == 1)
        return $whole + 1;
    foreach ( $denominators as $d ) {
        if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
            $denom = $d;
            break;
        }
    }
    return ($whole == 0 ? '' : $whole . " ") . ($roundedDecimal * $denom) . "/" . $denom;
}


function iso_list($classes = '', $contents, $template_slug, $template_name, $template_data = array(), $acf = false, $terms = false ) {
    if($classes == '') {
        $classes = 'list--default';
    }
    if($acf) :
        global $post;
        echo '<ul class="list ' . $classes . ' item-count-'. count($contents) . '">';
        foreach( $contents as $post ):
            // Setup this post for WP functions (variable must be named $post).
            setup_postdata($post);
            echo '<li>';
            iso_get_template_part($template_slug, $template_name, $template_data);
            echo '</li>';
        endforeach;
    elseif($terms) :
        echo '<ul class="list ' . $classes . ' item-count-'. count($contents) . '">';
        foreach( $contents as $term ) :
            the_post();
            echo '<li>';
            iso_get_template_part($template_slug, $template_name, array('template_type' => 'location', 'term' => $term));
            echo '</li>';
        endforeach;
    else:
        echo '<ul class="list ' . $classes . ' item-count-'. $contents->found_posts . '">';
        /* Start the Loop */
        while ( $contents->have_posts() ) :
            $contents->the_post();
            echo '<li>';				
            iso_get_template_part($template_slug, $template_name, $template_data);
            echo '</li>';
        endwhile;
    endif;
    echo '</ul>';
}