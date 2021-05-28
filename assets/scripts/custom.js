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

// weight funcs
$("#minus").on("click", function() {
    if (currentStep === minimumWeight) return;
    
    var stepper = currentStep - initialStep;
    price.attr("data-current-step", stepper);
    currentStep = parseInt(price.attr("data-current-step"));
    var shownPrice = (initialPrice * stepper) / denominator;
    shownPrice = shownPrice.toFixed(2);
    $("input[name='weight_needed']").val(currentStep);
    $("#weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
});

$("#plus").on("click", function() {
    var stepper = currentStep + initialStep;
    price.attr("data-current-step", stepper);
    currentStep = parseInt(price.attr("data-current-step"));
    var shownPrice = (initialPrice * stepper) / denominator;
    shownPrice = shownPrice.toFixed(2);
    $("input[name='weight_needed']").val(currentStep);
    $("#weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
});

// pieces funcs
$("#minus_pieces").on("click", function() {
    if (value === minQuantity) {
        return;
    } else {
        var nextVal = parseInt(value) - parseInt(step);
        quantity.attr("value", nextVal);
        value = quantity.attr("value");
    }
});

$("#plus_pieces").on("click", function() {
    var nextVal = parseInt(value) + parseInt(step);
    quantity.attr("value", nextVal);
    value = quantity.attr("value");
});

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

$(window).on('load', function() {

	// Custom lazyload script using Intersection Observer
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
})


$('.filters__area__sidebar--toggle').on('click', function() {
    //$(this).toggleClass("sidebar--active");
    $('.filters__area').toggleClass("filters--active");
});

// $('.woocommerce').on('change', 'input.qty', function(){
//     $("[name='update_cart']").trigger("click");
// });

// var timeout;

// $('.woocommerce').on('change', 'input.qty', function(){
//     if (timeout !== undefined) clearTimeout(timeout);

//     timeout = setTimeout(function() {
//         $("[name='update_cart']").trigger("click");
//     }, 500);
// });