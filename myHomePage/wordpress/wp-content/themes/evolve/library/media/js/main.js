//
// Responsive Primary Menu
//

if (js_responsive_menu.responsive_menu_layout == 'dropdown') {

    jQuery(document).ready(function () {
        if (js_responsive_menu.responsive_menu == '') {
            jQuery('.primary-menu .nav-holder .evolve_mobile_menu').meanmenu();
        } else {
            jQuery('.primary-menu .nav-holder .evolve_mobile_menu').meanmenu({
                meanMenuClose: "<label class='dd-selected-text'>" + js_responsive_menu.responsive_menu + "</label>",
                meanMenuOpen: "<label class='dd-selected-text'>" + js_responsive_menu.responsive_menu + "</label>"
            });
        }
    });

} else {

    // Create the dropdown base
    jQuery('<select />').appendTo('.primary-menu .nav-holder');

    // Create default option 'Menu'
    jQuery('<option />', {
        'selected': 'selected',
        'value': '',
        'text': js_responsive_menu.responsive_menu
    }).appendTo('.primary-menu .nav-holder select');

    // Populate dropdown with menu items
    jQuery('.primary-menu .nav-holder a').each(function () {
        var el = jQuery(this);

        if (jQuery(el).parents('.sub-menu .sub-menu').length >= 1) {
            jQuery('<option />', {
                'value': el.attr('href'),
                'text': '-- ' + el.text()
            }).appendTo('.primary-menu .nav-holder select');
        } else if (jQuery(el).parents('.sub-menu').length >= 1) {
            jQuery('<option />', {
                'value': el.attr('href'),
                'text': '- ' + el.text()
            }).appendTo('.primary-menu .nav-holder select');
        } else {
            jQuery('<option />', {
                'value': el.attr('href'),
                'text': el.text()
            }).appendTo('.primary-menu .nav-holder select');
        }
    });

    jQuery('.primary-menu .nav-holder select').ddslick({
        width: '100%',
        onSelected: function (selectedData) {
            if (selectedData.selectedData.value != '') {
                window.location = selectedData.selectedData.value;
            }
        }
    });
}

//
// Responsive WooCommerce Menu
//   

// Create the dropdown base
jQuery('<select />').appendTo('.woocommerce-menu-holder .woocommerce-menu');

// Create default option 'Menu'
jQuery('<option />', {
    'selected': 'selected',
    'value': '',
    'text': '<span class="t4p-icon-shopping-cart"></span>'
}).appendTo('.woocommerce-menu-holder .woocommerce-menu select');

// Populate dropdown with menu items
jQuery('.woocommerce-menu-holder .woocommerce-menu a').each(function () {
    var el = jQuery(this);

    if (jQuery(el).parents('.sub-menu .sub-menu').length >= 1) {
        jQuery('<option />', {
            'value': el.attr('href'),
            'text': '-- ' + el.text()
        }).appendTo('.woocommerce-menu-holder .woocommerce-menu select');
    } else if (jQuery(el).parents('.sub-menu').length >= 1) {
        jQuery('<option />', {
            'value': el.attr('href'),
            'text': '- ' + el.text()
        }).appendTo('.woocommerce-menu-holder .woocommerce-menu select');
    } else {
        jQuery('<option />', {
            'value': el.attr('href'),
            'text': el.text()
        }).appendTo('.woocommerce-menu-holder .woocommerce-menu select');
    }
});

jQuery('.woocommerce-menu-holder .woocommerce-menu select').ddslick({
    width: '100%',
    onSelected: function (selectedData) {
        if (selectedData.selectedData.value != '') {
            window.location = selectedData.selectedData.value;
        }
    }
});

//
// Responsive Images
//

var $addmenueffect = jQuery.noConflict();
$addmenueffect("#primary img").addClass("img-responsive");

//
// Carousel Slider Arrows
//

var $jx = jQuery.noConflict();
$jx(document).ready(function () {
    $jx('div#slide_holder').hover(function () {
        $jx(this).find('.arrow span').stop(true, true).fadeIn(200).show(10);
    }, function () {
        $jx(this).find('.arrow span').stop(true, true).fadeOut(200).hide(10);
    });
});

// 
// Tipsy
//

var $j = jQuery.noConflict();
$j(document).ready(function () {
    $j('.tipsytext').tipsy({gravity: 'n', fade: true, offset: 0, opacity: 1});
});

//
// Sticky Header Logo Margin
//   

/*! Copyright 2012, Ben Lin (http://dreamerslab.com/)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 1.0.15
 *
 * Requires: jQuery >= 1.2.3
 */
