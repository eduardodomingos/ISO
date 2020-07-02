<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

?>

<article class="page page--<?php echo get_post_field( 'post_name' );?>">
	<div class="page__content wrap wrap--content">
		<?php the_content(); ?>
	</div>
</article>
