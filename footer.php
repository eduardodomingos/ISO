<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ISO
 */

?>

	<footer class="site-footer">
		<div class="site-footer__top">
			<div class="wrap">
			
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-footer',
						'container'      => false,
						'menu_class'     => 'socials',
					)
				);
				?>

			</div>
		</div>
		<small class="wrap">&copy; <?php echo date('Y'); ?> Eduardo Domingos. All Rights Reserved.</small>
	</footer>
	<aside class="offcanvas">
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
	</aside>
</div>

<?php wp_footer(); ?>

</body>
</html>
