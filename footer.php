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

	<!-- Scroll back to top -->

	<?php
		if( get_option('scroll_back_to_top_option') &&
		intval(get_option('scroll_back_to_top_option')) === 1 ) {
			?>
				<div class="scroll-back-to-top position-fixed">
					<button class="text-light fs-6 bg-primary py-2 px-3 rounded">
						<i class="bi bi-arrow-up me-2"></i>
						<span>Back to Top</span>
					</button>
				</div>
			<?php
		}
	?>

	<footer id="colophon" class="site-footer bg-secondary p-3">
		<div class="row">
			<div class="col-12 col-lg-6">
				<div class="site-branding mb-5 pb-3">
					<?php the_custom_logo(); ?>
				</div>

				<!-- Footer Menu Items -->
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_menu',
							'menu_id'        => 'footer_menu',
							'container'		 => 'nav',
							'container_class'=> 'footer-menu-items-wrapper',
						)
					);
				?>
			</div>
			<div class="col-12 col-lg-6">
				<p class="mb-4">Join thousands of subscribers and learn about smart homes in 5 minutes per week</p>
				
				<div class="mb-5">
					<?php echo automate_life_email_recaptcha('light', 'footer-lead-email'); ?>
				</div>

				<div class="d-flex align-items-center justify-content-start mb-5">
				<?php
					foreach (COMPANY_SOCIALS_URLS as $index => $icon) {
						if(trim(get_option($icon)) !== false && !empty(trim(get_option($icon)))) {
							if(strpos($icon, 'twitter') !== false) {
								echo '<a href="'.esc_url(trim(get_option($icon))).'" target="_blank" class="bg-primary rounded-circle text-white text-center text-decoration-none d-flex align-items-center justify-content-center company-social-icons bi bi-twitter">
								</a>';
							}else if(strpos($icon, 'facebook') !== false) {
								echo '<a href="'.esc_url(trim(get_option($icon))).'" target="_blank" class="bg-primary rounded-circle text-white text-center text-decoration-none d-flex align-items-center justify-content-center company-social-icons bi bi-facebook">
								</a>';
							}else if(strpos($icon, 'tiktok') !== false) {
								echo '<a href="'.esc_url(trim(get_option($icon))).'" target="_blank" class="bg-primary rounded-circle text-white text-center text-decoration-none d-flex align-items-center justify-content-center company-social-icons bi bi-tiktok">
								</a>';
							}else if(strpos($icon, 'youtube') !== false) {
								echo '<a href="'.esc_url(trim(get_option($icon))).'" target="_blank" class="bg-primary rounded-circle text-white text-center text-decoration-none d-flex align-items-center justify-content-center company-social-icons bi bi-youtube">
								</a>';
							}else if(strpos($icon, 'pinterest') !== false) {
								echo '<a href="'.esc_url(trim(get_option($icon))).'" target="_blank" class="bg-primary rounded-circle text-white text-center text-decoration-none d-flex align-items-center justify-content-center company-social-icons bi bi-pinterest">
								</a>';
							}else if(strpos($icon, 'instagram') !== false) {
								echo '<a href="'.esc_url(trim(get_option($icon))).'" target="_blank" class="bg-primary rounded-circle text-white text-center text-decoration-none d-flex align-items-center justify-content-center company-social-icons bi bi-instagram">
								</a>';
							}
						}
					}
				?>
				</div>

				<!-- Address and Contact number -->
				<p class="mb-2">Address: <a class="text-black text-decoration-none" href="https://maps.app.goo.gl/au5gYeqN8tZQCAkJA" target="_blank">2443 Filmore St #380-6097 San Francisco CA 94115</a></p>
				<p class="mb-2">Phone: <a class="text-black text-decoration-none" href="tel:16282286254">(628) 228-6254</a></p>
			</div>
		</div>
		<div class="d-flex align-items-center justify-content-center pt-4">
			<p class="text-dark text-capitalize p-0 m-0 text-center">
			<?php echo str_replace('{current_year}', Date('Y'), trim(get_option('footer_copyright_text_option'))); ?></p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal-width">
    <div class="modal-content rounded-0">
      <div class="modal-body p-0">
		<div class="container-fluid ">
			<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-close position-absolute top-8 end-0 m-3 cursor-pointer custom-close-btn-cls"></button>

			<div class="row">
				<div class="col-lg-4 p-0"><img src="<?php echo get_template_directory_uri() ?>/assets/images/left-side-popup-img.jpeg" class="h-100 w-100" alt="" srcset=""></div>
				<div class="col-lg-8 text-center pb-3 pt-4 custom-px position-relative" style="background-image: url('<?php echo get_template_directory_uri() ?>/assets/images/right-sidebg-img.jpeg');">
				
					<div class="overlay"></div>
					<div class="custom-modal-inner-content position-relative" >
						<img class="w-40 mb-3" src="<?php echo get_template_directory_uri() ?>/assets/images/light_automotive.svg" alt="" srcset="">
						<h3 class="fs-2 mb-4 custom-font-family">In our monthly news letter you’ll receive</h3>
						<h2 class="custom-fs fw-bold mb-4 custom-font-family">START LEARNING ABOUT SMART HOMES</h2>
						<p class="fs-2  custom-font-family">News & annoucements</p>
						<p class="fs-2  custom-font-family">New Aritcles</p>
						<p class="fs-2 mb-4  custom-font-family">New Releases</p>
						<form action="javascript:void(0);" class="d-flex flex-column" method="post">
						
							<input class="form-control fs-4 py-3 mb-4 px-3  custom-font-family" type="email" placeholder="Enter your email" name="email" id="email">
							<input class="btn btn-primary p-3 text-light bg-primary fs-1 mb-4 mt-3  custom-font-family" type="submit" value="SUBSCRIBE">
						</form>
						<p class="fs-2 pb-3 mt-3  custom-font-family">No spam, Unsubscribe any time</p>
					</div>
				</div>
			</div>
		</div>
					
      </div>
    </div>
  </div>
</div>


<!---------- Popup End ------------------------------->


<?php wp_footer(); ?>

</body>
</html>
