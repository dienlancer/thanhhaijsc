
$j(document).ready(function() {
	"use strict";


    $j('.price_slider_wrapper').parents('.widget').addClass('widget_price_filter');
    initSelect2();
    initAddToCartPlusMinus();
    qodeInitProductListMasonryShortcode();
	qodeProductPinterestAddedToCartButton();
	qodeInitSingleProductLightbox();
    qodeWishlistRefresh().init();
    qodeQuickViewGallery().init();
    qodeQuickViewSelect2();
    qodeInitProductListFilter().init();
	$j(document).on('qodeAjaxPageLoad', function(){
		qodeInitProductListMasonryShortcode();
	});
});

function initSelect2() {
    $j('.woocommerce-ordering .orderby, #calc_shipping_country, #dropdown_product_cat').select2({
        minimumResultsForSearch: -1
    });
    $j('.woocommerce-account .country_select').select2();
}

function initAddToCartPlusMinus(){

    $j(document).on( 'click', '.quantity .plus, .quantity .minus', function() {

        // Get values
        var $qty		= $j(this).closest('.quantity').find('.qty'),
            currentVal	= parseFloat( $qty.val() ),
            max			= parseFloat( $qty.attr( 'max' ) ),
            min			= parseFloat( $qty.attr( 'min' ) ),
            step		= $qty.attr( 'step' );

        // Format values
        if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
        if ( max === '' || max === 'NaN' ) max = '';
        if ( min === '' || min === 'NaN' ) min = 0;
        if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

        // Change the value
        if ( $j( this ).is( '.plus' ) ) {

            if ( max && ( max == currentVal || currentVal > max ) ) {
                $qty.val( max );
            } else {
                $qty.val( currentVal + parseFloat( step ) );
            }

        } else {

            if ( min && ( min == currentVal || currentVal < min ) ) {
                $qty.val( min );
            } else if ( currentVal > 0 ) {
                $qty.val( currentVal - parseFloat( step ) );
            }
        }

        // Trigger change event
        $qty.trigger( 'change' );
    });
}

/*
 ** Init Product Single Pretty Photo attributes
 */
function qodeInitSingleProductLightbox() {
	"use strict";
	
	var item = $j('.woocommerce.single-product .product .images .woocommerce-product-gallery__image');
	
	if(item.length) {
		item.each(function() {
			var thisItem = $j(this).children('a');
			
			thisItem.attr('data-rel', 'prettyPhoto[woo_single_pretty_photo]');
			
			$j('a[data-rel]').each(function() {
				$j(this).attr('rel', $j(this).data('rel'));
			});
			
			$j("a[rel^='prettyPhoto']").prettyPhoto({
				animation_speed: 'normal', /* fast/slow/normal */
				slideshow: false, /* false OR interval time in ms */
				autoplay_slideshow: false, /* true/false */
				opacity: 0.80, /* Value between 0 and 1 */
				show_title: true, /* true/false */
				allow_resize: true, /* Resize the photos bigger than viewport. true/false */
				horizontal_padding: 0,
				default_width: 650,
				default_height: 400,
				counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
				theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
				hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
				wmode: 'opaque', /* Set the flash wmode attribute */
				autoplay: true, /* Automatically start videos: True/False */
				modal: false, /* If set to true, only the close button will close the window */
				overlay_gallery: false, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
				keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
				deeplinking: false,
				social_tools: false
			});
		});
	}
}

/*
 ** Init Product List Masonry Shortcode Layout
 */
function qodeInitProductListMasonryShortcode() {

    var container = $j('.qode_product_list_masonry_holder_inner, .qode_product_list_pinterest_holder_inner');

    if(container.length) {
			container.waitForImages({
				finished: function() {
					setTimeout(function(){
				        container.isotope({
				            itemSelector: '.qode_product_list_item',
				            resizable: false,
				            masonry: {
				                columnWidth: '.qode_product_list_sizer',
				                gutter: '.qode_product_list_gutter'
				            }
				        });
				        container.css('opacity', 1);
						initParallax();
					}, 200);
			    },
			    waitForAll: true
			});
    }
}


/*
 ** Add class to view cart button
 */
function qodeProductPinterestAddedToCartButton(){
	$j('body').on("added_to_cart", function( data ) {
		var btn = $j('.qode_product_list_pinterest_holder a.added_to_cart:not(.qbutton)');
		btn.addClass('qbutton');
	});
}

function qodeWishlistRefresh() {

    var initRefreshWishlist = function(){
        $j.ajax({
            url: QodeAdminAjax.ajaxurl,
            type: "POST",
            data: {
                'action' : 'qode_product_ajax_wishlist'
            },
            success:function(data) {


                $j('.qode-wishlist-widget-holder .qode-wishlist-items-number span').html(data['wishlist_count_products']);
            }
        });
    }

    return {
        init: function () {
            //trigger defined in jquery.yith-wcwl.js, after product is added to wishlist
            qode_body.on('added_to_wishlist',function(){
                initRefreshWishlist();
            });

            //after product is removed from wishlist list
            $j('#yith-wcwl-form').on('click', '.product-remove a, .product-add-to-cart a', function() {
                setTimeout(function() {
                    initRefreshWishlist();
                }, 2000);
            });
        }

    }

}

