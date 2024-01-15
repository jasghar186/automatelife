jQuery(document).ready(function ($) {
    // Approach using save button
    $('.save-display').click(function (e) {

        // Activate Loader
        let saveButton = $(this)
        $(saveButton).html(`<div class="ajax-admin-loader"></div>`)

        let dropdowns = $('.accordion-options-wrapper select');
        let toggleBoxes = $('.checkbox-toggle-wrapper input[type="checkbox"]')
        let colorValues = $('.color-picker-input input[type="text"]');
        let socialInputs = $('.control-panel-social-field')
        let textInputs = $('.control-panel-text-field')
        let textarea = $('.control-panel-textarea')
        let optionsArr = {};

        dropdowns.each(function (index, dropdown) {
            let dropdownId = $(dropdown).attr('id');
            let selectedValue = $(dropdown).val();
            // Keep the last selected value for each dropdownId
            optionsArr[dropdownId] = selectedValue;
        });

        toggleBoxes.each(function (index, toggleBox) {
            let toggleBoxId = $(toggleBox).attr('id');
            let selectedValue = $(toggleBox).val();

            // Keep the last selected value for each dropdownId
            optionsArr[toggleBoxId] = selectedValue;
        });

        colorValues.each(function (index, colorBox) {
            let colorId = $(colorBox).attr('id');
            let colorValue = $(colorBox).val()
            optionsArr[colorId] = colorValue;
        })

        socialInputs.each(function (index, input) {
            if ($(input).val().trim() !== '') {
                optionsArr[$(input).attr('id')] = $(input).val().trim()
            }
        })
        textInputs.each(function (index, input) {
            if ($(input).val().trim() !== '') {
                optionsArr[$(input).attr('id')] = $(input).val().trim()
            }
        })
        textarea.each(function (index, input) {
            if ($(input).val().trim() !== '') {
                optionsArr[$(input).attr('id')] = $(input).val().trim().split('\n')
            }
        })
                
        // let productsData = {};

        // Loop over products description and store in products data
        // function create_products_data(id, parameter, value) {
        //     if (id > 0) {
        //         if (!productsData[id]) {
        //             productsData[id] = {};
        //         }
        //         productsData[id][parameter] = value;
        //     }
        // }
        // $('.admin-product-image-container').each(function (index, data) {
        //     let id = parseInt($(data).find('img').attr('data_id'));
        //     create_products_data(id, 'id', id)
        // })
        // $('.products-title-field').each(function (index, field) {
        //     create_products_data(parseInt($(field).attr('data_id')), 'title', $(field).val().trim())
        // })
        // $('.products-description-field').each(function (index, description) {
        //     create_products_data(parseInt($(description).attr('data_id')), 'description', $(description).val().trim())
        // })
        // $('.products-price-field').each(function (index, price) {
        //     create_products_data(parseInt($(price).attr('data_id')), 'price', parseInt($(price).val().trim()))
        // })
        // $('.products-shopify-url').each(function (index, url) {
        //     create_products_data(parseInt($(url).attr('data_id')), 'url', $(url).val().trim())
        // })

        // if (Object.keys(productsData).length !== 0) {
        //     optionsArr['shopify-products-data'] = productsData;
        // }

        console.log('products data', optionsArr);

        // Update User Selected Records
        $.ajax({
            type: 'POST',
            url: admin_ajax.ajax_url,
            data: {
                optionsArr: optionsArr,
                action: 'automate_life_create_css',
            },
            success: function (response) {

                let res = JSON.parse(response);
                console.log('res', res)

                if(res.status !== 0) {
                    $(saveButton).html(res.response)
                }

                if(res.status === 0) {
                    alert(res.response)
                }

                setTimeout(() => {
                    $(saveButton).html('Save')
                }, 3000);
                
            },
            error: function (XHR, error, status) {
                $(saveButton).html('Records Failed To Update' + ' ' + status)
                setTimeout(() => {
                    $(saveButton).html('Save')
                }, 3000);
            }
        })

    });

    // Open Color Picker
    $('.site-color-picker').click(function () {
        $(this).parent().next().toggleClass('d-grid').toggleClass('d-none')
    })

    // Toggle Checkboxes on buttons click
    $('.checkbox-toggler-btn').click(function () {
        let attr = parseInt($(this).attr('data-checkbox'))
        if (attr === 0) {
            // User disabled
            console.log('user disabled')
            $(this).parent('.checkbox-toggle-wrapper').find('input').prop('checked', false).trigger('change')
        } else if (attr === 1) {
            // User enabled
            console.log('user enabled')
            $(this).parent('.checkbox-toggle-wrapper').find('input').prop('checked', true).trigger('change')
        }
    })

    // Change Checkboxes values on check, uncheck
    $('.values-toggle-checkbox').change(function (e) {
        let val = ( parseInt($(this).val()) === 0 ? 1 : 0 )
        $(this).val(val)
    })

    // Colors function

    $('.site-color-picker').on('input', function (e) {
        var inputValue = $(this).val();
        let errorWrapper = $(this).parents('.color-picker-wrapper');

        // Remove existing error messages
        errorWrapper.find('.hex-code-error-note').remove();

        // Check if the hex code is less than 3 characters
        if (inputValue.length < 3) {
            errorWrapper.prepend(`<p class="text-danger hex-code-error-note">
            Please enter a correct hex code.</p>`);
            return;
        }

        // Check if the hex code is greater than 7 characters
        if (inputValue.length > 7) {
            $(this).val(inputValue.slice(0, 7)); // Truncate the input value
            return;
        }

        // Check if the entered hex code is a valid color code
        if (!isValidHexCode(inputValue)) {
            errorWrapper.prepend(`<p class="text-danger hex-code-error-note">
            Entered code is not a correct color code.</p>`);
            return;
        }

        // If all conditions are met, apply the background color
        $(this).css('background-color', inputValue);
    });

    // Function to check if a string is a valid hex color code
    function isValidHexCode(hexCode) {
        var hexRegex = /^#[0-9A-Fa-f]{3,6}$/;
        return hexRegex.test(hexCode);
    }

    // Update Color input value on color block click
    $('.site-color-block').click(function (e) {
        $('#' + $(this).attr('data-parent')).val($(this).attr('data-color-code')).trigger('input')
    })

    // Open WordPress media Gallery on upload site logo click
    $('.upload-new-logo').click(function (e) {
        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }
        // Create a new media frame
        var frame = wp.media({
            title: 'Select or Upload Media',
            button: {
                text: 'Use this media'
            },
            multiple: false  // Set to true if you want to allow multiple selections
        });
        // When an image is selected in the media frame...
        frame.on('select', function () {
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();
            update_site_logo(attachment.id, attachment.url, false)

        });

        // Finally, open the media frame
        frame.open();
    })

    $('.remove-site-logo').click(() => update_site_logo(undefined, undefined, true))

    // Update Site Logo
    function update_site_logo(id, url, removeAction = false) {
        $.ajax({
            type: 'POST',
            url: admin_ajax.ajax_url,
            data: {
                LogoId: id,
                removeAction: removeAction,
                action: 'automate_life_update_site_logo'
            },
            success: function (response) {
                let res = JSON.parse(response)
                console.log(res)
                if (res.status === 1) {
                    // 1 means logo updated or inserted
                    $('#site-logo-attachment').attr('src', url);
                    $('.automate-life__aside .site-logo img').attr('src', url);
                    $('.upload-new-logo').removeClass('d-flex').addClass('d-none');
                    $('.official-website-logo').addClass('d-flex').removeClass('d-none');
                } else if (res.status === 3) {
                    // 3 means logo removed
                    $('.upload-new-logo').addClass('d-flex').removeClass('d-none');
                    $('.official-website-logo').removeClass('d-flex').addClass('d-none');
                }

            },
            error: function (XHR, error, status) {
                alert('Something went wrong please try again: ' + status)
                $('.upload-new-logo').addClass('d-flex').removeClass('d-none')
                $('.official-website-logo').removeClass('d-flex').addClass('d-none')
            }
        })
    }

    function uploadProductImage(elem) {
        let frame = wp.media({
            title: 'Select or Upload Product Image',
            button: {
                text: 'Upload'
            },
            multiple: false,
            library: {
                type: 'image' // Restrict to only images
            }
        });

        // Reopen if already open
        if (!frame) {
            frame.open();
            return;
        }

        frame.on('select', function () {
            let attachment = frame.state().get('selection').first().toJSON();
            $(elem).attr({
                src: attachment.url,
                data_id: attachment.id,
                alt: attachment.alt,
                title: attachment.title,
            })

            // Add id on products title, description, url and price field
            $(elem).parents('.col-12').find('.products-title-field').attr('data_id', attachment.id)
            $(elem).parents('.col-12').find('.products-description-field').attr('data_id', attachment.id)
            $(elem).parents('.col-12').find('.products-price-field').attr('data_id', attachment.id)
            $(elem).parents('.col-12').find('.products-shopify-url').attr('data_id', attachment.id)

            console.log(attachment);
        });

        frame.open();

    }

    $('.admin-product-image-container img').click((e) => uploadProductImage(e.target));

    // Remove Product Image
    $('.remove-admin-product-image').click(function () {
        let targetElem = $(this);

        $.ajax({
            type: 'POST',
            url: admin_ajax.ajax_url,
            data: {
                id: $(this).parents('.admin-product-image-container').find('img').attr('data_id'),
                action: 'remove_product_image',
            },
            success: function (response) {
                let container = $(targetElem).parents('.col-12')
                console.log(container)
                $(container).find('img.product-thumbnail').attr('src', response + '/wp-content/themes/automate-life/assets/images/dummy_product.webp').attr('data_id', 0);
                $(container).find('input[type="text"]').val('').attr('data_id', 0)
                $(container).find('textarea').val('').attr('data_id', 0)
            },
            error: function (XHR, error, status) {
                console.log(status)
            }
        })
    })

});
