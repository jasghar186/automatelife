<?php

    /**
     * Include options file to use options values
     */
    require_once get_template_directory() . '/template-parts/accordion-options.php';

    function automate_life_options_page() {

        // Get Site Logo
        $site_logo = get_option('site_logo');
        $site_logo_url = wp_get_attachment_image_url($site_logo);
        if($site_logo_url) {
            // Get attachment metadata
            $attachment_metadata = wp_get_attachment_metadata($site_logo);

            // Extract relevant information
            $attachment_alt = get_post_meta($site_logo, '_wp_attachment_image_alt', true);
            $attachment_width = $attachment_metadata['width'];
            $attachment_height = $attachment_metadata['height'];
        }

        $page = '<main class="wrap d-flex automate-life__optios m-0 w-100 min-vh-100 gap-5">'.

        '<aside class="automate-life__aside bg-white d-flex justify-content-center flex-column align-items-center p-3 position-sticky top-0 start-0 vh-100">';
        
        if($site_logo_url) {
            $page .= '<div class="site-logo d-flex justify-content-center flex-column align-items-center gap-2 mb-4">'.
            '<img src="'.$site_logo_url.'" alt="'.$attachment_alt.'" width="'.$attachment_width.'"
            height="'.$attachment_height.'" loading="lazy" title="'.$attachment_alt.'"
            class="img-fluid" />'.
            '<h2 class="text-capitalize font-roboto text-primary-admin m-0">Automate Life</h2>'.
            '</div>';
        }
        
        // Tabs
        $page .= '<ul class="nav flex-column w-100" id="automate_life_options_tabs" role="tablist">'.
        '<li class="nav-item d-flex justify-content-start align-items-center" role="presentation">'.
        '<img src="'.get_template_directory_uri().'/assets/images/display.png" width="25" height="25" loading="lazy" />'.
        '<button class="nav-link text-tabs p-2 active" id="display_tab"
        data-bs-toggle="tab" data-bs-target="#display_tab-pane"
        type="button" role="tab" aria-controls="display_tab-pane"
        aria-selected="true">Display</button>'.
        '</li>'.
        '<li class="nav-item d-flex justify-content-start align-items-center" role="presentation">'.
        '<img src="'.get_template_directory_uri().'/assets/images/advanced.png" width="25" height="25" loading="lazy" />'.
        '<button class="nav-link text-tabs p-2" id="advanced_tab" data-bs-toggle="tab"
        data-bs-target="#advanced_tab-pane" type="button" 
        role="tab" aria-controls="advanced_tab-pane"
        aria-selected="false">Advanced</button>'.
        '</li>'.
        '<li class="nav-item d-flex justify-content-start align-items-center" role="presentation">'.
        '<img src="'.get_template_directory_uri().'/assets/images/hooks.png" width="25" height="25" loading="lazy" />'.
        '<button class="nav-link text-tabs p-2" id="hooks_tab" data-bs-toggle="tab"
        data-bs-target="#hooks_tab-pane" type="button" role="tab"
        aria-controls="hooks_tab-pane" aria-selected="false">Hooks</button>'.
        '</li>'.
        '<li class="nav-item d-flex justify-content-start align-items-center" role="presentation">'.
        '<img src="'.get_template_directory_uri().'/assets/images/critical-css.png" width="25" height="25" loading="lazy" />'.
        '<button class="nav-link text-tabs p-2" id="critical_css_tab" data-bs-toggle="tab"
        data-bs-target="#critical_css_tab-pane" type="button" role="tab"
        aria-controls="critical_css_tab-pane" aria-selected="false">Critical CSS</button>'.
        '</li>'.
        '</ul>'.
        '</aside>'.
        // Tabs Content
        automate_life_options_tab_content().
        '</main>';

        return $page;
    }

    /**
     * Function to display the tabs content 'automate_life_options_tab_content'
     */

    function automate_life_options_tab_content() {
        $options = '<div class="tab-content automate-life__content-wrap flex-grow-1 bg-white" id="automate_life_options_tabsContent">'.
        '<div class="tab-pane accordion min-vh-100 show active" id="display_tab-pane"
        role="tabpanel" aria-labelledby="display_tab" 
        tabindex="0">'.automate_life_display_tab_content().'</div>'.
        '<div class="tab-pane min-vh-100" id="advanced_tab-pane" role="tabpanel" aria-labelledby="advanced_tab" tabindex="0">profile</div>'.
        '<div class="tab-pane min-vh-100" id="hooks_tab-pane" role="tabpanel" aria-labelledby="hooks_tab" tabindex="0">contact</div>'.
        '<div class="tab-pane min-vh-100" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>'.
        '</div>';

        return $options;
    }  

    /********************************8 */
    class automate_life_accordion_options {

        public $accordionTitle, $parent, $function;
        const TOGGLE_DISABLED = 0;
        const TOGGLE_ENABLED = 1;

        function __construct($accordionTitle, $parent, $function) {
            $this->accordionTitle = $accordionTitle;
            $this->parent = $parent;
            $this->id = strtolower( trim( str_replace(' ', '_', $accordionTitle) ) );
            $this->function = $function;
        }

        // Make Accordion Item
        function accordion_item() {
            $item = '<div class="accordion-item mb-4 border rounded-3">'.
            $this->accordion_header().
            $this->accordion_body().
            '</div>';

            return $item;
        }
        // Make Accordion Header
        function accordion_header() {
            $header = '<h2 class="accordion-header rounded-3">'.
            '<button class="accordion-button bg-white text-capitalize fs-5 text-dark rounded-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#'.$this->id.'_accordion" aria-expanded="false"
            aria-controls="'.$this->id.'_accordion">'.
            $this->accordionTitle.
            '</button>'.
            '</h2>';

            return $header;
        }

        function accordion_body() {
            $body = '<div id="'.$this->id.'_accordion" class="accordion-collapse collapse"
            data-bs-parent="'.$this->parent.'_accordion">'.
            '<div class="accordion-body p-4">'.
            $this->{$this->function}().
            '</div>'.
            '</div>';

            return $body;
        }

        function option_left_structure($title, $description = '', $default = '') {
            $id = strtolower( trim( str_replace(' ', '_', $title) ) );

            $left = '<div class="p-4 border-end flex-grow-1 w-50">'.
            '<label for="'.$id.'_option" class="fs-6 text-capitalize">'.$title.'</label>';
            if(!empty($description)) {
                $left .= '<p class="mb-1 fw-light para-color">'.$description.'</p>';
            }
            
            if(!empty($default)) {
                $left .= '<i class="para-color fw-light fs-6">(Default: '.$default.')</i>';
            }
            $left .= '</div>';

            return $left;
        }

        // Make instances for each accordion

        function option_wrapper($contentLeft = '', $contentRight = '') {
            return '<div class="d-flex align-items-center accordion-body-content border rounded-3 mb-3 accordion-options-wrapper">'.
            $contentLeft.
            $contentRight.
            '</div>';
        }

        function option_right_structure_dropdown($title, $options) {

            $id = strtolower( trim( str_replace(' ', '_', $title) ) );

            $selected = '';

            $dropdown = '<div class="p-4 flex-grow-1 w-50">'.
            '<select id="'.$id.'_option" class="w-100 py-1">';

            foreach($options as $key => $value) {
                if( get_option($id . '_option') !== false && htmlspecialchars(get_option($id . '_option'), ENT_QUOTES) === htmlspecialchars($value, ENT_QUOTES) ) {
                    $selected = 'selected';
                }

                $dropdown .= '<option
                id="option-'.htmlspecialchars($value, ENT_QUOTES).'"
                value="'.htmlspecialchars($value, ENT_QUOTES).'"
                '. $selected .'>'.$key.'</option>';

                $selected = '';
            }

            $dropdown .= '</select>'.
            '</div>';

            return $dropdown;
        }

        function option_right_structure_toggle($title) {
            $id = strtolower( trim( str_replace(' ', '_', $title) ) );
            $optionEnabled = intval(get_option($id . '_option'));

            $checked = '';
            if($optionEnabled === 1) {
                $checked = 'checked';
            }

            $toggle = '<div class="p-4 flex-grow-1 w-50">'.
            // Wrapper div
            '<div class="checkbox-toggle-wrapper gap-3 d-flex align-items-center justify-content-center" data-target="'.$id.'">'.
            '<button data-parent="'.$id.'"
            class="bg-transparent border-0 p-0 checkbox-toggler-btn"
            data-checkbox="'.self::TOGGLE_DISABLED.'">Disabled</button>'.
            '<input type="checkbox"
            class="values-toggle-checkbox"
            id="'.$id.'_option"
            value="'.($optionEnabled === 1 ? self::TOGGLE_ENABLED : self::TOGGLE_DISABLED).'"
            '.$checked.'/>'.
            '<button data-parent="'.$id.'"
            class="bg-transparent border-0 p-0 checkbox-toggler-btn"
            data-checkbox="'.self::TOGGLE_ENABLED.'">Enable</button>'.
            '</div>'.
    
            '</div>';

            return $toggle;
        }

        function option_right_structure_colors($title) {

            $id = strtolower( trim( str_replace(' ', '_', $title) ) );

            $colorOption = 'fff';

            if(get_option($id . '_option')) {
                $colorOption = get_option($id . '_option');
            }

            $colorContent = '<div class="p-4 flex-grow-1 w-50">'.
            '<div class="color-picker-wrapper position-relative">'.
            '<div class="color-picker-input border p-2 rounded">'.
            '<input
            type="text"
            id="'.$id.'_option"
            data-color="'.$colorOption.'"
            class="text-white site-color-picker text-center p-2 w-100"
            data-parent="site-primary-color"
            value="'.$colorOption.'"
            style="background:'.$colorOption.'" />'.
            '</div>'.
            '<div class="color-picker-dropdown position-absolute top-100 d-none w-auto bg-white p-3 shadow-sm border z-1">';
            foreach($GLOBALS['site_colors'] as $color => $code) {
                $colorContent .= '<span class="site-color-block rounded d-inline-block cursor-pointer"
                data-color-code="'.$code.'"
                data-color-name="'.$color.'"
                data-parent="'.$id.'_option"
                style="background:'.$code.'"></span>';
            }
            $colorContent .= '</div>'.
            '</div>'.
            '</div>';

            return $colorContent;
        }

        function option_right_structure_image($title, $attachment_id) {
            $id = strtolower( trim( str_replace(' ', '_', $title) ) );

            $logo_url = wp_get_attachment_image_url($attachment_id);
            $logo_attachment_metadata = wp_get_attachment_metadata($attachment_id);
            $attachment_alt = get_post_meta($logo_url, '_wp_attachment_image_alt', true);


            $image = '<div class="p-4 flex-grow-1 w-50">'.

            '<div class="upload-new-logo cursor-pointer border rounded align-items-center justify-content-center '.
            (!$logo_url ? 'd-flex' : 'd-none').'">'.
            '<img
            src="'.site_url().'/wp-content/themes/automate-life/assets/images/upload-site-logo.webp"
            alt="Upload Site Logo"
            loading="lazy" 
            width="30" height="30" />'.
            '</div>'.

            '<div class="official-website-logo position-relative '.
            (!$logo_url ? 'd-none' : 'd-flex').'">'.
            '<img id="'.$id.'"
            src="'.$logo_url.'" width="223" height="230"
            alt="'.$attachment_alt.'"
            loading="lazy"
            class="img-fluid admin-selected-logo d-block mx-auto" />'.
            '<div class="position-absolute end-0 top-0 bg-dark remove-site-logo">'.
            '<img src="'.site_url().'/wp-content/themes/automate-life/assets/images/remove-logo.webp"
            alt="remove logo"
            title="Remove Logo"
            loading="lazy" width="32" height="32" />'.
            '</div>'.
            '</div>'.

            '</div>';

            return $image;
        }

        function option_right_structure_text_field($title, $field_type = 'input', $isSocial = false, $socialPlatform = null, $placeholder = '') {
            $id = strtolower( trim( str_replace(' ', '_', $title) ) );

            $text = '<div class="p-4 flex-grow-1 w-50">';

            if($field_type === 'input') {
                $text .= '<input
                type="text"
                placeholder="'.$placeholder.'"
                class="w-100 p-2 '.$socialPlatform.'_social_url '.($isSocial ? 'control-panel-social-field' : 'control-panel-text-field').'"
                id="'.$id.'_option"
                value="'.(get_option($id . '_option') !== false ? trim(str_replace(Date('Y'), '{current_year}', get_option($id . '_option'))) : '').'">';
            }else if($field_type === 'textarea') {
                $value = get_option($id.'_option') !== false && get_option($id . '_option') !== null ?
                implode("\n", unserialize(get_option($id .'_option'))) :
                '';

                $text .= '<textarea
                class="form-control w-100 p-2 border border-dark control-panel-textarea"
                placeholder="'.$placeholder.'"
                id="'.$id.'_option"
                value="'.$value.'"
                style="min-height:150px;">'.$value.'</textarea>';
            }

            $text .= '</div>';

            return $text;
        }

        function font_size_and_typography() {
            // call left right layout functions

            return 
            
            /** 
             * Change Font Size Option
             */

            $this->option_wrapper(
            $this->option_left_structure(
            'change font size',
            'This will update the theme\'s body font size',
            '18px'),
            $this->option_right_structure_dropdown(
            'Change Font Size',
            $GLOBALS['font_size_options']
            )
            ).

            /**
             *  Heading 1 Font Size Option
             */

            $this->option_wrapper(
            $this->option_left_structure(
            'h1 font size',
            'This will determine the size of the H1 headings across your site.',
            'Medium'),
            $this->option_right_structure_dropdown(
            'H1 Font Size',
            $GLOBALS['h1_font_size_options']
            )
            ).

            /**
             * Apply heading H1 Font Size To All Headings
             */

            $this->option_wrapper(
            $this->option_left_structure(
            'apply h1 font size to all headings',
            'This will make all headings cascade sizes down from the H1 font size.',
            'disabled'),
            $this->option_right_structure_toggle('apply h1 font size to all headings')).

            /**
             * Body Font Family
             */
            $this->option_wrapper(
            $this->option_left_structure(
            'body font',
            'This value is used to set the main font on the site. (Select a Web Safe font for best performance). <b>Note:</b> Some web-safe fonts are only available on either Mac or Windows devices. If your selected font is not available, another similar font will be displayed as a fallback font.',
            'Arial'),
            $this->option_right_structure_dropdown(
            'body font',
            $GLOBALS['body_font_options']
            )
            ).

            /**
             * Headings Font Family
             */
            $this->option_wrapper(
            $this->option_left_structure(
            'heading font',
            'This value is used to set the heading font on the site. (Select a Web Safe font for best performance). <b>Note:</b> Some web-safe fonts are only available on either Mac or Windows devices. If your selected font is not available, another similar font will be displayed as a fallback font.',
            'Arial'),
            $this->option_right_structure_dropdown(
            'heading font',
            $GLOBALS['body_font_options']
            )
            );
            
        }

        function colors() {
            // call left right layout functions
            return 

            /**
             * Primary Color Option
             */
            $this->option_wrapper(
                $this->option_left_structure(
                    'Primary Color',
                    'This will set the color of some primary theme features like links, buttons and other elements.',
                ),
                $this->option_right_structure_colors('Primary Color'),
            ).

            /**
             * Secondary Color Option
             */
            $this->option_wrapper(
                $this->option_left_structure(
                    'Secondary Color',
                    'This will set the color of some primary theme features like links, buttons and other elements.',
                ),
                $this->option_right_structure_colors('Secondary Color'),
            ).

            /**
             * Accent Color Option
             */
            $this->option_wrapper(
                $this->option_left_structure(
                    'Accent Color',
                    'This will set the color of some primary theme features like links, buttons and other elements.',
                ),
                $this->option_right_structure_colors('Accent Color'),
            ).

            /**
             * Accent Color Option
             */
            $this->option_wrapper(
                $this->option_left_structure(
                    'H1 Color',
                    'This will set the color of some primary theme features like links, buttons and other elements.',
                ),
                $this->option_right_structure_colors('H1 Color'),
            ).

            /**
             * Accent Color Option
             */
            $this->option_wrapper(
                $this->option_left_structure(
                    'Apply h1 color to all headings',
                    'This will make all headings inherit the H1 color.',
                ),
                $this->option_right_structure_toggle('Apply h1 color to all headings'),
            );
        }

        function post_meta() {
            
            return

            $this->option_wrapper(
                $this->option_left_structure(
                    'post meta display date',
                    'Select which post meta to display in the post footer.',
                    'both',
                ),
                $this->option_right_structure_dropdown(
                    'post meta display date',
                    $GLOBALS['post_meta_options'],
                )
            );
        }

        function images() {
            return

            $this->option_wrapper(
                $this->option_left_structure(
                    'site logo',
                    'The site logo will display at full resolution in the header. We recommend using .jpg, .png. or .svg images. For best performance and display the image should be no taller than twice the value you\'ve selected for the maximum image height.',
                ),
                $this->option_right_structure_image('site logo', get_option('site_logo')),
            ).

            /** Change Logo Height */
            $this->option_wrapper(
                $this->option_left_structure(
                    'change logo height',
                    'This will update your max logo height in the header.',
                    '75px',
                ),
                $this->option_right_structure_dropdown(
                    'change logo height',
                    $GLOBALS['site_logo_height'],
                ),
            ).

            /** Display Featured Images */
            $this->option_wrapper(
                $this->option_left_structure(
                    'display featured images',
                    'Enable this option to display featured images on posts.',
                    'disabled',
                ),
                $this->option_right_structure_toggle(
                    'display featured images'
                ),
            ).

            /** Hide Featured Images From Small Screens */
            $this->option_wrapper(
                $this->option_left_structure(
                    'hide featured images from small screens',
                    'Enable this option to hide featured images on posts when the user has a device with a screen width lower than 600px (e.g. Mobile). Displaying featured images to mobile device will increase Largest Contentful Paint (LCP), one of Google\'s Core Web Vitals.',
                    'disabled',
                ),
                $this->option_right_structure_toggle(
                    'hide featured images from small screens'
                ),
            );
        }

        function footer() {
            return 
            $this->option_wrapper(
                $this->option_left_structure(
                    'footer copyright text',
                    'Use this field to add personalized copyright to footer. This field supports HTML markup, including links.',
                ),
                $this->option_right_structure_text_field(
                    'footer copyright text',
                    'input',
                    false,
                    null,
                    'Enter Footer Copyright Text',
                ),
            );            
        }

        function layout() {
            return 

            /**Enable Search Bar */
            $this->option_wrapper(
                $this->option_left_structure(
                    'enable search bar',
                    'Enabling this adds a search bar to the site header.',
                    'disabled',
                ),
                $this->option_right_structure_toggle(
                    'enable search bar',
                ),
            ).

            /** Layout Space */
            $this->option_wrapper(
                $this->option_left_structure(
                    'layout space',
                    'This will update the space around page elements.',
                    'Comfortable',
                ),
                $this->option_right_structure_dropdown(
                    'layout space',
                    $GLOBALS['layout_space'],
                ),
            ).

            /** Display Tag Links */
            $this->option_wrapper(
                $this->option_left_structure(
                    'display tag links',
                    'Enabling this setting will display tag links after the post content.',
                    'disabled',
                ),
                $this->option_right_structure_toggle(
                    'display tag links',
                ),
            ).

            /** Article Navigation */
            $this->option_wrapper(
                $this->option_left_structure(
                    'article navigation',
                    'Enable this option to display an Article Navigation (Previous/Next) at the bottom of your posts.',
                    'disabled',
                ),
                $this->option_right_structure_toggle(
                    'article navigation',
                ),
            );
        }

        function socialLinks() {
            return 

            /** Twitter */
            $this->option_wrapper(
                $this->option_left_structure(
                    'twitter',
                ),
                $this->option_right_structure_text_field(
                    'twitter',
                    'input',
                    true,
                    'twitter',
                    'Enter Twitter URL',
                ),
            ).

            /** Facebook */
            $this->option_wrapper(
                $this->option_left_structure(
                    'facebook',
                ),
                $this->option_right_structure_text_field(
                    'facebook',
                    'input',
                    true,
                    'facebook',
                    'Enter Facebook URL',
                ),
            ).

            /** Tiktok */
            $this->option_wrapper(
                $this->option_left_structure(
                    'tiktok',
                ),
                $this->option_right_structure_text_field(
                    'tiktok',
                    'input',
                    true,
                    'tiktok',
                    'Enter Tiktok URL',
                ),
            ).

            /** Youtube */
            $this->option_wrapper(
                $this->option_left_structure(
                    'youtube',
                ),
                $this->option_right_structure_text_field(
                    'youtube',
                    'input',
                    true,
                    'youtube',
                    'Enter Youtube URL',
                ),
            ).

            /** Pinterest */
            $this->option_wrapper(
                $this->option_left_structure(
                    'pinterest',
                ),
                $this->option_right_structure_text_field(
                    'pinterest',
                    'input',
                    true,
                    'pinterest',
                    'Enter Pinterest URL',
                ),
            ).

            /** Instagram */
            $this->option_wrapper(
                $this->option_left_structure(
                    'instagram',
                ),
                $this->option_right_structure_text_field(
                    'instagram',
                    'input',
                    true,
                    'instagram',
                    'Enter Instagram URL',
                ),
            );
        }

        function otherCustomizations() {
            return 
            /** Our Latest Videos */
            $this->option_wrapper(
                $this->option_left_structure(
                    'Our Latest Youtube Videos',
                    'Enter Youtube Videos Embed URLS (1 URL Per Line)',
                ),
                $this->option_right_structure_text_field(
                    'Our Latest Youtube Videos',
                    'textarea',
                    false,
                    null,
                    'Enter Youtube videos URL, 1 Per Line'
                ),
            ).

            /** Scroll Back To Top */
            $this->option_wrapper(
                $this->option_left_structure(
                    'scroll back to top',
                    'Enable this option to add scroll to top button in the website',
                ),
                $this->option_right_structure_toggle(
                    'scroll back to top'
                )
            );
        }

        function products() {
            $option_name = get_option('shopify_products_option'); 
            $id = ($option_name ? unserialize($option_name) : array()); // This will return an associate array
            // echo '<pre>';
            // print_r($id);
            // echo '</pre>';
            $product_content = '<div class="row">';

            for( $i = 0; $i < 3; $i++ ) {
                $image = wp_get_attachment_url($id[$i]['image']);
                $title = $id[$i]['title'];
                $price = $id[$i]['price'];
                $url   = $id[$i]['url'];
                $description = $id[$i]['description'];

                $product_content .= '<div class="col-4">'.
                // Below is the product card layout
                '<div class="admin-product-card-layout border shadow-sm">'.
                '<div class="admin-product-image-wrapper cursor-pointer" style="height: 185px;">';
                if($image) {
                    $attachment_metadata = wp_get_attachment_metadata($id[$i]['image']);
                    $alt_text = get_post_meta($id[$i]['image'], '_wp_attachment_image_alt', true);
                    $attachment_title = get_the_title($id[$i]['image']);
                    $image_width = isset($attachment_metadata['width']) ? $attachment_metadata['width'] : '';
                    $image_height = isset($attachment_metadata['height']) ? $attachment_metadata['height'] : '';

                    $product_content .= '<img src="'.esc_url($image).'"
                    alt="'.$alt_text.'"
                    title="'.$attachment_title.'"
                    loading="lazy"
                    class="img-fluid w-100 h-100 object-fit-contain admin-product-image"
                    width="'.$image_width.'"
                    height="'.$image_height.'"
                    data_attachment_id="'.$id[$i]['image'].'" />';
                }else {
                    $product_content .= '<img src="'.site_url().'/wp-content/themes/automate-life/assets/images/dummy_product.webp"
                    alt="Dummy Product Image" title="Dummy Product Image" loading="lazy" class="img-fluid w-100 h-100 object-fit-contain admin-product-image"
                    width="185" height="185" data_attachment_id="'.$id[$i]['id'].'" />';
                }
                $product_content .= '</div>'.
                '<div class="admin-product-card-content px-2 pb-3">'.
                '<label for="admin-product-title-'.$i.'">Product Title</label>'.
                '<input
                type="text"
                id="admin-product-title-'.$i.'"
                class="form-control p-1 text-truncate mb-2 text-capitalize admin-product-title-input"
                placeholder="Enter Product Title"
                value="'.$title.'" />'.
                '<label for="admin-product-price-'.$i.'">Product Price</label>'.
                '<input
                type="text"
                id="admin-product-price-'.$i.'"
                class="form-control p-1 text-truncate mb-2 admin-product-price-input"
                placeholder="Enter Product Price"
                value="'. number_format($price) .'" />'.
                '<label for="admin-product-url-'.$i.'">Product URL</label>'.
                '<input
                type="url"
                id="admin-product-url-'.$i.'"
                class="form-control p-2 mb-2 text-truncate admin-product-url-input"
                placeholder="Enter Product URL"
                value="'.$url.'" />'.
                '<label for="admin-product-description-'.$i.'">Product Description</label>'.
                '<textarea
                id="admin-product-description-'.$i.'"
                class="form-control p-2 admin-product-description-input"
                placeholder="Enter Product Description"
                style="min-height:150px;">'. nl2br(htmlspecialchars($description)) .'</textarea>'.
                '</div>'.
                '</div>'.
                '</div>';
            }

            $product_content .= '</div>';

            return $product_content;
        }
    }

    /*********************************** */


    function automate_life_display_tab_content() {
        $display = '<div class="p-4">'.
        '<div class="d-flex align-items-center justify-content-between mb-4">'.
        '<h2 class="fs-3 mb-0">Display Settings</h2>'.
        '<button class="save-display save-options">Save</button>'.
        '</div>';

        $font_size_typography = new automate_life_accordion_options('Font size and typography', 'display_tab_pane', 'font_size_and_typography');
        $colors = new automate_life_accordion_options('colors', 'display_tab_pane', 'colors');
        $post_meta = new automate_life_accordion_options('post meta', 'display_tab_pane', 'post_meta');
        $images = new automate_life_accordion_options('images', 'display_tab_pane', 'images');
        $footer = new automate_life_accordion_options('footer', 'display_tab_pane', 'footer');
        $layout = new automate_life_accordion_options('layout', 'display_tab_pane', 'layout');
        $socialLinks = new automate_life_accordion_options('social links', 'display_tab_pane', 'socialLinks');
        $otherCustomizations = new automate_life_accordion_options('Extra Options', 'display_tab_pane', 'otherCustomizations');
        $products = new automate_life_accordion_options('Shopify Products', 'display_tab_pane', 'products');

        $display .= $font_size_typography->accordion_item();
        $display .= $colors->accordion_item();
        $display .= $post_meta->accordion_item();
        $display .= $images->accordion_item();
        $display .= $footer->accordion_item();
        $display .= $layout->accordion_item();
        $display .= $socialLinks->accordion_item();
        $display .= $otherCustomizations->accordion_item();
        $display .= $products->accordion_item();

        $display .= '</div>';
        return $display;
    }