function qodeQuickViewGallery() {

    var initGallery = function(){
        var sliders = $j('.qode-quick-view-gallery.qode-owl-slider');

        if (sliders.length) {
            sliders.each(function(){
                var slider = $j(this);
                slider.owlCarousel({
                    items: 1,
                    loop: true,
                    autoplay: false,
                    smartSpeed: 600,
                    margin: 0,
                    center: false,
                    autoWidth: false,
                    animateIn : false,
                    animateOut : false,
                    dots: false,
                    nav: true,
                    navText: [
                        '<span class="qode-prev-icon"><span class="fa fa-angle-left"></span></span>',
                        '<span class="qode-next-icon"><span class="fa fa-angle-right"></span></span>'
                    ],
                    onInitialize: function () {
                        slider.css('visibility', 'visible');
                    }
                });
            });
        }


    }

    return {
        init: function () {
            //trigger defined in yith-woocommerce-quick-view\assets\js\frontend.js, after quick view is returned
            $j(document).on('qv_loader_stop',function(){
                initGallery();
                $j('.yith-wcqv-wrapper').css('top', $scroll+20); //positioning popup on screens smaller than ipad portrait
            });
        }
    }
}

function qodeQuickViewSelect2() {
    $j(document).on('qv_loader_stop',function(){
        $j('#yith-quick-view-modal select').select2();
    });
}

function qodeInitProductListFilter(){
    var productList = $j('.qode-pl-holder');
    var queryParams = {};

    var initFilterClick = function(thisProductList){
        var links = thisProductList.find('.qode-pl-categories a, .qode-pl-ordering a');

        links.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var clickedLink = $j(this);
            if(!clickedLink.hasClass('active')) {
                initMainPagFunctionality(thisProductList, clickedLink);
            }
        });
    }

    //used for replacing content after ajax call
    var qodeReplaceStandardContent = function(thisProductListInner, loader, responseHtml) {
        thisProductListInner.html(responseHtml);
        loader.fadeOut();
    };

    //used for replacing content after ajax call
    var qodeReplaceMasonryContent = function(thisProductListInner, loader, responseHtml) {
        thisProductListInner.find('.qode-pli').remove();

        thisProductListInner.append(responseHtml).isotope('reloadItems').isotope({sortBy: 'original-order'});
        qodeProductImageSizes(thisProductListInner);
        setTimeout(function() {
            thisProductListInner.isotope('layout');
            loader.fadeOut();
        }, 400);
    };

    //used for storing parameters in global object
    var qodeReturnOrderingParemeters = function(queryParams, data){

        for (var key in data) {
            queryParams[key] = data[key];
        }

        //store ordering parameters
        switch(queryParams.ordering) {
            case 'menu_order':
                queryParams.metaKey = '';
                queryParams.order = 'asc';
                queryParams.orderby = 'menu_order title';
                break;
            case 'popularity':
                queryParams.metaKey = 'total_sales';
                queryParams.order = 'desc';
                queryParams.orderby = 'meta_value_num';
                break;
            case 'rating':
                queryParams.metaKey = '_wc_average_rating';
                queryParams.order = 'desc';
                queryParams.orderby = 'meta_value_num';
                break;
            case 'newness':
                queryParams.metaKey = '';
                queryParams.order = 'desc';
                queryParams.orderby = 'date';
                break;
            case 'price':
                queryParams.metaKey = '_price';
                queryParams.order = 'asc';
                queryParams.orderby = 'meta_value_num';
                break;
            case 'price-desc':
                queryParams.metaKey = '_price';
                queryParams.order = 'desc';
                queryParams.orderby = 'meta_value_num';
                break;
        }

        return queryParams;
    }

    var initMainPagFunctionality = function(thisProductList, clickedLink){
        var thisProductListInner = thisProductList.find('.qode-pl-outer');

        var loadData = qode.modules.common.getLoadMoreData(thisProductList),
            loader = thisProductList.find('.qode-prl-loading');

        //store parameters in global object
        qodeReturnOrderingParemeters(queryParams, clickedLink.data());

        //set paremeters for new query passed through ajax
        loadData.category = queryParams.category !== undefined ? queryParams.category : '';
        loadData.metaKey = queryParams.metaKey !== undefined ? queryParams.metaKey : '';
        loadData.order = queryParams.order !== undefined ? queryParams.order : '';
        loadData.orderby = queryParams.orderby !== undefined ? queryParams.orderby : '';
        loadData.minPrice = queryParams.minprice !== undefined ? queryParams.minprice : '';
        loadData.maxPrice = queryParams.maxprice !== undefined ? queryParams.maxprice : '';

        loader.fadeIn();

        var ajaxData = qode.modules.common.setLoadMoreAjaxData(loadData, 'qode_product_ajax_load_category');

        $j.ajax({
            type: 'POST',
            data: ajaxData,
            url: QodeAdminAjax.ajaxurl,
            success: function (data) {
                var response = $j.parseJSON(data),
                    responseHtml =  response.html;

                thisProductList.waitForImages(function(){
                    clickedLink.parent().siblings().find('a').removeClass('active');
                    clickedLink.addClass('active');
                    if(thisProductList.hasClass('qode-masonry-layout')) {
                        qodeReplaceMasonryContent(thisProductListInner, loader, responseHtml);
                    }else{
                        qodeReplaceStandardContent(thisProductListInner, loader, responseHtml);
                    }
                });

            }
        });
    }

    var initMobileFilterClick = function(cliked, holder){
        cliked.on('click',function(){
            if(qode.windowWidth <= 768) {
                if(!cliked.hasClass('opened')){
                    cliked.addClass('opened');
                    holder.slideDown();
                }else{
                    cliked.removeClass('opened');
                    holder.slideUp();
                }
            }
        });
    }

    return {
        init: function () {
            if (productList.length) {
                productList.each(function () {
                    var thisProductList = $j(this);
                    initFilterClick(thisProductList);

                    initMobileFilterClick(thisProductList.find('.qode-pl-ordering-outer h6'), thisProductList.find('.qode-pl-ordering'));
                    initMobileFilterClick(thisProductList.find('.qode-pl-categories-label'),thisProductList.find('.qode-pl-categories-label').next('ul'));
                });
            }
        },

    }
}
