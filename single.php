<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package automate_life
 */

/**
 * Add Post ID in the cookies
 */
if (isset($_COOKIE['post-recently-viewed'])) {
    $ids = json_decode($_COOKIE['post-recently-viewed'], true);
    $currentPostID = get_the_ID();
    if (!in_array($currentPostID, $ids)) {
        $ids[] = $currentPostID;
    }
    setcookie('post-recently-viewed', json_encode($ids), time() + 24*60*60, '/');
} else {
    $ids = [get_the_ID()];
    setcookie('post-recently-viewed', json_encode($ids), time() + 24*60*60, '/');
}

get_header();

?>

	<main id="primary" class="site-main mt-5 pt-3">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'automate-life' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'automate-life' ) . '</span> <span class="nav-title">%title</span>',
				)
			);


		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();