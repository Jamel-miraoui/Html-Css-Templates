; (function ($) {
    "use strict";

    $(function () {
        //Data Background Set
        $('[data-background]').each(function () {
            $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
        });
        
        //ScrollTop
        $(".scrolltop-btn").on("click", function () {
            $("body,html").animate({
                scrollTop: 0
            });
        });
        
        //Mobile Menu
        $(".mobile-menu-toggle").on("click", function () {
            $(".body-overlay").addClass('overlay-on');
            $(".mobile-menu").addClass("active");
        });
        $(".close-menu").on("click", function () {
            $(".mobile-menu").removeClass("active");
            $(".body-overlay").removeClass("overlay-on");
        });
        $(".body-overlay").on("click", function () {
            $(".mobile-menu").removeClass("active");
            $(this).removeClass("overlay-on");
        });
        $(".mobile-menu ul li.has-submenu > i").each(function () {
            $(this).on("click", function () {
                $(this).siblings('ul').slideToggle();
                $(this).toggleClass("icon-rotate");
            });
        });
        
        //Canvus Menu
        $(".ofcanvus-btn").on("click", function () {
            $(".ofcanvus-menu").addClass("active");
            return false;
        });
        $(".close-canvus").on("click", function () {
            $(".ofcanvus-menu").removeClass("active");
            return false;
        });
        
        // Hide ofcanvus when click outside it.
        $(document).on("mouseup", function (e) {
            const ofcanvusMenu = $(".ofcanvus-menu");

            if (!ofcanvusMenu.is(e.target) && ofcanvusMenu.has(e.target).length === 0) {
                ofcanvusMenu.removeClass("active");
            }
        });
        
        
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        //Accordion
        $(".hm2-accordion .accordion-header a").each(function () {
            $(this).on("click", function () {
                $(this).parents(".accordion").find(".show").parents(".acoridion-item").addClass("active");
            });
        });
        

    });

    // magnificPopup 
    let videoPopup = $('.vps-video-popup');
    if ( videoPopup.length > 0 ) {
        videoPopup.magnificPopup({
            type: 'iframe'
        });
    }
    
    // CounterUp
    let counter = $('.counter');
    if (counter.length > 0) {
        counter.counterUp({
            delay: 10,
            time: 1000
        });
    }

    $(window).on("scroll", function () {
        var offsetTop = $(window).scrollTop();

        if (offsetTop > 150) {
            $(".scrolltop-btn").fadeIn();
        } else {
            $(".scrolltop-btn").fadeOut();
        }
        
        //Sticky Header
        var stickyEnabled = $('.sticky_enabled');
        if (stickyEnabled.length > 0) {
            var scrollBarPosition = $(window).scrollTop();
            if (scrollBarPosition > 100) {
                stickyEnabled.addClass("sticky-header");
            } else {
                stickyEnabled.removeClass("sticky-header");
            }
        }
       
    });
    jQuery(window).on('load', function () {
        var feedBack = document.querySelectorAll(".feedback-wrapper");

        if (feedBack.length > 0) {
            var elem = document.querySelector('.feedback-massonry');
            var msnry = new Masonry(elem, {
                itemSelector: '.col-lg-4',
                columnWidth: 1
            });
        }

        $(".loader-wrap").fadeOut();
    });

    $(document).ready(function () { 
        $(".countdown-timer").each(function () {
            var $data_date = $(this).data('date');
            $(this).countdown({
                date: $data_date
            });
        });
    });
    
    // Dark mode ----------------
    var setDarkMode = (active = false) => {
        var wrapper = document.querySelector(":root");

        if (active) {
            wrapper.setAttribute("data-bs-theme", "dark");
            localStorage.setItem("theme", "dark");
        } else {
            wrapper.setAttribute("data-bs-theme", "light");
            localStorage.setItem("theme", "light");
        }
    };

    var toggleDarkMode = () => {
        var theme = document.querySelector(":root").getAttribute("data-bs-theme"); // If the current theme is "light", we want to activate dark

        setDarkMode(theme === "light");
    };

    var initDarkMode = () => {
        var theme = localStorage.getItem("theme");

        if (theme == "dark") {
            setDarkMode(true);
        } else {
            setDarkMode(false);
        }

        var toggleButton = document.querySelector(".dark-light-switcher");
        toggleButton && toggleButton.addEventListener("click", toggleDarkMode);
    };

    initDarkMode();


})(jQuery);