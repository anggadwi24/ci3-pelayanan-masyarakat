(function ($) {

    "use strict";
    
    weather();
    function weather(){
        var getUrl = window.location;
        var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1] + "/";
        $.ajax({
            type:'POST',
            url:baseUrl+'site/main/getWeather',
            dataType:'json',
            success:function(resp){
                $('#weather').html(resp);
            }
        })
    }
    //===== Prealoder

    jQuery(window).on('load', function (event) {
        jQuery('#preloader').delay(500).fadeOut(500);
    });

    jQuery(document).on('ready', function () {
        
        
        /*---canvas menu activation---*/
        jQuery('.binduz-er-news-canvas_open').on('click', function () {
            jQuery('.binduz-er-news-offcanvas_menu_wrapper,.binduz-er-news-off_canvars_overlay').addClass('binduz-er-news-active')
        });

        jQuery('.binduz-er-news-canvas_close,.binduz-er-news-off_canvars_overlay').on('click', function () {
            jQuery('.binduz-er-news-offcanvas_menu_wrapper,.binduz-er-news-off_canvars_overlay').removeClass('binduz-er-news-active')
        });



        /*---Off Canvas Menu---*/
        var $offcanvasNav = jQuery('.binduz-er-news-offcanvas_main_menu'),
            $offcanvasNavSubMenu = $offcanvasNav.find('.binduz-er-news-sub-menu');
        $offcanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="far fa-angle-down"></i></span>');

        $offcanvasNavSubMenu.slideUp();

        $offcanvasNav.on('click', 'li a, li .menu-expand', function (e) {
            var $this = jQuery(this);
            if (($this.parent().attr('class').match(/\b(binduz-er-news-menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.siblings('ul').slideUp('binduz-er-news-slow');
                } else {
                    $this.closest('li').siblings('li').find('ul:visible').slideUp('binduz-er-news-slow');
                    $this.siblings('ul').slideDown('binduz-er-news-slow');
                }
            }
            if ($this.is('a') || $this.is('span') || $this.attr('clas').match(/\b(binduz-er-news-menu-expand)\b/)) {
                $this.parent().toggleClass('binduz-er-news-menu-open');
            } else if ($this.is('li') && $this.attr('class').match(/\b('binduz-er-news-menu-item-has-children')\b/)) {
                $this.toggleClass('binduz-er-news-menu-open');
            }
        });







        
        //===== Service Active slick slider        
        var topbar_headline1 = jQuery('.binduz-er-topbar-headline');
        topbar_headline1.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fas fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="fas fa-angle-right"></i></span>',
            speed: 1500,
            slidesToShow: 1,
            slidesToScroll: 1,
            vertical: true,
            verticalSwiping: true,
        });

        
        //===== Service Active slick slider        
        var topbar_headline2 = jQuery('.binduz-er-topbar-headline-2');
        topbar_headline2.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            speed: 1500,
            slidesToShow: 1,
            slidesToScroll: 1,
            vertical: true,
            verticalSwiping: true,

        });

        
        //===== Service Active slick slider        
        var featured_slider = jQuery('.binduz-er-featured-slider-item');
        featured_slider.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="far fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="far fa-angle-right"></i></span>',
            speed: 1500,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        slidesToShow: 1,
                    }
            },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                    }
            },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    }
            },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
            }
          ]
        });
        
        
        //===== Testimonial Content Slide slick slider
        var news_slider1 = jQuery('.binduz-er-news-slider-item');
        news_slider1.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fal fa-long-arrow-left"></i></span>',
            nextArrow: '<span class="next"><i class="fal fa-long-arrow-right"></i></span>',
            fade: true,
            asNavFor: '.binduz-er-news-slider-content-slider'
        });
        var news_slider2 = jQuery('.binduz-er-news-slider-content-slider');
        news_slider2.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            asNavFor: '.binduz-er-news-slider-item',
            dots: false,
            centerMode: true,
            arrows: false,
            prevArrow: '<span class="prev"><i class="fal fa-arrow-left"></i> Prev</span>',
            nextArrow: '<span class="next">Next <i class="fal fa-arrow-right"></i></span>',
            centerPadding: "0",
            focusOnSelect: true,

        });
        
        //===== Service Active slick slider        
        var topbar_headline = jQuery('.binduz-er-news-viewed-most-slide');
        topbar_headline.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fal fa-long-arrow-left"></i></span>',
            nextArrow: '<span class="next"><i class="fal fa-long-arrow-right"></i></span>',
            speed: 1500,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        slidesToShow: 1,
                        arrows: false,
                    }
            }
          ]

        });

        
        //===== Service Active slick slider        
        var topbar_headline = jQuery('.binduz-er-news-slider-2-item');
        topbar_headline.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            prevArrow: '<span class="prev"><i class="fal fa-long-arrow-left"></i></span>',
            nextArrow: '<span class="next"><i class="fal fa-long-arrow-right"></i></span>',
            speed: 1500,
            slidesToShow: 3,
            slidesToScroll: 1,
            centerMode: true,
            centerPadding: "50px",
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        arrows: false,
                        slidesToShow: 2,
                    }
            },
                {
                    breakpoint: 992,
                    settings: {
                        arrows: false,
                        slidesToShow: 2,
                    }
            },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                        centerPadding: "30px",
                    }
            },
                {
                    breakpoint: 576,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                        centerPadding: "0px",
                    }
            },
          ]

        });

        
        //===== Service Active slick slider        
        var topbar_headline = jQuery('.binduz-er-featured-slider-2');
        topbar_headline.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fal fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="fal fa-angle-right"></i></span>',
            speed: 1500,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        arrows: false,
                    }
            }
          ]

        });

        
        //===== Service Active slick slider        
        var topbar_headline = jQuery('.binduz-er-top-news-2-slider');
        topbar_headline.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fal fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="fal fa-angle-right"></i></span>',
            speed: 1500,
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        arrows: false,
                    }
            }
          ]

        });
        
        //===== Service Active slick slider        
        var topbar_headline = jQuery('.binduz-er-social-news-slide');
        topbar_headline.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fal fa-angle-left"></i></span>',
            nextArrow: '<span class="next"><i class="fal fa-angle-right"></i></span>',
            speed: 1500,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        arrows: false,
                    }
            },
                {
                    breakpoint: 992,
                    settings: {
                        arrows: false,
                        slidesToShow: 2,
                    }
            },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                    }
            },
          ]

        });
        
        //===== Service Active slick slider        
        var topbar_headline = jQuery('.binduz-er-blog-related-post-slide');
        topbar_headline.slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            speed: 1500,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1201,
                    settings: {
                        arrows: false,
                        slidesToShow: 2,
                    }
            },
                {
                    breakpoint: 992,
                    settings: {
                        arrows: false,
                        slidesToShow: 2,
                    }
            },
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        slidesToShow: 1,
                    }
            },
          ]

        });
        


    //===== shop details slide slick slider
    var topbar_headline1 = jQuery('.hero-slide-active');
    topbar_headline1.slick({
        slidesToShow: 1,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        slidesToScroll: 1,
        arrows: false,    
        fade: true,
        asNavFor: '.hero-portal-active'
    });
    var topbar_headline2 = jQuery('.hero-portal-active');
    topbar_headline2.slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        asNavFor: '.hero-slide-active',
        dots: false,
        centerMode: false,
        arrows: false,
        centerPadding: "0",
        focusOnSelect: true,            
        responsive: [
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
            }
          ]
    });


        $('.binduz-er-newsr-popup-audio').magnificPopup({
          type:'inline',
          midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });


        //===== Isotope Project 1

        jQuery('.container').imagesLoaded(function () {
            var $grid = jQuery('.binduz-er-grid').isotope({
                // options
                transitionDuration: '1s'
            });

            // filter items on button click
            jQuery('.binduz-er-project-menu ul').on('click', 'li', function () {
                var filterValue = jQuery(this).attr('data-filter');
                $grid.isotope({
                    filter: filterValue
                });
            });

            //for menu active class
            jQuery('.binduz-er-project-menu ul li').on('click', function (event) {
                jQuery(this).siblings('.binduz-er-active').removeClass('binduz-er-active');
                jQuery(this).addClass('binduz-er-active');
                event.preventDefault();
            });
        });


        //====== Magnific Popup

        jQuery('.binduz-er-video-popup').magnificPopup({
            type: 'iframe'
            // other options
        });


        //===== Magnific Popup

        jQuery('.binduz-er-image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
        
        
        //===== Search 

        $('.binduz-er-news-search-open').on('click', function () {
            $('.binduz-er-news-search-box').addClass('open')
        });

        $('.binduz-er-news-search-close-btn').on('click', function () {
            $('.binduz-er-news-search-box').removeClass('open')
        });

        
        
        
        //===== NICE SELECT
        $('.binduz-er-select-item select').niceSelect();


        //===== Back to top

        // Show or hide the sticky footer button
        jQuery(window).on('scroll', function (event) {
            if (jQuery(this).scrollTop() > 600) {
                jQuery('.binduz-er-back-to-top').fadeIn(200)
            } else {
                jQuery('.binduz-er-back-to-top').fadeOut(200)
            }
        });


        //Animate the scroll to yop
        jQuery('.binduz-er-back-to-top').on('click', function (event) {
            event.preventDefault();

            jQuery('html, body').animate({
                scrollTop: 0,
            }, 1500);
        });




        


    });




})(jQuery);
