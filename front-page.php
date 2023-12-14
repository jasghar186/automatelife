<?php get_header(); ?>

<!-- Hero Section -->
<section class="container-fluid hero-section border-bottom border-dark">
    <div class="row h-100">
        <div class="col-12 col-md-7 position-relative d-flex flex-column justify-content-center mb-5">
            <p class="text-primary-user m-0 text-capitalize">Hello I'm Marty Spargo</p>
            <h1 class="fw-semibold">Smart Homes <br><span class="text-primary-user">Expert</span></h1>
            <p class="fs-4 text-capitalize m-0">Freelance web designer and developer</p>

            <!-- Lead Form -->
            <form action="#" method="post" class="lead-form position-absolute bottom-0 w-50 d-inline-block">
                <label for="lead-email" class="w-100 d-block">
                    <input type="email" name="lead-email" id="lead-email"
                    placeholder="Enter Your Email Address" class="bg-primary placeholder-white p-3 rounded-3 w-100 text-light border-0">
                </label>
                <input type="submit" value="subscribe"
                class="bg-white text-dark text-capitalize text-center position-absolute top-50 border-0 translate-middle-y rounded-2">
            </form>
            <!-- Lead Form -->
        </div>
        <div class="col-12 col-md-5 bg-primary h-100 position-relative">
            <img src="<?php echo site_url(); ?>/wp-content/themes/automate-life/assets/images/home_hero_man.png" alt="Automate life"
            loading="lazy" width="438" height="500" class="bottom-0 object-fit-contain position-absolute pe-none user-select-none">
        </div>
    </div>
</section>

<!------------- Welcome Section ----------------->


<!------------- Covered Brands Section ----------------->
<section class="container-fluid <?php echo (site_layout_space !== false ? site_layout_space .'-space' : ''); ?>">
    <h2 class="fw-semibold text-capitalize mb-5 text-center text-secondary">covered brands</h2>
    <div class="row align-items-center">
        <div class="col d-flex align-items-center justify-content-center">
            <img src="<?php echo site_url(); ?>/wp-content/themes/automate-life/assets/images/covered-brands-1.png" alt="covered brands" loading="lazy"
            class="img-fluid object-fit-contain">
        </div>
        <div class="col d-flex align-items-center justify-content-center">
            <img src="<?php echo site_url(); ?>/wp-content/themes/automate-life/assets/images/covered-brands-2.png" alt="covered brands" loading="lazy"
            class="img-fluid object-fit-contain">
        </div>
        <div class="col d-flex align-items-center justify-content-center">
            <img src="<?php echo site_url(); ?>/wp-content/themes/automate-life/assets/images/covered-brands-3.png" alt="covered brands" loading="lazy"
            class="img-fluid object-fit-contain">
        </div>
        <div class="col d-flex align-items-center justify-content-center">
            <img src="<?php echo site_url(); ?>/wp-content/themes/automate-life/assets/images/covered-brands-4.png" alt="covered brands" loading="lazy"
            class="img-fluid object-fit-contain">
        </div>
        <div class="col d-flex align-items-center justify-content-center">
            <img src="<?php echo site_url(); ?>/wp-content/themes/automate-life/assets/images/covered-brands-5.png" alt="covered brands" loading="lazy"
            class="img-fluid object-fit-contain">
        </div>
    </div>
</section>

<!------------- Our Smart Homes Experts Section ----------------->
<section class="container-fluid <?php echo (site_layout_space !== false ? site_layout_space .'-space' : ''); ?>">
    <h2 class="fw-semibold text-capitalize mb-5 text-center text-secondary">our smart homes experts</h2>

</section>

<!------------- Our Latest Videos Experts Section ----------------->
<section class="container-fluid <?php echo (site_layout_space !== false ? site_layout_space .'-space' : ''); ?>">
    <h2 class="fw-semibold text-capitalize mb-5 text-center text-secondary">our latest videos</h2>

</section>

<!------------- Smart Products In Stock Section ----------------->
<section class="container-fluid <?php echo (site_layout_space !== false ? site_layout_space .'-space' : ''); ?>">
    <h2 class="fw-semibold text-capitalize mb-5 text-center text-secondary">smart products in stock</h2>

</section>

<!------------- Recent Articles Section ----------------->
<section class="container-fluid <?php echo (site_layout_space !== false ? site_layout_space .'-space' : ''); ?>">
    <h2 class="fw-semibold text-capitalize mb-5 text-center text-secondary">Recent Articles</h2>
    <div class="row recent-articles">
    <?php
        $articlesArgs = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
        );
        $articlesPosts = get_posts($articlesArgs);
        if(!empty($articlesPosts)) {
            foreach($articlesPosts as $post) {
                echo '<div class="col-12 col-md-4">'.
                '<div class="post-card">'.
                '<div class="post-thumbnail d-flex justify-content-center mb-4">';
                if(has_post_thumbnail()) {
                   echo get_the_post_thumbnail();
                }else {
                    echo '<img src="'.site_url().'/wp-content/themes/automate-life/assets/images/dummy-post-thumbnail.png" alt="'.get_the_title().'"
                    loading="lazy" class="img-fluid"/>';
                }
                echo '</div>'.
                '<div class="post-content px-3">'.
                '<h3 class="text-center text-capitalize">
                <a href="'.get_the_permalink().'" class="text-decoration-none fw-semibol fs-3 text-dark">'.get_the_title().'</a>
                </h3>'.
                '<div class="d-flex align-items-center justify-content-center">'.
                '<a type="button" href="'.get_the_permalink().'" class="py-2 px-4 text-decoration-none bg-primary text-capitalize text-center rounded-circle-px">Read More</a>'.
                '</div>'.
                '</div>'.
                '</div>'. 
                '</div>';
            }
        }else {
            echo '<p class="lead text-capitalize">Sorry No posts found</p>';
        }
    ?>
    </div>
</section>

<!------------- Recent Articles Section ----------------->
<section class="container-fluid <?php echo (site_layout_space !== false ? site_layout_space .'-space' : ''); ?>">
    <h2 class="fw-semibold text-capitalize mb-5 text-center text-secondary">Featured Categories</h2>
    <div class="row recent-articles">
    <?php
        $categories = get_categories(array(
            'orderby' => 'name',
            'order'   => 'ASC',
            'number'  => 4, // Limit to 3 categories
        ));

        if(!empty($categories)) {
            foreach($categories as $category) {
                echo '<div class="col-12 col-md-4">'.
                '<div class="post-card">'.
                '<div class="post-thumbnail d-flex justify-content-center mb-4">';
                echo '<img src="'.site_url().'/wp-content/themes/automate-life/assets/images/dummy-post-thumbnail.png" alt="'.esc_attr($category->name).'"
                loading="lazy" class="img-fluid"/>';
                // if(has_post_thumbnail()) {
                //    echo get_the_post_thumbnail();
                // }else {
                    
                // }
                echo '</div>'.
                '<div class="post-content px-3">'.
                '<h3 class="text-center text-capitalize">
                <a href="'.esc_url(get_category_link($category->term_id)).'" class="text-decoration-none fw-semibol fs-3 text-dark">'.esc_html($category->name).'</a>
                </h3>'.
                '<div class="d-flex align-items-center justify-content-center">'.
                '<a type="button" href="'.esc_url(get_category_link($category->term_id)).'" class="py-2 px-4 text-decoration-none bg-primary text-capitalize text-center rounded-circle-px">Read More</a>'.
                '</div>'.
                '</div>'.
                '</div>'. 
                '</div>';
            }
        }else {
            echo '<p class="text-danger">Sorry, no categories found</p>';
        }
    ?>
    </div>
</section>

