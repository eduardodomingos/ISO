<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

get_header();
?>

	<main class="site-main">
		<section class="section">
			<div class="wrap">
				<header class="section__header">
					<?php the_title( '<h1 class="big">', '</h1>' ); ?>
				</header>
				<div class="section__content">
					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'page' );

					endwhile; // End of the loop.
					?>
				</div>
			</div>
		</section>

		<?php
		$latest = new WP_Query(
			array(
				'post_type' => 'portfolio',
				'posts_per_page' => 3
			)
		);

		if ( $latest->have_posts() ): ?>
			<section class="section section--bg">
				<div class="wrap">
					<header class="section__header">
						<h2>Recent Work</h2>
						<p><a href="<?php echo get_post_type_archive_link('portfolio'); ?>">view all work</a></p>
					</header>
					<div class="section__content">
						<?php iso_list('list--portfolio', $latest, 'template-parts/content', 'teaser',  array('template_type' => 'portfolio')); ?>
					</div>
				</div>
			</section>
			<?php wp_reset_postdata(); ?>
		<?php endif;?>
	</main>

<?php
get_footer();
