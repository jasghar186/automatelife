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

    function automate_life_display_tab_content() {
        $display = '<div class="p-4">'.
        '<div class="d-flex align-items-center justify-content-between mb-4">'.
        '<h2 class="fs-3 mb-0">Display Settings</h2>'.
        '<button class="save-display save-options">Save</button>'.
        '</div>'.
        automate_life_add_accordion('display_tab-pane', 'font-size', 'font-size and typography').
        automate_life_add_accordion('display_tab-pane', 'site-colors', 'Colors').
        automate_life_add_accordion('display_tab-pane', 'post-meta', 'post meta').
        automate_life_add_accordion('display_tab-pane', 'site-images', 'Images').
        automate_life_add_accordion('display_tab-pane', 'site-footer', 'Footer').
        automate_life_add_accordion('display_tab-pane', 'site-layout', 'Layout').
        automate_life_add_accordion('display_tab-pane', 'social-links', 'Social Links').
        '</div>';
        return $display;
    }

    /*
        * Function to add a new accordion item in the tabs content
        * @param string $parent ID of the parent wrapper element
        * @param string $accordionBody Unique identifier for the accordion trigger
        * and the accordion body to make the accordion functional
        * @param string $title The Title of the accordion
        */

    function automate_life_add_accordion($parent, $accordionBody, $title) {
        $accordion = '<div class="accordion-item mb-4 border rounded-3">'.
        '<h2 class="accordion-header rounded-3">'.
        '<button class="accordion-button bg-white text-capitalize fs-5 text-dark rounded-3" type="button" data-bs-toggle="collapse"
        data-bs-target="#'.$accordionBody.'-accordion" aria-expanded="false"
        aria-controls="'.$accordionBody.'-accordion">'.
        $title.
        '</button>'.
        '</h2>'.
        '<div id="'.$accordionBody.'-accordion" class="accordion-collapse collapse"
        data-bs-parent="'.$parent.'-accordion">'.
        '<div class="accordion-body p-4">';
        
        if($accordionBody === 'font-size') {
            $accordion .= automate_life_dropdown_accordion('font-size-dropdown', 'Change font size', 'This will update the theme\'s body font size', '16px', $GLOBALS['font_size_options']);
            $accordion .= automate_life_dropdown_accordion('h1-font-size', 'H1 Font Size', 'This will determine the size of the H1 headings across your site.', 'Medium', $GLOBALS['h1_font_size_options']);
            $accordion .= automate_life_toggle_box_accordion('apply-to-h1-headings', 'Apply h1 Size to All Headings',
        'This will make all headings cascade sizes down from the H1 font size.', 'Disabled');

            $accordion .= automate_life_dropdown_accordion('body-font-family',
            'Body Font', 'This value is used to set the main font on the site.
            (Select a Web Safe font for best performance). <b>Note:</b> Some
            web-safe fonts are only available on either Mac or Windows devices.
            If your selected font is not available, another similar font will be
            displayed as a fallback font. <a href="#">Learn More</a>',
            'System Default (Web Safe)', $GLOBALS['body_font_options']);

            $accordion .= automate_life_dropdown_accordion('heading-font-family',
            'Heading Font', 'This value is used to set the heading font on the site.
            (Select a Web Safe font for best performance). <b>Note:</b> Some web-safe fonts
            are only available on either Mac or Windows devices. If your selected font is
            not available, another similar font will be displayed as a fallback font.
            <a href="#">Learn More</a>','System Default (Web Safe)',
            $GLOBALS['body_font_options']);

        }else if($accordionBody === 'post-meta') {
            $accordion .= automate_life_dropdown_accordion('post-meta-display-date',
            'Post Meta Display Date', 'Select which post meta to display in the post footer.',
            'Both', $GLOBALS['post_meta_options']);
        }else if($accordionBody==='site-images') {
            $accordion .= automate_life_dropdown_accordion('site-logo-attachment',
            'Site Logo', 'The site logo will display at full resolution in the header.
            We recommend using .jpg, .png. or .svg images. For best performance and
            display the image should be no taller than twice the value you\'ve
            selected for the maximum image height.','disable', get_option('site_logo'));
            $accordion .= automate_life_dropdown_accordion('change-logo-height',
            'Change Logo Height', 'This will update your max logo height in the header.',
            '75px', $GLOBALS['site_logo_height']);

            $accordion .= automate_life_toggle_box_accordion('display-blog-featured-images', 'Display featured images', 'Enable this option to display featured images on posts.', 'disabled');
            $accordion .= automate_life_toggle_box_accordion('hide-blog-featured-images-from-small-screen', 'Hide featured images from small screens', 'Enable this option to hide featured images on posts when the user has a device with a screen width lower than 600px (e.g. Mobile). Displaying featured images to mobile device will increase Largest Contentful Paint (LCP), one of Google\'s Core Web Vitals.', 'disabled');

        }else if($accordionBody === 'site-colors') {
            $accordion .= automate_life_colors_accordion('site-primary-color', 'Primary Color', 'This will set the color of some primary theme features like links, buttons and other elements.', $GLOBALS['site_colors']);
            $accordion .= automate_life_colors_accordion('site-secondary-color', 'Secondary Color', 'This will set the color of some primary theme features like links, buttons and other elements.', $GLOBALS['site_colors']);
            $accordion .= automate_life_colors_accordion('site-accent-color', 'Accent Color', 'This will set the color of some primary theme features like links, buttons and other elements.', $GLOBALS['site_colors']);
            $accordion .= automate_life_colors_accordion('site-h1-color', 'H1 Color', 'This will set the color of some primary theme features like links, buttons and other elements.', $GLOBALS['site_colors']);
            $accordion .= automate_life_toggle_box_accordion('apply-colors-to-h1-headings', 'Apply H1 Color to all headings', '
            This will make all headings inherit the H1 color.', 'disabled');
        }else if($accordionBody === 'site-footer') {
            $accordion .= automate_life_toggle_box_accordion('hide-promotion-footer-links', 'Hide Automate Life footer links', 'Enabling this option hides Mediavine/Trellis footer links.', 'disabled');
            $accordion .= automate_life_dropdown_accordion('footer-copyright-text',
            'Footer copyright text', 'Use this field to add personalized copyright to footer. This field supports HTML markup, including links.', null,
            $GLOBALS['body_font_options']);
        }else if($accordionBody === 'site-layout') {
            $accordion .= automate_life_toggle_box_accordion('enable-search-bar', 'Enable Search Bar',
            'Enabling this adds a search bar to the site header.', 'disabled');
            $accordion .= automate_life_dropdown_accordion('layout-space',
            'Layout Space', 'This will update the space around page elements.', 'Comfortable',
            $GLOBALS['layout_space']);
            $accordion .= automate_life_toggle_box_accordion('display-tag-links', 'Display Tag Links',
            'Enabling this setting will display tag links after the post content.', 'Enabled');
            $accordion .= automate_life_toggle_box_accordion('article-navigation', 'Article Navigation',
            'Enable this option to display an Article Navigation (Previous/Next) at the bottom of your posts.', 'Enabled');
            $accordion .= automate_life_toggle_box_accordion('enable-trellis-comments', 'Enable Trellis comments',
            'This will allow Trellis Comments to work across your site. If you are experiencing issues with a 3rd party comment tool, deactivating Trellis Comments may be necessary for compatibility.',
            'Enabled');
        }else if($accordionBody === 'social-links') {
            $accordion .= automate_life_social_links('twitter-social-url', 'Twitter');
            $accordion .= automate_life_social_links('facebook-social-url', 'Facebook');
            $accordion .= automate_life_social_links('tiktok-social-url', 'Tiktok');
            $accordion .= automate_life_social_links('youtube-social-url', 'Youtube');
            $accordion .= automate_life_social_links('pinterest-social-url', 'Pinterest');
            $accordion .= automate_life_social_links('instagram-social-url', 'Instagram');
        }

        $accordion .= '</div>'.
        '</div>'.
        '</div>';

        return $accordion;
    }

    $GLOBALS['user_selected_options'] = array(
        'font-size-dropdown' => get_option('base_font_size'),
        'h1-font-size' => get_option('h1_font_size'),
        'body-font-family' => get_option('body_font_family'),
        'heading-font-family' => get_option('heading_font_family'),
        'change-logo-height' => get_option('base_logo_height'),
        'apply-to-h1-headings' => get_option('apply-to-h1-headings'),
        'featured-image-size' => get_option('featured-image-size'),
        'hide-promotion-footer-links' => get_option('hide-promotion-footer-links'),
        'site-primary-color' => get_option('site-primary-color'),
        'site-secondary-color' => get_option('site-secondary-color'),
        'site-accent-color' => get_option('site-accent-color'),
        'site-h1-color' => get_option('site-h1-color'),
        'apply-colors-to-h1-headings' => get_option('apply-colors-to-h1-headings'),
        'display-blog-featured-images' => get_option('display-blog-featured-images'),
        'hide-blog-featured-images-from-small-screen' => get_option('hide-blog-featured-images-from-small-screen'),
        'hide-promotion-footer-links' => get_option('hide-promotion-footer-links'),
        'post-meta-display-date' => get_option('post-meta-display-date'),
        'footer-copyright-text' => get_option('footer-copyright-text'),
        'enable-search-bar' => get_option('enable-search-bar'),
        'display-tag-links' => get_option('display-tag-links'),
        'article-navigation' => get_option('article-navigation'),
        'enable-trellis-comments' => get_option('enable-trellis-comments'),
        'layout-space' => get_option('layout-space'),
    );

    /*
    *** Function to display accordion's dropdown content
    *** @param string $uniqueLabel A unique string of each dropdown filter
    *** @param string $title The title of the accordion
    *** @param string $description The description of the content
    *** @param string $default A default base value of the filter
    *** @param array $options Array of the dropdown options */

    function automate_life_dropdown_accordion($uniqueLabel, $title, $description, $default ='', $options) {
        $content = '<div class="d-flex align-items-center accordion-body-content border rounded-3 mb-3 dropdown-accordion-wrapper">'.
        '<div class="p-4 border-end flex-grow-1 w-50">'.
        '<label for="'.$uniqueLabel.'" class="fs-6">'.$title.'</label>'.
        '<p class="mb-1 fw-light para-color">'.$description.'</p>'.
        '<i class="para-color fw-light fs-6">(Default: '.$default.')</i>'.
        '</div>'.
        '<div class="p-4 flex-grow-1 w-50">';
        
        // Check if its site logo accordion content
        if(!is_array($options) && $uniqueLabel === 'site-logo-attachment') {
            $logo_url = wp_get_attachment_image_url($options);
            $logo_attachment_metadata = wp_get_attachment_metadata($options);
            // Extract relevant information
            $attachment_alt = get_post_meta($logo_url, '_wp_attachment_image_alt', true);

            $content .= '<div class="change-site-logo-wrapper">'.
            '<div class="upload-new-logo cursor-pointer border rounded align-items-center justify-content-center '.(!$logo_url ? 'd-flex' : 'd-none').'">'.
            '<img src="'.site_url().'/wp-content/themes/automate-life/assets/images/upload-site-logo.png" alt="Upload Site Logo" loading="lazy" 
            width="30" height="30" />'.
            '</div>'.
            '<div class="official-website-logo position-relative '.(!$logo_url ? 'd-none' : 'd-flex').'">'.
            '<img id="'.$uniqueLabel.'" src="'.$logo_url.'" width="223" height="230"
            alt="'.$attachment_alt.'" loading="lazy" class="img-fluid admin-selected-logo d-block mx-auto" />'.
            '<div class="position-absolute end-0 top-0 bg-dark remove-site-logo">'.
            '<img src="'.site_url().'/wp-content/themes/automate-life/assets/images/remove-logo.png" alt="remove logo"
            loading="lazy" width="32" height="32" />'.
            '</div>'.
            '</div>'.
            '</div>';

        }else if($uniqueLabel === 'footer-copyright-text'){
            $content .= '<input type="text" placeholder="Footer Copyright Text" class="w-100 p-2" id="'.$uniqueLabel.'" value="'.$GLOBALS['user_selected_options'][$uniqueLabel].'" />';
        }else {
            $content .= '<select id="'.$uniqueLabel.'" class="w-100 py-1">';
            foreach($options as $key => $value) {
                if($uniqueLabel === 'body-font-family' || $uniqueLabel === 'heading-font-family') {
                    $value = htmlspecialchars($value, ENT_QUOTES);
                }
                $content .= '<option id="option-'.$value.'"
                value="'.$value.'" '.(htmlspecialchars_decode($value, ENT_QUOTES) === preg_replace('/[\\\\]/', '', $GLOBALS['user_selected_options'][$uniqueLabel]) ?
                'selected' : '').' data-val="'.$GLOBALS['user_selected_options']['body-font-family'].'">'
                .$key.'</option>';
            }
            $content .= '</select>';
        }
       
        $content .= '</div>'.
        '</div>';

        return $content;
    }


    /* Function to display colors accordion content
    *** @param string $uniqueLabel A unique string for each colors accordion
    *** @param string $title The title of the accordion
    *** @param string $description The description of the accordion
    *** @param array $options Array of the available options of colors ***/

    function automate_life_colors_accordion($uniqueLabel, $title, $description, $options) {
        $content = '<div class="d-flex align-items-center accordion-body-content border rounded-3 mb-3 dropdown-accordion-wrapper">'.
        '<div class="p-4 border-end flex-grow-1 w-50">'.
        '<label for="'.$uniqueLabel.'" class="fs-6">'.$title.'</label>'.
        '<p class="mb-1 fw-light para-color">'.$description.'</p>'.
        '</div>'.
        '<div class="p-4 flex-grow-1 w-50">'.

        // Wrapper div
        '<div class="color-picker-wrapper position-relative">'.
        // Colors input
        '<div class="color-picker-input border p-2 rounded">'.
        '<input type="setting" id="'.$uniqueLabel.'"
        data-color="'.($GLOBALS['user_selected_options'][$uniqueLabel] !== false ? $GLOBALS['user_selected_options'][$uniqueLabel] : $options['black']).'"
        class="text-white site-color-picker text-center p-2 w-100" data-parent="'.$uniqueLabel.'"
        value="'.($GLOBALS['user_selected_options'][$uniqueLabel] !== false ? $GLOBALS['user_selected_options'][$uniqueLabel] : $options['black']).'" style="background:'.($GLOBALS['user_selected_options'][$uniqueLabel] !== false ? $GLOBALS['user_selected_options'][$uniqueLabel] : $options['black']).'" />'.
        '</div>'.
        // Colors Dropdown
        '<div class="color-picker-dropdown position-absolute top-100 d-none w-auto bg-white p-3 shadow-sm border z-1">';
        foreach($options as $color => $code) {
            $content .= '<span class="site-color-block rounded d-inline-block cursor-pointer" data-color-code="'.$code.'"
            data-color-name="'.$color.'" data-parent="'.$uniqueLabel.'"
            style="background:'.$code.'"></span>';
        }
        $content .= '</div>'.
        '</div>'.
        '</div>'.
        '</div>';

        return $content;
    }

    /* Function to display checkboxes accordion content
    *** @param string $uniqueLabel A unique string for each checkbox accordion
    *** @param string $title The title of the accordion
    *** @param string $description The description of the accordion
    *** @param string $default A default value ***/

    function automate_life_toggle_box_accordion($uniqueLabel, $title, $description, $default = '') {
        $content = '<div class="d-flex align-items-center accordion-body-content border rounded-3 mb-3 dropdown-accordion-wrapper">'.
        '<div class="p-4 border-end flex-grow-1 w-50">'.
        '<label for="'.$uniqueLabel.'" class="fs-6">'.$title.'</label>'.
        '<p class="mb-1 fw-light para-color">'.$description.'</p>'.
        '</div>'.
        '<div class="p-4 flex-grow-1 w-50">'.

        // Wrapper div
        '<div class="checkbox-toggle-wrapper gap-3 d-flex align-items-center justify-content-center" data-target="'.$uniqueLabel.'">'.
        '<button data-parent="'.$uniqueLabel.'" class="bg-transparent border-0 p-0 checkbox-toggler-btn" data-checkbox="0">Disabled</button>'.
        '<input type="checkbox" class="values-toggle-checkbox" id="'.$uniqueLabel.'" value="'.(intval($GLOBALS['user_selected_options'][$uniqueLabel]) !== false ? intval($GLOBALS['user_selected_options'][$uniqueLabel]) : 0).'" '.(intval($GLOBALS['user_selected_options'][$uniqueLabel]) === 1 ? 'checked' : '').' />'.
        '<button data-parent="'.$uniqueLabel.'" class="bg-transparent border-0 p-0 checkbox-toggler-btn" data-checkbox="1">Enable</button>'.
        '</div>'.

        '</div>'.
        '</div>';

        return $content;   
    }

    // Social Media Links
    function automate_life_social_links($uniqueLabel, $title) {
        $inputValueArr = array();
        foreach(COMPANY_SOCIALS_URLS as $url) {
            if(!isset($inputValueArr[$url])) {
                $inputValueArr[$url] = esc_url(trim(get_option($url))); 
            }
        } 
        $content = '<div '.serialize($inputValueArr).' class="d-flex align-items-center accordion-body-content border rounded-3 mb-3 socials-accordion-wrapper">'.
        '<div class="p-4 border-end flex-grow-1 w-50">'.
        '<label for="'.$uniqueLabel.'" class="fs-6">'.$title.'</label>'.
        '</div>'.
        '<div class="p-4 flex-grow-1 w-50">'.
        '<input type="text" value="'.(array_key_exists($uniqueLabel, $inputValueArr) && !empty($inputValueArr[$uniqueLabel]) ?
        $inputValueArr[$uniqueLabel] : '').'" id="'.$uniqueLabel.'" class="'.$uniqueLabel.'
         text-truncate w-100 p-2 form-control socials-input-box" placeholder="Enter '.$title.' URL" />'.
        '</div>'.
        '</div>';

        return $content;
    }