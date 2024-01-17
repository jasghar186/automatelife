<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package automate_life
 */

get_header();
?>

	<main id="primary" class="site-main">

	<section>
		<h1 class="fs-4 text-dark fw-bold">Blog</h1>

	</section>

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header class="bg-primary pt-5 pb-5">
					<h1 class="page-title blog-header-title m-0 text-white fw-bold text-center"><?php single_post_title(); ?></h1>
					<div class="pb-5 mb-5"></div>
				</header>
				<?php
			endif;
			
			echo '<div class="container-fluid">';
			echo '<div class="row mt-5">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			echo '</div>';
			echo '</div>';

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
