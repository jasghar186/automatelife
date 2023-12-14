<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package automate_life
 */

?>

	<footer id="colophon" class="site-footer container bg-dark p-3">
		<div class="d-flex align-items-center justify-content-between">
			<p class="<?php echo (int) get_option('hide-promotion-footer-links') === 1 ? 'hidden-footer-promotion' : '' ?> text-light p-0 m-0">Powred by 
			<a href="#">automate life</a></p>
			<p class="text-light p-0 m-0 text-center"><?php echo get_option('footer-copyright-text'); ?></p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
