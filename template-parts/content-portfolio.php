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
		<!--div class="post-thumbnail post-thumbnail--landscape">
			<?php // iso_post_thumbnail(); ?>
			<img src="img/coimbra.jpg" alt="">
		</div-->
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
$args = array(
	'post_type' => 'portfolio',
	'orderby'   => 'rand',
	'order' => 'ASC',
	'posts_per_page' => '3',
	'tax_query' => array(
		array(
			'taxonomy' => 'location',
			'field' => 'slug',
			'terms' => $location->slug
		)
	)
);
$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ): ?>
	<section class="section section--bg">
		<div class="wrap">
			<header class="section__header">
				<h2>Explore More From <?php echo $location->name; ?></h2>
				<p><a href="<?php echo get_post_type_archive_link('portfolio'); ?>">view all work</a></p>
			</header>
			<div class="section__content">
				<ul class="list list--portfolio">
					<?php
					/* Start the Loop */
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						echo '<li>';				
						iso_get_template_part('template-parts/content', 'teaser', array('template_type' => 'portfolio'));
						echo '</li>';
					endwhile;
					?>
				</ul>
			</div>
		</div>
	</section>
	<?php wp_reset_postdata(); ?>
<?php endif;?>