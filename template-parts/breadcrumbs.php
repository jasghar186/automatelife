<?php
/**
 * Template part for displaying breadcrumbs in single blog pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package automate_life
 */

 ?>
<div class="automate-life-breadcrumbs">
    <nav class="automate-life-breadcrumb" aria-label="breadcrumb">
        <a href="<?php echo esc_url( site_url() ); ?>"
        class="text-dark text-decoration-none font-sm me-2 d-inline-block">Home</a>
        <?php
            // Get category associated with blog
            $category = get_the_category();
            $categoryLen = count($category);

            if($category && $category[$categoryLen - 1]->name !== 'Uncategorized' ) {
                echo '<span class="separator me-2 text-dark font-sm d-inline-block">&gt;</span>'.
                '<a
                class="text-dark text-decoration-none font-sm text-capitalize me-2 d-inline-block"
                href="'.esc_url(get_category_link($category[$categoryLen - 1]->term_id)).'">
                '.esc_html($category[$categoryLen - 1]->name).'</a>';
            }
        ?>
        <span class="separator me-2 text-dark font-sm">&gt;</span>
        <?php
        echo '<span class="last text-dark font-sm text-capitalize">'.get_the_title().'</a>';
        ?>
    </nav>
</div>