;
(function ($) {
    $.fn.addBack = $.fn.addBack || $.fn.andSelf;

    $.fn.extend({
        actual: function (method, options) {
            // check if the jQuery method exist
            if (!this[ method ]) {
                throw '$.actual => The jQuery method "' + method + '" you called does not exist';
            }

            var defaults = {
                absolute: false,
                clone: false,
                includeMargin: false
            };

            var configs = $.extend(defaults, options);

            var $target = this.eq(0);
            var fix, restore;

            if (configs.clone === true) {
                fix = function () {
                    var style = 'position: absolute !important; top: -1000 !important; ';

                    // this is useful with css3pie
                    $target = $target.
                            clone().
                            attr('style', style).
                            appendTo('body');
                };

                restore = function () {
                    // remove DOM element after getting the width
                    $target.remove();
                };
            } else {
                var tmp = [];
                var style = '';
                var $hidden;

                fix = function () {
                    // get all hidden parents
                    $hidden = $target.parents().addBack().filter(':hidden');
                    style += 'visibility: hidden !important; display: block !important; ';

                    if (configs.absolute === true)
                        style += 'position: absolute !important; ';

                    // save the origin style props
                    // set the hidden el css to be got the actual value later
                    $hidden.each(function () {
                        var $this = $(this);

                        // Save original style. If no style was set, attr() returns undefined
                        tmp.push($this.attr('style'));
                        $this.attr('style', style);
                    });
                };

                restore = function () {
                    // restore origin style values
                    $hidden.each(function (i) {
                        var $this = $(this);
                        var _tmp = tmp[ i ];

                        if (_tmp === undefined) {
                            $this.removeAttr('style');
                        } else {
                            $this.attr('style', _tmp);
                        }
                    });
                };
            }

            fix();
            // get the actual value with user specific methed
            // it can be 'width', 'height', 'outerWidth', 'innerWidth'... etc
            // configs.includeMargin only works for 'outerWidth' and 'outerHeight'
            var actual = /(outer)/.test(method) ?
                    $target[ method ](configs.includeMargin) :
                    $target[ method ]();

            restore();
            // IMPORTANT, this plugin only return the value of the first element
            return actual;
        }
    });
})(jQuery);

jQuery(document).ready(function ($) {
    // sticky menu logo vertical alignment center
    var parentHeight = jQuery('header.sticky-header').actual('height');
    var childHeight = jQuery('#sticky-logo').actual('height');
    jQuery('#sticky-logo').css('margin-top', (parentHeight - childHeight) / 2);
});

// **********************  home content box style for mac and iphone  ****************************

if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
    jQuery(".content-box .cntbox_btn").css({'display': 'block', 'position': 'relative', 'top': '0'});
}

var is_OSX = navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i) ? true : false;
var is_iOS = navigator.platform.match(/(iPhone|iPod|iPad)/i) ? true : false;

var is_Mac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
var is_iPhone = navigator.platform == "iPhone";
var is_iPod = navigator.platform == "iPod";
var is_iPad = navigator.platform == "iPad";

//var oscheck= "Platform: " + navigator.platform;

if (is_OSX) {
    jQuery(".home-content-boxes .col-md-3.content-box, .home-content-boxes .col-md-4.content-box, .home-content-boxes .col-md-6.content-box").addClass('osmac');
}

// **********************  home content box button style for mac and iphone  ****************************
jQuery(window).load(function () {
    if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {


        function setHeight() {
            var heights1 = jQuery(".content-box p").map(function () {
                return jQuery(this).outerHeight();
            }).get();

            var heights2 = jQuery(".content-box h2").map(function () {
                return jQuery(this).outerHeight();
            }).get();

            var totalheights = [];
            for (var i = 0; i < heights1.length; i++)
            {
                totalheights.push(heights1[i] + heights2[i]);
            }

            maxHeight = Math.max.apply(null, totalheights);

            var btnpadding = jQuery.map(totalheights, function (value) {
                return maxHeight - value;
            });

            jQuery(".sbtn1").css('padding-top', btnpadding[0]);
            jQuery(".sbtn2").css('padding-top', btnpadding[1]);
            jQuery(".sbtn3").css('padding-top', btnpadding[2]);
            jQuery(".sbtn4").css('padding-top', btnpadding[3]);
        }
        ;
        setHeight();

        jQuery(window).resize(function () {
            var width = jQuery(window).width();
            if (width > '768') {
                setHeight();
            } else {
                jQuery(".sbtn1").css('padding-top', '0px');
                jQuery(".sbtn2").css('padding-top', '0px');
                jQuery(".sbtn3").css('padding-top', '0px');
                jQuery(".sbtn4").css('padding-top', '0px');
            }
        });
    }
});

