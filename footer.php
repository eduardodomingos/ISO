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
					)
				);
				?>

			</div>
		</div>
		<small class="wrap">&copy; <?php echo date('Y'); ?> Eduardo Domingos. All Rights Reserved.</small>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
