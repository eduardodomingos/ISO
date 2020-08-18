<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

?>

<article class="post post--portfolio">
	<header class="post__header">
		<?php
		$img_meta = wp_get_attachment_metadata( get_post_thumbnail_id());
		$orientation_class = 'post-thumbnail--' . ($img_meta['width'] > $img_meta['height'] ? 'landscape' : 'portrait');
		?>
		<?php iso_post_thumbnail($orientation_class); ?>
		
		<div class="wrap wrap--content">
			<?php the_title( '<h1>', '</h1>' ); ?>
		</div>
	</header>
	<div class="post__content wrap wrap--content">
		<?php the_content(); ?>
	</div>
	<footer class="post__footer wrap wrap--content">
		<?php iso_entry_tags();?>
		<?php iso_entry_share(); ?>
	</footer>
</article>

<?php
$terms = get_the_terms( $post->ID, 'location' );
$location = $terms[0];
$related = new WP_Query(
	array(
		'post_type' => 'portfolio',
		'orderby'   => 'rand',
		'order' => 'ASC',
		'posts_per_page' => '3',
		'post__not_in'   => array( $post->ID ),
		'tax_query' => array(
			array(
				'taxonomy' => 'location',
				'field' => 'slug',
				'terms' => $location->slug
			)
		)
	)
);

if ( $related->have_posts() ): ?>
	<section class="section section--bg">
		<div class="wrap">
			<header class="section__header">
				<h2>Explore More From <?php echo $location->name; ?></h2>
				<p><a href="<?php echo get_post_type_archive_link('portfolio'); ?>">view all work</a></p>
			</header>
			<div class="section__content">
				<?php iso_list('list--portfolio', $related, 'template-parts/content', 'teaser', array('template_type' => 'portfolio')); ?>
			</div>
		</div>
	</section>
	<?php wp_reset_postdata(); ?>
<?php endif;?>