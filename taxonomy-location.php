<?php
/**
 * The template for displaying "location" taxonomy page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

get_header();
?>

	<main class="site-main">

		<?php if ( have_posts() ) : ?>
			<section class="section">
				<div class="wrap">
					<header class="section__header">
						<?php the_archive_title( '<h1>', '</h1>' ); ?>
						<?php the_archive_description();?>
					</header>
					<div class="section__content">
						<?php iso_list('list--portfolio', $wp_query, 'template-parts/content', 'teaser', array('template_type' => 'portfolio')); ?>
					</div>		
				</div>
			</section>
		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main>

<?php
get_footer();
