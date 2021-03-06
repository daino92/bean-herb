var url = ajax.ajaxUrl;
var baseDir = ajax.baseDir;

function delayEvent(fn, delay) {
  var timer = null;
  // this is the actual function that gets run.
  return function (e) {
    var self = this;
    // if the timeout exists clear it
    timer && clearTimeout(timer);
    // set a new timout
    timer = setTimeout(function () {
      return fn.call(self, e);
    }, delay || 200);
  };
}

// AJAX for SVG sprite
window.addEventListener("load", function () {
  var svgAjax = new XMLHttpRequest();
  svgAjax.open("GET", baseDir + "/dist/svg/sprite.svg", true);
  svgAjax.send();
  svgAjax.onload = function () {
    var div = document.createElement("div");
    div.innerHTML = svgAjax.responseText;
    div.setAttribute("id", "sprites");
    div.style.display = "none";
    document.body.insertBefore(div, document.body.childNodes[0]);
  };
});

jQuery("document").ready(function ($) {
  $("form.woocommerce-ordering, #search__form").submit(function (e) {
    e.preventDefault();
  });

  $(document).on("click", ".product__categories li .cats", function (e) {
    e.preventDefault();

    var slug = decodeURIComponent($(this).data("slug"));
    var link = decodeURIComponent($(this).attr("href"));
    var productCount = $(this).data("product-count");
    var orderby = $(".orderby").find(":selected").val();
    var pageNumber = 1;

    $.ajax({
      url,
      type: "POST",
      data: {
        action: "filter__categories",
        slug,
        orderby,
        productCount,
      },
      beforeSend: function () {
        $("#site-overlay").css("display", "block");
        $(".lds-ellipsis").css("display", "block");
      },
    })
      .then(function (data) {
        $('[class^="products columns-"]').html(data);

        intersectionObjerver();

        // delete original pagination and append ajaxed one
        $(".products__area > .woocommerce-pagination").remove();
        $(".woocommerce-pagination").appendTo(".products__area");

        // delete original result count + sorting and append ajaxed one
        $(".products__area > .products__ordering").remove();
        $(".products__ordering").prependTo(".products__area");

        // hide ajax loading
        $("#site-overlay").css("display", "none");
        $(".lds-ellipsis").css("display", "none");

        window.history.pushState(
          "",
          "",
          link + `?paged=${pageNumber}&orderby=${orderby}`
        );
      })
      .fail(function (data) {
        console.log(data.responseText);
        console.log("Request failed: " + data.statusText);
      });
  });

  $(document).on(
    "click",
    ".woocommerce-pagination.paginator .page-numbers",
    function (e) {
      e.preventDefault();

      var slug = decodeURIComponent($(".cats.current-cat").data("slug"));
      var link = decodeURIComponent($(".cats.current-cat").attr("href"));
      var productCount = $(".cats.current-cat").data("product-count");
      var orderby = $(".orderby").find(":selected").val();
      var searchField = $('#search__form input[name="search-input"]').val();
      var currentNumber = parseInt($(".page-numbers.current").text());
      var pageNumber = parseInt($(this).text());
      var currentURL = decodeURIComponent(
        window.location.pathname + window.location.search
      );

      if (link === "undefined") link = "";

      if (searchField === "") {
        searchField = window.location.search.split("search-input=")[1];
      }

      if ($(this).hasClass("next")) {
        pageNumber = currentNumber + 1;
      } else if ($(this).hasClass("prev")) {
        pageNumber = currentNumber - 1;
      } else {
        pageNumber;
      }

      $.ajax({
        url,
        type: "POST",
        data: {
          action: "ajax__pagination",
          slug,
          pageNumber,
          productCount,
          orderby,
          searchField,
          currentURL,
        },
        beforeSend: function () {
          $("#site-overlay").css("display", "block");
          $(".lds-ellipsis").css("display", "block");
        },
      })
        .then(function (data) {
          $("html, body").animate(
            {
              scrollTop: $(".products__main-page").offset().top,
            },
            1000
          );

          $('[class^="products columns-"]').html(data);

          intersectionObjerver();

          // delete original pagination and append ajaxed one
          $(".products__area > .woocommerce-pagination").remove();
          $(".woocommerce-pagination").appendTo(".products__area");

          // delete original result count + sorting and append ajaxed one
          $(".products__area > .products__ordering").remove();
          $(".products__ordering").prependTo(".products__area");

          // hide ajax loading
          $("#site-overlay").css("display", "none");
          $(".lds-ellipsis").css("display", "none");

          if (searchField) {
            window.history.pushState(
              "",
              "",
              link +
                `?paged=${pageNumber}&orderby=${orderby}&search=search-products&search-input=${searchField}`
            );
          } else {
            window.history.pushState(
              "",
              "",
              link + `?paged=${pageNumber}&orderby=${orderby}`
            );
          }
        })
        .fail(function (data) {
          console.log(data.responseText);
          console.log("Request failed: " + data.statusText);
        });
    }
  );

  $(document).on("change", ".woocommerce-ordering .orderby", function (e) {
    var orderby = $(this).find(":selected").val();
    var slug = decodeURIComponent($(".cats.current-cat").data("slug"));
    var link = decodeURIComponent($(".cats.current-cat").attr("href"));
    var productCount = $(".cats.current-cat").data("product-count");
    var pageNumber = $('.woocommerce-ordering input[name="paged"]').val();
    var searchField = $('#search__form input[name="search-input"]').val();
    var currentURL = decodeURIComponent(
      window.location.pathname + window.location.search
    );

    if (link === "undefined") link = "";

    if (searchField === "") {
      searchField = window.location.search.split("search-input=")[1];
    }

    $.ajax({
      url,
      type: "POST",
      data: {
        action: "ajax__??rder??y",
        slug,
        productCount,
        orderby,
        pageNumber,
        currentURL,
      },
      beforeSend: function () {
        $("#site-overlay").css("display", "block");
        $(".lds-ellipsis").css("display", "block");
      },
    })
      .then(function (data) {
        $("html, body").animate(
          {
            scrollTop: $(".products__main-page").offset().top,
          },
          1000
        );

        $('[class^="products columns-"]').html(data);

        intersectionObjerver();

        // delete original pagination and append ajaxed one
        $(".products__area > .woocommerce-pagination").remove();
        $(".woocommerce-pagination").appendTo(".products__area");

        // delete original result count + sorting and append ajaxed one
        $(".products__area > .products__ordering").remove();
        $(".products__ordering").prependTo(".products__area");

        // hide ajax loading
        $("#site-overlay").css("display", "none");
        $(".lds-ellipsis").css("display", "none");

        if (searchField) {
          window.history.pushState(
            "",
            "",
            link +
              `?paged=${pageNumber}&orderby=${orderby}&search=search-products&search-input=${searchField}`
          );
        } else {
          window.history.pushState(
            "",
            "",
            link + `?paged=${pageNumber}&orderby=${orderby}`
          );
        }
      })
      .fail(function (data) {
        console.log(data.responseText);
        console.log("Request failed: " + data.statusText);
      });
  });

  $(document).on("click", "#search-submit", function (e) {
    var searchField = $('#search__form input[name="search-input"]').val();
    var orderby = $(".orderby").find(":selected").val();
    var link = decodeURIComponent($(".cats.current-cat").attr("href"));
    var pageNumber = 1;

    if (link === "undefined") link = "";

    if (searchField) {
      $.ajax({
        url,
        type: "POST",
        data: {
          action: "ajax__searchField",
          searchField,
          orderby,
        },
        beforeSend: function () {
          $("#site-overlay").css("display", "block");
          $(".lds-ellipsis").css("display", "block");
        },
      })
        .then(function (data) {
          $("html, body").animate(
            {
              scrollTop: $(".products__main-page").offset().top,
            },
            1000
          );

          $('[class^="products columns-"]').html(data);

          intersectionObjerver();

          // delete original pagination and append ajaxed one
          $(".products__area > .woocommerce-pagination").remove();
          $(".woocommerce-pagination").appendTo(".products__area");

          // delete original result count + sorting and append ajaxed one
          $(".products__area > .products__ordering").remove();
          $(".products__ordering").prependTo(".products__area");

          // hide ajax loading
          $("#site-overlay").css("display", "none");
          $(".lds-ellipsis").css("display", "none");

          window.history.pushState(
            "",
            "",
            link +
              `?paged=${pageNumber}&orderby=${orderby}&search=search-products&search-input=${searchField}`
          );
        })
        .fail(function (data) {
          console.log(data.responseText);
          console.log("Request failed: " + data.statusText);
        });
    }
  });

  $("#homepage-search").on(
    "keyup",
    delayEvent(function (e) {
      var searchField = $("#homepage-search .search-query").val();

      if (searchField.length > 2) {
        switch (e.keyCode) {
          case 9:
          case 13:
          case 16:
          case 17:
          case 18:
          case 20:
          case 21:
          case 33:
          case 34:
          case 35:
          case 36:
          case 37:
          case 38:
          case 39:
          case 40:
          case 144:
          case 145:
            e.preventDefault();
            return;
            break;
          default:
            $.ajax({
              url,
              type: "POST",
              data: {
                action: "ajax__searchHome",
                searchField,
              },
              beforeSend: function () {
                $("#site-overlay").css("display", "block");
                $(".lds-ellipsis").css("display", "block");
              },
            })
              .then(function (data) {
                $(".search-results__wrapper").css("display", "block");
                $(".products__results .the__products").html(data);

                intersectionObjerver();

                // hide ajax loading
                $("#site-overlay").css("display", "none");
                $(".lds-ellipsis").css("display", "none");
              })
              .fail(function (data) {
                console.log(data.responseText);
                console.log("Request failed: " + data.statusText);
              });
        }
      }
    }, 800)
  );

  $(document).on("click", ".quick-view__open-single-product", function (e) {
    e.preventDefault();
    var id = $(this).data("id");

    if (id < 1) return;

    $.ajax({
      type: "POST",
      url: $("#productModal").data("url"),
      data: {
        action: "QuickView__action",
        id,
      },
      beforeSend: function () {
        $("#site-overlay").css("display", "block");
        $(".lds-ellipsis").css("display", "block");
      },
    }).done(function (result) {
      $("#site-overlay").css("display", "none");
      $(".lds-ellipsis").css("display", "none");
      $("#productModal > .modal-content").html(
        result + '<span class="close">&times;</span>'
      );
      $("#productModal").fadeIn();
      $("body").addClass("qvwp-no-scroll");
    });
    return false;
  });

  // $(document).on('click', '.modal-content .single_add_to_cart_button', function(e) {
  //     e.preventDefault();

  //     var $thisbutton = $(this),
  //         $form = $thisbutton.closest('form.cart'),
  //         id = $thisbutton.val(),
  //         quantity = $form.find('input[name=quantity]').val() || 1,
  //         productId = $form.find('input[name=product_id]').val() || id,
  //         variationId = $form.find('input[name=variation_id]').val() || 0,
  //         carUrl = decodeURIComponent(wc_add_to_cart_params.cart_url),
  //         currentLang = $('html')[0].getAttribute('lang');
  //         productName = $('.single-product__main-body .product_title').text();

  //     var displayCart, message;

  //     if (currentLang === "el") {
  //         displayCart = "?????????????? ????????????????";
  //         message = `???? ???????????? ${productName} ???????? ?????????????????? ?????? ???????????? ??????.`;
  //     } else {
  //         displayCart = "View basket";
  //         message = `${productName} has been added to your basket.`;
  //     }

  //     var successMessage = `<div class="woocommerce-message" role="alert">`;
  //         successMessage += `<svg><use xlink:href="#check"></use></svg>`;
  //         successMessage += `<div class="woocommerce-message-text">`;
  //         successMessage += `<a href="${carUrl}" tabindex="1" class="button wc-forward">${displayCart}</a>`;
  //         successMessage += `${message}</div></div>`;

  //     var data = {
  //         action: 'add_to_cart',
  //         productId,
  //         productSku: "",
  //         quantity,
  //         variationId,
  //     };

  //     $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

  //     $.ajax({
  //         url,
  //         type: 'POST',
  //         data,
  //     }).done(function (response) {
  //         $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
  //         $('#productModal').fadeOut();
  //         $(successMessage).appendTo('.woocommerce-notices-wrapper');
  //     }).fail(function(response) {
  //         console.log(response.responseText);
  //         console.log('Request failed: ' + response.statusText);
  //     });
  // });

  // $(document).on('click', '.single .single_add_to_cart_button', function(e) {
  //     e.preventDefault();

  //     var $thisbutton = $(this),
  //         $form = $thisbutton.closest('form.cart'),
  //         id = $thisbutton.val(),
  //         quantity = $form.find('input[name=quantity]').val() || 1,
  //         productId = $form.find('input[name=product_id]').val() || id,
  //         variationId = $form.find('input[name=variation_id]').val() || 0,
  //         carUrl = decodeURIComponent(wc_add_to_cart_params.cart_url),
  //         currentLang = $('html')[0].getAttribute('lang');
  //         productName = $('.single-product__main-body .product_title').text();

  //     var weightNeeded = $('input[name=weight_needed]').val(),
  //     minimumWeight = $('input[name=minimum__weight]').val(),
  //     pricingUnit = $('input[name=pricingUnit]').val(),
  //     unit = $('input[name=unit]').val(),
  //     measurementWeededUnit = $('input[name=_measurement_needed_unit]').val(),
  //     measurementNeeded = $('input[name=_measurement_needed]').val();

  //     var displayCart, message;

  //     if (currentLang === "el") {
  //         displayCart = "?????????????? ????????????????";
  //         message = `???? ???????????? ${productName} ???????? ?????????????????? ?????? ???????????? ??????.`;
  //     } else {
  //         displayCart = "View basket";
  //         message = `${productName} has been added to your basket.`;
  //     }

  //     var successMessage = `<div class="woocommerce-message" role="alert">`;
  //         successMessage += `<svg><use xlink:href="#check"></use></svg>`;
  //         successMessage += `<div class="woocommerce-message-text">`;
  //         successMessage += `<a href="${carUrl}" tabindex="1" class="button wc-forward">${displayCart}</a>`;
  //         successMessage += `${message}</div></div>`;

  //     var data = {
  //         action: 'add_to_cart',
  //         productId,
  //         productSku: "",
  //         quantity,
  //         variationId,
  //         weightNeeded,
  //         minimumWeight,
  //         weightNeeded,
  //         pricingUnit,
  //         unit,
  //         measurementWeededUnit,
  //         measurementNeeded
  //     };

  //     $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

  //     $.ajax({
  //         url,
  //         type: 'POST',
  //         data,
  //         beforeSend: function () {
  //             $("#site-overlay").css("display", "block");
  //             $(".lds-ellipsis").css("display", "block");
  //         },
  //     }).done(function (response) {
  //         $("#site-overlay").css("display", "none");
  //         $(".lds-ellipsis").css("display", "none");
  //         $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
  //         $(successMessage).appendTo('.woocommerce-notices-wrapper');
  //     }).fail(function(response) {
  //         console.log(response.responseText);
  //         console.log('Request failed: ' + response.statusText);
  //     });
  // });
});
