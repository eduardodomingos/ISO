<?php
/**
 * The template for displaying all single portfolio posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ISO
 */

get_header();
?>

	<main class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'portfolio' );

		endwhile; // End of the loop.
		?>

	</main>

<?php
get_footer();