/* add menu effect to WPML menu items */
jQuery(document).ready(function () {
    jQuery('.primary-menu .menu-item-language a,.sticky-header .menu-item-language a').each(function () {
        var el = jQuery(this);
        plan_text = el.text();
        if (jQuery(this).find('img').length) {
            img_src = jQuery(this).find('img').attr('src');
            jQuery(this).find('img').remove();
            el.html('<img src="' + img_src + '"> <span data-hover=" ' + plan_text + '"> ' + plan_text + '</span>');
        } else {
            el.html('<span data-hover="' + plan_text + '">' + plan_text + '</span>');
        }
    });
});

/**
 * For WooCommerce Product page, Checkout page and Cart page
 */

jQuery(document).ready(function ($) {

    jQuery('.woocommerce .images #carousel a').click(function (e) {
        e.preventDefault();
    });
    
    if (jQuery('.woocommerce-menu .cart').width() > 190) {
        jQuery('.woocommerce-menu .cart-contents').css("width", jQuery('.woocommerce-menu .cart').width());
        jQuery('.woocommerce-menu .cart-content a').css("width", jQuery('.woocommerce-menu .cart').width() - 26);
        jQuery('.woocommerce-menu .cart-content a .cart-desc').css("width", jQuery('.woocommerce-menu .cart').width() - 82);
    }
    
    // Woocommerce

    jQuery('.catalog-ordering .orderby .current-li a').html(jQuery('.catalog-ordering .orderby ul li.current a').html());
    jQuery('.catalog-ordering .sort-count .current-li a').html(jQuery('.catalog-ordering .sort-count ul li.current a').html());
    jQuery('.woocommerce #calc_shipping_state').parent().addClass('one_half');
    jQuery('.woocommerce #calc_shipping_postcode').parent().addClass('one_half last');
    jQuery('.woocommerce .shop_table .variation dd').after('<br />');
    jQuery('.woocommerce .evolve-myaccount-data th.order-actions').text(js_local_vars.order_actions);

    jQuery('.rtl .woocommerce .wc-forward').each(function () {
        jQuery(this).val(jQuery('.rtl .woocommerce .wc-forward').val().replace('\u2192', '\u2190'));
    });

    jQuery('.woocommerce input').each(function () {
        if (!jQuery(this).has('#coupon_code')) {
            name = jQuery(this).attr('id');
            jQuery(this).attr('placeholder', jQuery(this).parent().find('label[for=' + name + ']').text());
        }
    });

    if (jQuery('.woocommerce #reviews #comments .comment_container .comment-text').length) {
        jQuery('.woocommerce #reviews #comments .comment_container').append('<div class="clear"></div>');
    }

    if (jQuery('.woocommerce.single-product .related.products > h2').length) {
        jQuery('.woocommerce.single-product .related.products > h2').wrap('<div class="title"></div>');
        jQuery('.woocommerce.single-product .related.products > .title').append('<div class="title-sep-container"><div class="title-sep"></div></div>');
    }

    if (jQuery('.woocommerce.single-product .upsells.products > h2').length) {
        jQuery('.woocommerce.single-product .upsells.products > h2').wrap('<div class="title"></div>');
        jQuery('.woocommerce.single-product .upsells.products > .title').append('<div class="title-sep-container"><div class="title-sep"></div></div>');
    }

    if (jQuery('body #sidebar').css('display') == "block") {
        jQuery('body').addClass('has-sidebar');
        calcTabsLayout('.woocommerce-tabs .tabs-horizontal');
    }

    if (jQuery('body.archive.woocommerce #sidebar').css('display') == "block") {
        jQuery('#main ul.products').removeClass('products-1');
        jQuery('#main ul.products').removeClass('products-2');
        jQuery('#main ul.products').removeClass('products-4').addClass('products-3');
    }

    if (jQuery('body.single.woocommerce #sidebar').css('display') == "block") {
        jQuery('.upsells.products ul.products,.related.products ul.products').removeClass('products-1');
        jQuery('.upsells.products ul.products,.related.products ul.products').removeClass('products-2');
        jQuery('.upsells.products ul.products,.related.products ul.products').removeClass('products-4').addClass('products-3');
        jQuery('.upsells.products ul.products').html(jQuery('.upsells.products ul.products li').slice(0, 3));
        jQuery('.related.products ul.products').html(jQuery('.related.products ul.products li').slice(0, 3));
    }

    jQuery('#sidebar .products,.footer-area .products').each(function () {
        jQuery(this).removeClass('products-4');
        jQuery(this).removeClass('products-3');
        jQuery(this).removeClass('products-2');
        jQuery(this).addClass('products-1');
    });
    jQuery('.products-4 li, .products-3 li, .products-3 li').removeClass('last');

    $('.woocommerce-tabs ul.tabs li a').unbind('click');
    $('.woocommerce-tabs > ul.tabs li a').click(function () {

        var $tab = $(this);
        var $tabs_wrapper = $tab.closest('.woocommerce-tabs');

        $('ul.tabs li', $tabs_wrapper).removeClass('active');
        $('div.panel', $tabs_wrapper).hide();
        $('div' + $tab.attr('href'), $tabs_wrapper).show();
        $tab.parent().addClass('active');

        return false;
    });

    jQuery('.woocommerce-checkout-nav a,.continue-checkout').click(function (e) {
        e.preventDefault();

        var data_name = $(this).attr('data-name');
        var name = data_name;
        if (data_name != '#order_review') {
            name = '.' + data_name;
        }

        jQuery('form.checkout .col-1, form.checkout .col-2, form.checkout #order_review_heading, form.checkout #order_review').hide();
        jQuery('form.checkout').find(name).fadeIn();
        if (name == '#order_review') {
            jQuery('form.checkout').find('#order_review_heading').fadeIn();
        }

        jQuery('.woocommerce-checkout-nav li').removeClass('active');
        jQuery('.woocommerce-checkout-nav').find('[data-name=' + data_name + ']').parent().addClass('active');
    });

    jQuery('.evolve-myaccount-nav a').click(function (e) {
        e.preventDefault();

        jQuery('.evolve-myaccount-data .view_dashboard, .evolve-myaccount-data .digital-downloads, .evolve-myaccount-data .my_account_orders, .evolve-myaccount-data .edit_address_heading, .evolve-myaccount-data .myaccount_address, .evolve-myaccount-data .edit-account-heading, .evolve-myaccount-data .edit-account-form').hide();

        if (jQuery(this).hasClass('downloads')) {
            jQuery('.evolve-myaccount-data .digital-downloads').fadeIn();
        } else if (jQuery(this).hasClass('orders')) {
            jQuery('.evolve-myaccount-data .my_account_orders').fadeIn();
        } else if (jQuery(this).hasClass('address')) {
            jQuery('.evolve-myaccount-data .edit_address_heading, .evolve-myaccount-data .myaccount_address').fadeIn();
        } else if (jQuery(this).hasClass('account')) {
            jQuery('.evolve-myaccount-data .edit-account-heading, .evolve-myaccount-data .edit-account-form').fadeIn();
        } else if (jQuery(this).hasClass('dashboard')) {
            jQuery('.evolve-myaccount-data .view_dashboard').fadeIn();
        }

        jQuery('.evolve-myaccount-nav li').removeClass('active');
        jQuery(this).parent().addClass('active');
    });

    jQuery('a.add_to_cart_button').click(function (e) {
        var link = this;
        jQuery(link).closest('.product').find('.cart-loading').find('i').removeClass('t4p-icon-ok').addClass('t4p-icon-ok');
        jQuery(this).closest('.product').find('.cart-loading').fadeIn();
        setTimeout(function () {
            jQuery(link).closest('.product').find('.product-images img').animate({opacity: 0.75});
            jQuery(link).closest('.product').find('.cart-loading').find('i').hide().removeClass('t4p-icon-repeat').addClass('t4p-icon-ok').fadeIn();

            setTimeout(function () {
                jQuery(link).closest('.product').find('.cart-loading').fadeOut().closest('.product').find('.product-images img').animate({opacity: 1});
            }, 2000);
        }, 2000);
    });

    jQuery('li.product').mouseenter(function () {
        if (jQuery(this).find('.cart-loading').find('i').hasClass('t4p-icon-ok')) {
            jQuery(this).find('.cart-loading').fadeIn();
        }
    }).mouseleave(function () {
        if (jQuery(this).find('.cart-loading').find('i').hasClass('t4p-icon-ok')) {
            jQuery(this).find('.cart-loading').stop().fadeOut('400');
        }
    });

    jQuery('.sep-boxed-pricing,.full-boxed-pricing').each(function () {
        jQuery(this).addClass('columns-' + jQuery(this).find('.column').length);
    });

    // wrap woo select and add arrow
    jQuery('.woocommerce #calc_shipping_country, .woocommerce .country_select, #bbp_stick_topic_select, #bbp_topic_status_select, #bbp_forum_id, #bbp_destination_topic,.woocommerce select#calc_shipping_state, .woocommerce select.state_select').wrap('<div class="evolve-select-parent"></div>').after('<div class="select-arrow t4p-icon-angle-down"></div>');

});

