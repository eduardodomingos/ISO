<?php
/**
 * The template for displaying "portfolio" archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

get_header();
?>

	<main class="site-main">
		<?php
		$terms = get_terms( array(
			'taxonomy' => 'location',
			'hide_empty' => true
		) );
		
		?>

		<?php if ( !empty($terms) ) : ?>

		<section class="section">
			<div class="wrap">
				<header class="section__header">
					<?php the_archive_title( '<h1 class="big">', '</h1>' ); ?>
					<?php the_archive_description();?>
				</header>
				<div class="section__content">
					<?php iso_list('', $terms, 'template-parts/content', 'teaser',  array(), false, true); ?>
				</div>
			</div>
		</section>
		<?php else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main>

<?php
get_footer();
