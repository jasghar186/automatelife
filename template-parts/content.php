<?php
/**
 * Template part for displaying posts content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package automate_life
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col col-md-6 col-lg-4'); ?>>
	<div class="shadow-sm h-100">
		<?php automate_life_post_thumbnail(); ?>

		<div class="entry-content mt-5 px-3">
			<header class="entry-header mt-5 mb-2">
				<?php the_title( '<a href="'.get_the_permalink().'"
				class="text-dark text-decoration-none text-capitalize">
				<h3 class="entry-title fw-light lh-sm font-30 m-0">', '</h3></a>' ); ?>
			</header><!-- .entry-header -->

			<div class="blog-post-content mt-0">
				<?php
				$post_content = trim(strip_tags(get_the_content()));

				if (str_word_count($post_content) > 20) {
					$words = preg_split("/\s+/", $post_content);
					$truncated_content = implode(' ', array_slice($words, 0, 20));
					// Now $truncated_content contains the first 20 words of the post content
					echo $truncated_content . '...';
				}else {
					echo $post_content;
				}
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer mt-5">
				<?php
					echo '<span class="text-capitalize font-md fw-light">By '.get_the_author().'</span>';
				?>
			</footer><!-- .entry-footer -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->