document.addEventListener(
  "click",
  function (event) {
    const isModal = $("#productModal").is(":visible");

    // weight inits
    const initialPrice = $("#initial__price").val();
    const minimumWeight = parseInt($("input[name='minimum__weight']").val());
    let price = isModal
      ? $("#productModal #weight_needed")
      : $("#weight_needed");
    const initialStep = parseInt(price.attr("data-step"));
    let currentStep = parseInt(price.attr("data-current-step"));
    const pricingUnit = $("input[name='pricingUnit']").val();
    const unit = $("input[name='unit']").val();

    let denominator = 1000;

    if (pricingUnit === "g") {
      denominator = initialStep;
    }
    // pieces inits
    var quantity = isModal
      ? $("#productModal #quantity-pieces")
      : $("#quantity-pieces");
    var minQuantity = quantity.attr("min");
    var step = quantity.attr("step");
    var value = quantity.attr("value");

    // weight funcs
    if (event.target.matches("#minus")) {
      if (currentStep === minimumWeight) return;

      let stepper = currentStep - initialStep;
      price.attr("data-current-step", stepper);
      currentStep = parseInt(price.attr("data-current-step"));
      let shownPrice = initialPrice * (stepper / denominator);
      shownPrice = shownPrice.toFixed(2);

      if (isModal) {
        $(".modal-content input[name='weight_needed']").val(currentStep);
        $(".modal-content #weight_needed").val(
          `${shownPrice}€ / ${currentStep}${unit}`
        );
      } else {
        $("input[name='weight_needed']").val(currentStep);
        $("#weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
      }
    }

    if (event.target.matches("#plus")) {
      let stepper = currentStep + initialStep;
      price.attr("data-current-step", stepper);
      currentStep = parseInt(price.attr("data-current-step"));
      let shownPrice = initialPrice * (stepper / denominator);
      shownPrice = shownPrice.toFixed(2);

      if (isModal) {
        $(".modal-content input[name='weight_needed']").val(currentStep);
        $(".modal-content #weight_needed").val(
          `${shownPrice}€ / ${currentStep}${unit}`
        );
      } else {
        $("input[name='weight_needed']").val(currentStep);
        $("#weight_needed").val(`${shownPrice}€ / ${currentStep}${unit}`);
      }
    }

    if (event.target.matches("#plus_pieces")) {
      let nextVal = parseInt(value) + parseInt(step);

      if (isModal) quantity = $(".modal-content #quantity-pieces");

      quantity.attr("value", nextVal);
      value = quantity.attr("value");
    }

    if (event.target.matches("#minus_pieces")) {
      if (value === minQuantity) return;
      let nextVal = parseInt(value) - parseInt(step);

      if (isModal) quantity = $(".modal-content #quantity-pieces");

      quantity.attr("value", nextVal);
      value = quantity.attr("value");
    }

    if (event.target.matches("button[name='add-to-cart']")) {
      _tfa.push({
        notify: "event",
        name: "add-to-cart",
        id: 1456793,
        revenue: "",
        currency: "EUR",
        productid: wc_price_calculator_params.product_id,
        quantity: quantity.val(),
      });
    }
  },
  false
);

const escapeRegExp = function (strToEscape) {
  // Escape special characters for use in a regular expression
  return strToEscape.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
};

const trimChar = function (origString, charToTrim) {
  charToTrim = escapeRegExp(charToTrim);
  let regEx = new RegExp("^[" + charToTrim + "]+|[" + charToTrim + "]+$", "g");
  return origString.replace(regEx, "");
};

// Figure out curent category from slug in URL and add 'current-cat' class to show it in the categories
let currentURL = decodeURIComponent($(window.location)[0].href);
let splitURL = currentURL.split("product-category");
let slug = splitURL[splitURL.length - 1];

function cleanSlug(slug) {
  if (slug.includes("orderby")) {
    slug = slug.split("?")[0];
  }

  if (slug.includes("/page")) {
    slug = slug.split("/page")[0];
  }

  slug = trimChar(slug, "/");
  if (slug.includes("/")) {
    slug = slug.split("/");
    slug = slug[slug.length - 1];
  }

  return slug;
}

const parentCat = "cat-parent";
const childCat = "cat-children";

// Toggling child categories in product filters
$(".cats-toggle").click(function () {
  if ($(this).next().hasClass("active")) {
    $(this).next().removeClass("active").slideUp(600);
  } else {
    $(this).parents().find("li .children").removeClass("active").slideUp(600);
    $(this).next().toggleClass("active").slideToggle(600);
  }

  $(".cats-toggle").each(function () {
    $(this).siblings(".children").hasClass("active")
      ? $(this).addClass("active")
      : $(this).removeClass("active");
  });
});

$(".cat-item .cats").on("click", function () {
  let currentCat = $(this);
  let situation;
  if ($(this).parent().hasClass(parentCat)) {
    situation = "parent";
  } else if ($(this).hasClass(childCat)) {
    situation = "child";
  } else {
    situation = "childless";
  }
  if ($(".filters__area").hasClass("filters--active"))
    $(".filters__area").removeClass("filters--active");

  // toggling arrows while toggling categories
  $(".cats-toggle").each(function () {
    $(this)
      .parents(".product__categories")
      .find(".cat-parent .cats-toggle")
      .removeClass("active");
    currentCat.siblings(".cats-toggle").addClass("active");
  });

  $(this)
    .parents(".product__categories")
    .find("li .cats")
    .removeClass("current-cat");
  $(this).addClass("current-cat");

  if (situation === "parent" || situation === "childless") {
    $(this)
      .parents(".product__categories")
      .find("li .children")
      .removeClass("active")
      .slideUp(600);
  }

  if (situation === "parent") {
    $(this).siblings(".children").addClass("active").slideDown(600);
  }
});

// pre-select category, expand if child and toggle arrow
$(".cat-item .cats").each(function () {
  if ($(this).data("slug") === cleanSlug(slug)) {
    $(this).parents().siblings(".cats").trigger("click");
    $(this).addClass("current-cat").trigger("click");
    if ($(this).parent().hasClass(parentCat)) {
      $(this).siblings(".cats-toggle").addClass("active");
    }
    if ($(this).hasClass(childCat)) {
      $(this).parents().siblings(".cats-toggle").addClass("active");
    }
  }
});

// mail subscribe
const email_regex =
  /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
$(".newsletter__btn").on("click", function () {
  let email = $("#mce-EMAIL").val();

  if (email.length > 0 && email_regex.test(email)) {
    $("#mc-embedded-subscribe").click();
  }
});

$(".filters__area__sidebar--toggle").on("click", function () {
  $(".filters__area").toggleClass("filters--active");
});

$(".site-header-cart").on("click", function () {
  $(".mini__cart--wrapper").addClass("cart--open");
  $("#site-overlay").css("display", "block");
  $("#site-overlay").addClass("blurry");
});

$(document).on("click", ".mini__cart--close", function () {
  $(".mini__cart--wrapper").removeClass("cart--open");
  $("#site-overlay").css("display", "none");
  $("#site-overlay").removeClass("blurry");
});

$(document).mouseup(function (e) {
  if (
    !$(".mini__cart--wrapper").is(e.target) &&
    $(".mini__cart--wrapper").has(e.target).length === 0
  ) {
    $(".mini__cart--wrapper").removeClass("cart--open");
    $("#site-overlay").css("display", "none");
    $("#site-overlay").removeClass("blurry");
  }
});

// Quick view pop-up
$(document).on("click", ".close", function () {
  $("#productModal").fadeOut();
  $("body").removeClass("quick-view__no-scroll");
});

$(document).on("click", "#productModal", function (e) {
  if (e.target !== this) return;
  $("#productModal").fadeOut();
  $("body").removeClass("quick-view__no-scroll");
});

$(document).on("click", ".cart-btn__minus", function () {
  let input = $(this).next("input.qty");
  let inputVal = parseInt(input.val());
  let updatedVal = inputVal - 1;
  if (input.val() == 1) return;
  input.val(updatedVal);
  $("[name='update_cart']").removeAttr("disabled");
  $("[name='update_cart']").trigger("click");
});

$(document).on("click", ".cart-btn__plus", function () {
  let input = $(this).prev("input.qty");
  let inputVal = parseInt(input.val());
  let updatedVal = inputVal + 1;
  input.val(updatedVal);
  $("[name='update_cart']").removeAttr("disabled");
  $("[name='update_cart']").trigger("click");
});

$(document).ready(function () {
  $(".insta-gallery-link").each(function () {
    $(this).attr("rel", "noopener");
  });

  $(".insta-gallery-icon").each(function () {
    $(this).attr("rel", "noopener");
  });
});

// Toggle hamburger
$(".hamburger").on("click", function () {
  $(".hamburger").toggleClass("is-active");
});

$(".widget_shopping_cart").prependTo("#page");

$("#shop-menu")
  .find("> li > a")
  .addClass("toggle")
  .attr("href", "javascript:void(0);").append(`
        <svg class="plus-svg">
			<use xlink:href="#plus"></use>
		</svg>
        <svg class="minus-svg">
            <use xlink:href="#minus"></use>
        </svg>
    `);

$("#shop-menu").appendTo("#primary-menu");

$(".toggle").click(function () {
  if ($(this).next().hasClass("active")) {
    $(this).next().removeClass("active");
    $(this).next().slideUp(600);
  } else {
    $(this).parent().parent().find("li .sub-menu").removeClass("active");
    $(this).parent().parent().find("li .sub-menu").slideUp(600);
    $(this).next().toggleClass("active");
    $(this).next().slideToggle(600);
  }

  $(".toggle").each(function () {
    if ($(this).siblings(".sub-menu").hasClass("active")) {
      $(this).parent().find(".toggle").addClass("active");
    } else {
      $(this).parent().find(".toggle").removeClass("active");
    }
  });
});

if (currentURL.includes("checkout") && currentURL.includes("wc_order")) {
  let cartValue = $(".woocommerce-order-overview__total bdi").text();

  if (cartValue.includes("€")) cartValue = cartValue.replace(/€/g, "");

  const splitOrder = currentURL.split("?")[0];
  let order = trimChar(splitOrder, "/").split("/");
  order = order[order.length - 1];

  gtag("event", "conversion", {
    send_to: "AW-10895649924/QJO2COyyhroDEITZucso",
    value: cartValue,
    currency: "EUR",
    transaction_id: order,
  });
}

// Inner dropdown menu eventPreventDefault for touch devices
// window.USER_IS_TOUCHING = false;
// window.addEventListener('touchstart', function onFirstTouch() {
// 	USER_IS_TOUCHING = true;
// 	// we only need to know once that a human touched the screen, so we can stop listening now
// 	window.removeEventListener('touchstart', onFirstTouch, false);
// }, false);

// function is_touch_device() {
// 	return 'ontouchstart' in window		// works on most browsers
// 	|| navigator.maxTouchPoints;		// works on IE10/11 and Surface
// };

// $('.main-navigation .big__menu').on('click', function(e) {
// 	var target = $(e.target);
// 	var parent = target.parent(); // the li
// 	if (is_touch_device() || window.USER_IS_TOUCHING) {
// 		if (target.hasClass("active")) {
// 			//run default action of the link
// 		}
// 		else {
// 			e.preventDefault();
// 			//remove class active from all links
// 			$('.main-navigation .big__menu.active').removeClass('active');
// 			//set class active to current link
// 			target.addClass("active");
// 			parent.addClass("active");
// 		}
// 	}
// });

// // Remove class active from all links if li was clicked
// $('.big__menu').click(function(e) {
// 	if (e.target == this) $(".active").removeClass('active');
// });

// Shop submenu
$(".big__menu").hover(
  function () {
    $(".big__menu .sub-menu").css({
      visibility: "visible",
      transition: "opacity .6s",
      opacity: "1",
    });
  },
  function () {
    $(".big__menu .sub-menu").css({
      visibility: "hidden",
      transition: "opacity .6s",
      opacity: "0",
    });
  }
);

// Custom lazyload script using Intersection Observer
function intersectionObjerver() {
  let lazyloadImages;
  if ("IntersectionObserver" in window) {
    lazyloadImages = document.querySelectorAll(".lazy");
    let imageObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          let image = entry.target;
          image.src = image.dataset.src;
          image.classList.remove("lazy");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function (image) {
      imageObserver.observe(image);
    });
  } else {
    let lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");

    function lazyload() {
      if (lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function () {
        let scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function (img) {
          if (img.offsetTop < window.innerHeight + scrollTop) {
            img.src = img.dataset.src;
            img.classList.remove("lazy");
          }
        });
        if (lazyloadImages.length == 0) {
          document.removeEventListener("scroll", lazyload, { passive: true });
          window.removeEventListener("resize", lazyload, { passive: true });
          window.removeEventListener("orientationChange", lazyload, {
            passive: true,
          });
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload, { passive: true });
    window.addEventListener("resize", lazyload, { passive: true });
    window.addEventListener("orientationChange", lazyload, { passive: true });
  }
}

intersectionObjerver();

$("#search").on("click", function () {
  $(".search-full-screen").addClass("opened");
  //$(".search-full-screen").css("top", "181px");
});

$(".close-search").on("click", function () {
  $(".search-full-screen").removeClass("opened");
  $(".search-query").val("");
  $('[class^="products columns-"]').empty();
});

const prevArrow =
  '<p class="js-carousel-control carousel-slick__control--circle carousel-slick__control--left" data-carousel-direction="-1"><span class="visually-hidden">Previous</span><svg class="icon"><use xlink:href="#arrow-left"></use></svg></p>';
const nextArrow =
  '<p class="js-carousel-control carousel-slick__control--circle carousel-slick__control--right" data-carousel-direction="1"><span class="visually-hidden">Next</span><svg class="icon"><use xlink:href="#arrow-right"></use></svg></p>';

$(".left-column").slick({
  infinite: true,
  cssEase: "linear",
  lazyLoad: "ondemand",
  slidesToShow: 1,
  slidesToScroll: 1,
  speed: 500,
  autoplay: true,
  autoplaySpeed: 4000,
  dots: false,
  fade: true,
  prevArrow,
  nextArrow,
});

$(".flex-control-nav")
  .wrap('<div class="flex-control-nav flex-control-thumbs">')
  .contents()
  .unwrap();
$(".flex-control-nav li").wrap("<div>").contents().unwrap();

$(".flex-control-nav.flex-control-thumbs").slick({
  infinite: true,
  cssEase: "linear",
  lazyLoad: "ondemand",
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
  dots: false,
  swipeToSlide: true,
  prevArrow,
  nextArrow,
});

$(".category__wrapper, .product__wrapper").slick({
  infinite: true,
  cssEase: "linear",
  lazyLoad: "ondemand",
  slidesToShow: 6,
  slidesToScroll: 1,
  speed: 1000,
  autoplay: true,
  autoplaySpeed: 2500,
  dots: false,
  swipeToSlide: true,
  prevArrow,
  nextArrow,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 860,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      },
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        dots: false,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
      },
    },
  ],
});
