<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ISO
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'iso' ); ?></a>

	<header 
	class="site-header <?php if (has_post_thumbnail( $post->ID ) ): ?>site-header--bg-img<?php endif;?>"
	<?php if (has_post_thumbnail( $post->ID ) ): ?>
		style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>');"
	<?php endif;?>
	>
		<div>
			<?php dynamic_sidebar( 'header-top-1' ); ?>
			<div class="bar">
				<div class="wrap">
					<div class="branding">
						<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Eduardo Domingos</a></h1>
						<p>Landscape Photography</p>
					</div>
					<div>
						<nav class="site-nav">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-header',
									'container'      => false,
								)
							);
							?>
						</nav>
						<button class="offcanvas-toggle" aria-controls="offcanvas" aria-expanded="false">
							<i></i>
							<i></i>
							<i></i>
							<span class="screen-reader-text">Open Menu</span>
                        </button>
					</div>
				</div>
			</div>
		</div>
	</header>
