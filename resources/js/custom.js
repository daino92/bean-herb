document.addEventListener('click', function (event) {
    // weight inits
    var initialPrice = $("#initial__price").val();
    var minimumWeight = parseInt($("input[name='minimum__weight']").val());
    var price = $("#weight_needed");
    var initialStep = parseInt(price.attr("data-step"));
    var currentStep = parseInt(price.attr("data-current-step"));
    var pricingUnit = $("input[name='pricingUnit']").val();
    var unit = $("input[name='unit']").val();

    if (pricingUnit === "g") {
        var denominator = initialStep;
    } else {
        var denominator = 1000;
    }

    // pieces inits
    var quantity = $("#quantity-pieces");
    var minQuantity = quantity.attr("min");
    var step = quantity.attr("step");
    var value = quantity.attr("value");

    //var isModal = event.path[10].className === "modal popup";

    // weight funcs
    if (event.target.matches("#minus")) {
        if (currentStep === minimumWeight) return;
        
        var stepper = currentStep - initialStep;
        price.attr("data-current-step", stepper);
        currentStep = parseInt(price.attr("data-current-step"));
        var shownPrice = (initialPrice * stepper) / denominator;
        shownPrice = shownPrice.toFixed(2);

        if (event.path[10].className === "modal popup") {
            $(".modal-content input[name='weight_needed']").val(currentStep);
            $(".modal-content #weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
        } else {
            $("input[name='weight_needed']").val(currentStep);
            $("#weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
        }
    }

    if (event.target.matches("#plus")) {
        var stepper = currentStep + initialStep;
        price.attr("data-current-step", stepper);
        currentStep = parseInt(price.attr("data-current-step"));
        var shownPrice = (initialPrice * stepper) / denominator;
        shownPrice = shownPrice.toFixed(2);
        if (event.path[10].className === "modal popup") {
            $(".modal-content input[name='weight_needed']").val(currentStep);
            $(".modal-content #weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
        } else {
            $("input[name='weight_needed']").val(currentStep);
            $("#weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
        }
    }

	if (event.target.matches("#plus_pieces")) {
		var nextVal = parseInt(value) + parseInt(step);
        if (event.path[10].className === "modal popup") {
            var quantity = $(".modal-content #quantity-pieces");
            // quantity.attr("value", nextVal);
            // value = quantity.attr("value");
        } 
        // else {
        // }
            quantity.attr("value", nextVal);
            value = quantity.attr("value");
	}

	if (event.target.matches("#minus_pieces")) {
		if (value === minQuantity) return;

        var nextVal = parseInt(value) - parseInt(step);
        
        if (event.path[10].className === "modal popup") {
            var quantity = $(".modal-content #quantity-pieces");
            // quantity.attr("value", nextVal);
            // value = quantity.attr("value");
        } 
        // else {
        // }
            quantity.attr("value", nextVal);
            value = quantity.attr("value");
	}
}, false);

// Toggling child categories in product filters
$('.cats-toggle').click(function() {
    if ($(this).next().hasClass('active')) {
        $(this).next().removeClass('active');
        $(this).next().slideUp(600);
    } else {
        $(this).parent().parent().find('li .children').removeClass('active');
        $(this).parent().parent().find('li .children').slideUp(600);
        $(this).next().toggleClass('active');
        $(this).next().slideToggle(600);
    }

    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
    } else {
        $(this).toggleClass('active');
    }

    $(".cats-toggle").each(function(){
        if ($(this).siblings('.children').hasClass('active')) {
            $(this).parent().find('.cats-toggle').addClass('active');
        } else {
            $(this).parent().find('.cats-toggle').removeClass('active');
        }	
    });
});

$('.cat-item .cats').on('click', function() {
    if ($(".filters__area").hasClass("filters--active")) $(".filters__area").removeClass("filters--active");

    if ($(this).siblings('.children').hasClass('active')) {
        $(this).siblings('.children').removeClass('active');
        $(this).siblings('.children').slideUp(600);

        // for active class
        $(this).removeClass('current-cat');
    } else {
        $(this).parent().parent().find('li .children').removeClass('active');
        $(this).parent().parent().find('li .children').slideUp(600);
        $(this).siblings('.children').toggleClass('active');
        $(this).siblings('.children').slideToggle(600);

        // for active class
        $(this).parent().parent().find('li .cats').removeClass('current-cat');
        $(this).addClass('current-cat');
    }

    $(".cat-item .cats").each(function(){
        if ($(this).siblings('.children').hasClass('active')) {
            $(this).siblings('.cats-toggle').addClass('active');
        } else {
            $(this).siblings('.cats-toggle').removeClass('active');
        }	
    });
});


// mail subscribe
const email_regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
// var email = $('.newsletter__email').val();
// $('.newsletter__btn').on('click', function() {
// 	if(email.length > 0 && email_regex.test(email)) {
// 		$(this).click();
// 	}
// });


const escapeRegExp = function(strToEscape) {
    // Escape special characters for use in a regular expression
    return strToEscape.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
};

const trimChar = function(origString, charToTrim) {
    charToTrim = escapeRegExp(charToTrim);
    var regEx = new RegExp("^[" + charToTrim + "]+|[" + charToTrim + "]+$", "g");
    return origString.replace(regEx, "");
};

// Figure out curent category from slug in URL and add 'current-cat' class to show it in the categories
var currentURL = decodeURIComponent($(window.location)[0].href);
var splitURL = currentURL.split('product-category');
var slug = splitURL[splitURL.length - 1];

if (slug.includes('page')) {
    slug = slug.split('/')[1];
} else if (slug.includes('orderby')) {
    slug = slug.split('?')[0];
    slug = trimChar(slug, "/");
} else {
    slug = trimChar(slug, "/");
}

$(".cat-item .cats").each(function(){
    if ($(this).data('slug') === slug) {
        $(this).addClass('current-cat')
    }
});

$('.filters__area__sidebar--toggle').on('click', function() {
    $('.filters__area').toggleClass("filters--active");
});

$('.site-header-cart').on('click', function() {
    $('.mini__cart--wrapper').addClass("cart--open");
    $('#site-overlay').css("display", "block");
    $('#site-overlay').addClass("blurry");
});

$(document).on('click', '.mini__cart--close', function() {
    $('.mini__cart--wrapper').removeClass("cart--open");
    $('#site-overlay').css("display", "none");
    $('#site-overlay').removeClass("blurry");
});

$(document).mouseup(function(e) {    
    if (!$('.mini__cart--wrapper').is(e.target) && $('.mini__cart--wrapper').has(e.target).length === 0) {
        $('.mini__cart--wrapper').removeClass("cart--open");
        $('#site-overlay').css("display","none");
        $('#site-overlay').removeClass("blurry");
    }   
});

// quick view pop-up
$(document).on('click', '.close', function () {
    $('#productModal').fadeOut();
    $('body').removeClass('quick-view__no-scroll');
});

$(document).on('click', '#productModal', function (e) {
    if (e.target !== this) return;
    $('#productModal').fadeOut();
    $('body').removeClass('quick-view__no-scroll');
});

// var timeout;
// $(document).on('change', 'input.qty', function() {
//     if (timeout !== undefined) clearTimeout(timeout);
//     console.log(this)

//     timeout = setTimeout(function() {
//         $("[name='update_cart']").trigger("click");
//     }, 100);
// });

$(document).on("click", ".cart-btn__minus", function() {
    var input = $(this).next("input.qty");
	var inputVal = parseInt(input.val());
	var updatedVal = inputVal - 1;
    if (input.val() == 1) return;
	input.val(updatedVal);
    $("[name='update_cart']").removeAttr("disabled");
    $("[name='update_cart']").trigger('click');
});

$(document).on("click", ".cart-btn__plus", function() {
    var input = $(this).prev("input.qty");
	var inputVal = parseInt(input.val());
	var updatedVal = inputVal + 1;
	input.val(updatedVal);
    $("[name='update_cart']").removeAttr("disabled");
    $("[name='update_cart']").trigger('click');
});

$(document).ready(function() {
   $(".insta-gallery-link").each(function() {
        $(this).attr('rel', 'noopener');
    });

    $(".insta-gallery-icon").each(function() {
        $(this).attr('rel', 'noopener');
    });
});

// toggle hamburger
$(".hamburger").on("click", function() {
	$(".hamburger").toggleClass("is-active");
});

$(".widget_shopping_cart").prependTo('#page');

// shop submenu
$(".big__menu").hover(function () {
    $(".sub-category").addClass("hovered");
    $(".big__menu .sub-menu").css("visibility", "visible");
    $(".big__menu .sub-menu").css("transition", "opacity .6s;");
    $(".big__menu .sub-menu").css("opacity", "1"); 
}, function () {
    $(".sub-category").removeClass("hovered");
    $(".big__menu .sub-menu").css("visibility", "hidden");
    $(".big__menu .sub-menu").css("transition", "opacity .6s;");
    $(".big__menu .sub-menu").css("opacity", "0");
});

// Custom lazyload script using Intersection Observer
function intersectionObjerver() {
    var lazyloadImages;    
    if ("IntersectionObserver" in window) {
        lazyloadImages = document.querySelectorAll(".lazy");
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var image = entry.target;
                    image.src = image.dataset.src;
                    image.classList.remove("lazy");
                    imageObserver.unobserve(image);
                }
            });
        });

        lazyloadImages.forEach(function(image) {
            imageObserver.observe(image);
        });
    } else {  
        var lazyloadThrottleTimeout;
        lazyloadImages = document.querySelectorAll(".lazy");
        
        function lazyload () {
            if(lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }    

            lazyloadThrottleTimeout = setTimeout(function() {
                var scrollTop = window.pageYOffset;
                lazyloadImages.forEach(function(img) {
                    if(img.offsetTop < (window.innerHeight + scrollTop)) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
                if(lazyloadImages.length == 0) { 
                    document.removeEventListener("scroll", lazyload, {passive: true});
                    window.removeEventListener("resize", lazyload, {passive: true});
                    window.removeEventListener("orientationChange", lazyload, {passive: true});
                }
            }, 20);
        }

        document.addEventListener("scroll", lazyload, {passive: true});
        window.addEventListener("resize", lazyload, {passive: true});
        window.addEventListener("orientationChange", lazyload, {passive: true});
        
    }
}

intersectionObjerver();

$('.left-column').slick({
    infinite: true,
  	cssEase: 'linear',
    lazyLoad: 'ondemand',
  	slidesToShow: 1,
  	slidesToScroll: 1,
  	speed: 500,
  	autoplay: true,
  	autoplaySpeed: 4000,
    dots: false,
  	fade: true,
    prevArrow: '<p class="js-carousel-control carousel-slick__control--circle carousel-slick__control--left" data-carousel-direction="-1"><span class="visually-hidden">Previous</span><svg class="icon"><use xlink:href="#arrow-left"></use></svg></p>',
	nextArrow: '<p class="js-carousel-control carousel-slick__control--circle carousel-slick__control--right" data-carousel-direction="1"><span class="visually-hidden">Next</span><svg class="icon"><use xlink:href="#arrow-right"></use></svg></p>',
});

$('.category__wrapper, .product__wrapper').slick({
    infinite: true,
    cssEase: 'linear',
    lazyLoad: 'ondemand',
    slidesToShow: 6,
    slidesToScroll: 1,
    speed: 2000,
    autoplay: true,
    autoplaySpeed: 2500,
    dots: false,
    arrows: false,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 860,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false
      }
    }
  ]
});