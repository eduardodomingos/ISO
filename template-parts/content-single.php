<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ISO
 */

?>

<article class="post post--blog">
	<header class="post__header">
		<div class="wrap wrap--mid">
			<?php iso_post_thumbnail(); ?>
		</div>
		<div class="wrap wrap--content">
			<?php the_title( '<h1>', '</h1>' ); ?>
			<p class="meta"><?php iso_posted_on(); ?> <?php iso_posted_in(); ?></p>
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
$related = new WP_Query(
	array(
        'category__in'   => wp_get_post_categories( $post->ID ),
        'posts_per_page' => 3,
		'post__not_in'   => array( $post->ID ),
		'orderby'   => 'rand',
		'order' => 'ASC'
    )
);

if ( $related->have_posts() ): ?>
	<section class="section section--bg">
		<div class="wrap">
			<header class="section__header">
				<h2>You May Also Like</h2>
				<p><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">view all blog posts</a></p>
			</header>
			<div class="section__content">
				<ul class="list list--default">
					<?php
					/* Start the Loop */
					while ( $related->have_posts() ) :
						$related->the_post();
						echo '<li>';				
						iso_get_template_part('template-parts/content', 'teaser');
						echo '</li>';
					endwhile;
					?>
				</ul>
			</div>
		</div>
	</section>
	<?php wp_reset_postdata(); ?>
<?php endif;?>



