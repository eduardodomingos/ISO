<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

get_header();
?>

	<main class="site-main">
		<?php
		if ( have_posts() ) : ?>
			<section class="section">
				<div class="wrap">
					<header class="section__header">
						<h1 class="big">Blog</h1>
						<p>Some writing about Landscape Photography.</p>
					</header>
					<div class="section__content">
						<ul class="list list--default">
							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();
								echo '<li>';
								iso_get_template_part('template-parts/content', 'teaser');
								echo '</li>';
							endwhile;
							?>
						</ul>
					</div>
				</div>
			</section>
		<?php
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
	</main><!-- #main -->

<?php
get_footer();