/**
 * WooCommerce Quanity buttons add-back
 */

jQuery(function ($) {
    if (typeof js_local_vars.woocommerce_23 !== 'undefined') {
        var $testProp = $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').find('qty');
        if ($testProp && $testProp.prop('type') != 'date') {
            // Quantity buttons
            //$('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');

            // Target quantity inputs on product pages
            $('input.qty:not(.product-quantity input.qty)').each(function () {

                var min = parseFloat($(this).attr('min'));

                if (min && min > 0 && parseFloat($(this).val()) < min) {
                    $(this).val(min);
                }
            });

            $(document).on('click', '.plus, .minus', function () {

                // Get values
                var $qty = $(this).closest('.quantity').find('.qty'),
                        currentVal = parseFloat($qty.val()),
                        max = parseFloat($qty.attr('max')),
                        min = parseFloat($qty.attr('min')),
                        step = $qty.attr('step');

                // Format values
                if (!currentVal || currentVal === '' || currentVal === 'NaN')
                    currentVal = 0;
                if (max === '' || max === 'NaN')
                    max = '';
                if (min === '' || min === 'NaN')
                    min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
                    step = 1;

                // Change the value
                if ($(this).is('.plus')) {

                    if (max && (max == currentVal || currentVal > max)) {
                        $qty.val(max);
                    } else {
                        $qty.val(currentVal + parseFloat(step));
                    }

                } else {

                    if (min && (min == currentVal || currentVal < min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val(currentVal - parseFloat(step));
                    }

                }

                // Trigger change event
                $qty.trigger('change');
            });
        }
    }
});

/**
 * For Woocommerce edit-addresss form
 */

jQuery(document).ready(function ($) {

    jQuery('.woo_editaddress').click(function (e) {
        e.preventDefault();

        var editaddress = $(this).attr('id');

        if (editaddress == 'editaddress_billing') {
            jQuery('.editaddress_billing').fadeIn();
            jQuery('.editaddress_shipping').hide();
        } else if (editaddress == 'editaddress_shipping') {
            jQuery('.editaddress_shipping').fadeIn();
            jQuery('.editaddress_billing').hide();
        }
    });

    jQuery('#saveaddress').click(function () {
        var formvalue = $('#formvalue').val();

        if (formvalue == 'billing') {
            jQuery('.editaddress_billing').fadeIn();
            jQuery('.editaddress_shipping').hide();
        } else if (formvalue == 'shipping') {
            jQuery('.editaddress_shipping').fadeIn();
            jQuery('.editaddress_billing').hide();
        }
    });

});

/**
 * For Woocommerce product flexslider
 */

jQuery(window).load(function () {

    jQuery('.simple-products-slider .product-buttons a').text('Add to cart');

    if (jQuery('body .aside').css('display') == "block") {
        jQuery('body').addClass('has-sidebar');
    }

    if (jQuery().flexslider && jQuery('.woocommerce .images #carousel').length >= 1) {
        var WooThumbWidth = 100;
        if (jQuery('body.woocommerce #sidebar').is(':visible')) {
            wooThumbWidth = 100;
        } else {
            wooThumbWidth = 118;
        }

        if (typeof jQuery('.woocommerce .images #carousel').data('flexslider') !== 'undefined') {
            jQuery('.woocommerce .images #carousel').flexslider('destroy');
            jQuery('.woocommerce .images #slider').flexslider('destroy');
        }

        jQuery('.woocommerce .images #carousel').flexslider({
            animation: 'slide',
            controlNav: false,
            directionNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: wooThumbWidth,
            itemMargin: 9,
            touch: false,
            useCSS: false,
            asNavFor: '.woocommerce .images #slider',
            smoothHeight: false
        });

        jQuery('.woocommerce .images #slider').flexslider({
            animation: 'slide',
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            smoothHeight: true,
            touch: true,
            useCSS: false,
            sync: '.woocommerce .images #carousel'
        });
    }

    jQuery('.woocommerce .images #slider').flexslider({
        animation: 'slide',
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        smoothHeight: true,
        touch: true,
        useCSS: false,
        sync: '.woocommerce .images #carousel'
    });
});