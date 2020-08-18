<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ISO
 */

if ( ! function_exists( 'iso_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function iso_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'iso' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'iso_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function iso_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'iso' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'iso' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'iso' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'iso' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'iso' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'iso' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'iso_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function iso_post_thumbnail($classes = '') {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail<?php echo ' ' . $classes;?>">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'iso_insert_modules' ) ) :
	/**
	 * Prints ACF Modules Fied Group.
	 */
	function iso_insert_modules() { ?>
		<div class="modules">
		<?php
			if( have_rows('modules') ):
				while ( have_rows('modules') ) : the_row();
					if( get_row_layout() == 'featured_works' ): ?>
						<section class="section">
							<div class="wrap">
								<header class="section__header">
									<h2>Featured Work</h2>
									<p><a href="<?php echo get_post_type_archive_link('portfolio'); ?>">view all work</a></p>
								</header>
								<div class="section__content">
									<?php 
									$featured_work = get_sub_field('portfolio');
									if( $featured_work ):
										iso_list('list--portfolio', $featured_work, 'template-parts/content', 'teaser', array('template_type' => 'portfolio'), true );
										// Reset the global post object so that the rest of the page works correctly.
										wp_reset_postdata();
									endif; ?>
								</div>
							</div>
						</section>
					<?php elseif( get_row_layout() == 'featured_posts' ): ?>
						<section class="section section--bg">
							<div class="wrap">
								<header class="section__header">
									<h2>Featured Blog Posts</h2>
									<p><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">view all blog posts</a></p>
								</header>
								<div class="section__content">
									<?php 
									$featured_work = get_sub_field('posts');
									if( $featured_work ):
										iso_list('', $featured_work, 'template-parts/content', 'teaser', array(), true );
										// Reset the global post object so that the rest of the page works correctly.
										wp_reset_postdata();
									endif; ?>
								</div>
							</div>
						</section>
					<?php endif; 
				endwhile;
			else :
				echo "<div class='wrap'>No Modules Defined!</div>";
			endif;
		?>
		</div>
	<?php }
endif;

if ( ! function_exists( 'iso_get_post_categories' ) ) :
	/**
	 * Return HTML with formatted post categories list.
	 */
	function iso_get_post_categories() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'iso' ) );
			if ( $categories_list ) {
				return sprintf( '<span class="topics">' . esc_html__( '%1$sPosted in%2$s %3$s', 'iso' ) . '</span>', '<span class="screen-reader-text">', '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'iso_entry_tags' ) ) :
	/**
	 * Prints HTML with meta information for the tags.
	 */
	function iso_entry_tags() {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list('',' ');
		if ( $tags_list ) {
			?>
			<p class="tags">Tags: <?php echo $tags_list?></p>
			<?php
		}
	}
endif;

if ( ! function_exists( 'iso_entry_share' ) ) :
	/**
	 * Displays the share buttons.
	 */
	function iso_entry_share() {
		$entry_url = urlencode(get_the_permalink());
		$entry_title = urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8'));
		?>
		<div class="share-post">
			<span class="label"><?php echo iso_get_svg( array( 'icon' => 'sharing' )); ?> Share</span>
			<ul class="socials">
				<li class="facebook">
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $entry_url; ?>" title="Share on Facebook">
						<?php echo iso_get_svg( array( 'icon' => 'facebook' )); ?>
						<span class="screen-reader-text">Share on Facebook</span>
					</a>
				</li>
				<li class="twitter">
					<a href="https://twitter.com/intent/tweet?text=<?php echo $entry_title; ?>&amp;url=<?php echo $entry_url; ?>&amp;via=eddomingos" title="Share on Twitter">
						<?php echo iso_get_svg( array( 'icon' => 'twitter' )); ?>
						<span class="screen-reader-text">Share on Twitter</span>
					</a>
				</li>
			</ul>
		</div>
	<?php
	}
endif;


if ( ! function_exists( 'iso_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function iso_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago',
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ) ) . ' ago'
		);

		echo ' <span class="posted-on meta">'. $time_string . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'iso_posted_in' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function iso_posted_in() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'iso' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			?>
			<span class="cat-links">under <?php echo $categories_list; ?></span>
			<?php
		}
	}
endif;
