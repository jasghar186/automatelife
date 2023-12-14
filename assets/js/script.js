jQuery(document).ready(function($) {
    // Approach using save button
    $('.save-display').click(function(e) {

        // Activate Loader
        let saveButton = $(this)
        $(saveButton).html(`<div class="ajax-admin-loader"></div>`)

        let dropdowns = $('.dropdown-accordion-wrapper select');
        let toggleBoxes = $('.checkbox-toggle-wrapper input[type="checkbox"]')
        let colorValues = $('.color-picker-input input');
        let socialInputs = $('.socials-input-box')
        let optionsArr = {};

        dropdowns.each(function(index, dropdown) {
            let dropdownId = $(dropdown).attr('id');
            let selectedValue = $(dropdown).val();
            // Keep the last selected value for each dropdownId
            optionsArr[dropdownId] = selectedValue;
        });

        toggleBoxes.each(function(index, toggleBox) {
            let toggleBoxId = $(toggleBox).attr('id');
            let selectedValue = $(toggleBox).val();

            // Keep the last selected value for each dropdownId
            optionsArr[toggleBoxId] = selectedValue;
        });

        colorValues.each(function(index, colorBox) {
            let colorId = $(colorBox).attr('id');
            let colorValue = $(colorBox).val()
            optionsArr[colorId] = colorValue;
        })

        socialInputs.each(function(index, input) {
            if($(input).val().trim() !== '') {
                optionsArr[$(input).attr('id')] = $(input).val().trim()
            }
        })
        // Insert Footer copyright text in options arr
        optionsArr['footer-copyright-text'] = $('#footer-copyright-text').val().trim()
        // Update User Selected Records
        $.ajax({
            type: 'POST',
            url: admin_ajax.ajax_url,
            data: {
                optionsArr: optionsArr,
                action: 'automate_life_create_css',
            },
            success: function(response) {
                let res = JSON.parse(response);

                if(!Array.isArray(res) && res.length === undefined) {
                    alert('Please fix the Social URLS')
                    $(saveButton).html('Records Update Failed')
                    setTimeout(() => {
                        $(saveButton).html('Save')
                    }, 3000);
                    return;
                }else {
                    $(saveButton).html('Records Updated')
                    setTimeout(() => {
                        $(saveButton).html('Save')
                    }, 3000);
                }
            },
            error: function(XHR, error, status) {
                $(saveButton).html('Records Failed To Update')
                setTimeout(() => {
                    $(saveButton).html('Save')
                }, 3000);
            }
        })

    });

    // Open Color Picker
    $('.site-color-picker').click(function() {
        $(this).parent().next().toggleClass('d-grid').toggleClass('d-none')
    })

    // Toggle Checkboxes on buttons click
    $('.checkbox-toggler-btn').click(function() {
        let attr = parseInt($(this).attr('data-checkbox'))
        if(attr === 0) {
            // User disabled
            $(this).parent('.checkbox-toggle-wrapper').find('input').prop('checked', false).trigger('change')
        }else if(attr === 1) {
            // User enabled
            $(this).parent('.checkbox-toggle-wrapper').find('input').prop('checked', true).trigger('change')
        }
    })

    // Change Checkboxes values on check, uncheck
    $('.values-toggle-checkbox').change(function(e) {
        console.log($(this).val())
        $(this).val((parseInt($(this).val()) === 0 ? 1 : 0))
    })

    // Colors function
   
    $('.site-color-picker').on('input', function(e) {
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
    $('.site-color-block').click(function(e) {
        $('#' + $(this).attr('data-parent')).val($(this).attr('data-color-code')).trigger('input')
    })

    // Open WordPress media Gallery on upload site logo click
    $('.upload-new-logo').click(function(e) {
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
         frame.on('select', function(){
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
            success: function(response) {
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
            error: function(XHR, error, status) {
                alert('Something went wrong please try again: ' + status)
                $('.upload-new-logo').addClass('d-flex').removeClass('d-none')
                $('.official-website-logo').removeClass('d-flex').addClass('d-none')
            }
        })
    }





});
