<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ISO
 */

get_header();
?>

	<main class="site-main">
		<section class="section error-404">
			<div class="wrap">
				<header class="section__header">
					<h2>Oops! That page can't be found :(</h2>
					<p>It looks that the page you are looking for doesn't exist.<br><b><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Return home</a> or perhaps searching can help.</b></p>
				</header>
				<div class="section__content">
					<?php
					get_search_form();
					?>
				</div>
			</div>
		</section>
	</main><!-- #main -->

<?php
get_footer();
