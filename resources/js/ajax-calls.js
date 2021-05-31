var url = ajax.ajaxUrl;
var baseDir = ajax.baseDir;

// AJAX for SVG sprite
window.addEventListener('load', function(event) {
    var svgAjax = new XMLHttpRequest();
    svgAjax.open("GET", baseDir + "/dist/svg/sprite.svg", true);
    svgAjax.send();
    svgAjax.onload = function(e) {
        var div = document.createElement("div");
        div.innerHTML = svgAjax.responseText;
        div.setAttribute("id", "sprites");
        div.style.display = "none";
        document.body.insertBefore(div, document.body.childNodes[0]);
    }
});

jQuery('document').ready(function($) {
    $("form.woocommerce-ordering, #search__form").submit(function(e){
        e.preventDefault();
    });

    $(document).on('click', '.product__categories li .cats', function(e) {
        e.preventDefault();

        var slug = decodeURIComponent($(this).data('slug'));
        var link = decodeURIComponent($(this).attr('href'));
        var productCount = $(this).data('product-count');
        var orderby = $('.orderby').find(":selected").val();
        var pageNumber = 1;

        $.ajax({
            url,
            type: 'POST',
            data: {
                action: 'filter__categories',
                slug,
                orderby,
                productCount
            },
            beforeSend: function() {
               $(".lds-ellipsis").css("display", "block");
            },
        }).then(function(data) {
            $('[class^="products columns-"]').html(data);

            // delete original pagination and append ajaxed one
            $('.products__area > .woocommerce-pagination').remove();
            $('.woocommerce-pagination').appendTo('.products__area');
      
            // delete original result count + sorting and append ajaxed one
            $('.products__area > .products__ordering').remove();
            $('.products__ordering').prependTo('.products__area');

            // hide ajax loading  + show quick view
            $(".lds-ellipsis").css("display", "none");
            $('.yith-wcqv-button').css("display", "inline-block");

            window.history.pushState("", "", link + `?paged=${pageNumber}&orderby=${orderby}`);
        }).fail(function(data) {
            console.log(data.responseText);
            console.log('Request failed: ' + data.statusText);
        });
    });

    $(document).on('click', '.woocommerce-pagination.paginator .page-numbers', function(e) {
        e.preventDefault();

        var slug = decodeURIComponent($('.cats.current-cat').data('slug'));
        var link = decodeURIComponent($('.cats.current-cat').attr('href'));
        var productCount = $('.cats.current-cat').data('product-count');
        var orderby = $('.orderby').find(":selected").val();
        var searchField = $('#search__form input[name="search-input"]').val();
        var currentNumber = parseInt($('.page-numbers.current').text());
        var pageNumber = parseInt($(this).text());
        var currentURL = window.location.pathname + window.location.search;

        if (link === "undefined") link = "";

        if ($(this).hasClass('next')) {
            pageNumber = currentNumber + 1;
        } else if ($(this).hasClass('prev')) {
            pageNumber = currentNumber - 1;
        } else {
            pageNumber;
        }

        $.ajax({
            url,
            type: 'POST',
            data: {
                action: 'ajax__pagination',
                slug,
                pageNumber,
                productCount,
                orderby,
                searchField,
                currentURL
            },
            beforeSend: function() {
               $(".lds-ellipsis").css("display", "block");
            },
        }).then(function(data) {    
            $('html, body').animate({
                scrollTop: $('.products__main-page').offset().top
            }, 1000);

            $('[class^="products columns-"]').html(data);

            // delete original pagination and append ajaxed one
            $('.products__area > .woocommerce-pagination').remove();
            $('.woocommerce-pagination').appendTo('.products__area');
            
            // delete original result count + sorting and append ajaxed one
            $('.products__area > .products__ordering').remove();
            $('.products__ordering').prependTo('.products__area');

            // hide ajax loading  + show quick view
            $(".lds-ellipsis").css("display", "none");
            $('.yith-wcqv-button').css("display", "inline-block");
            
            if (searchField) {
                window.history.pushState("", "", link + `?paged=${pageNumber}&search=search-products&search-input=${searchField}`);
            } else {
                window.history.pushState("", "", link + `?paged=${pageNumber}&orderby=${orderby}`);
            }
        }).fail(function(data) {
            console.log(data.responseText);
            console.log('Request failed: ' + data.statusText);
        });
    });

    $(document).on('change', '.woocommerce-ordering .orderby', function(e) {
        var orderby = $(this).find(":selected").val();
        var slug = decodeURIComponent($('.cats.current-cat').data('slug'));
        var link = decodeURIComponent($('.cats.current-cat').attr('href'));
        var productCount = $('.cats.current-cat').data('product-count');
        var pageNumber = $('.woocommerce-ordering input[name="paged"]').val();
        var searchField = $('#search__form input[name="search-input"]').val();
        var currentURL = window.location.pathname + window.location.search;

        if (link === "undefined") link = "";

        $.ajax({
            url,
            type: 'POST',
            data: {
                action: 'ajax__οrderΒy',
                slug,
                productCount,
                orderby,
                pageNumber,
                currentURL
            },
            beforeSend: function() {
               $(".lds-ellipsis").css("display", "block");
            },
        }).then(function(data) {
            //console.log("data: ", data);    
            $('html, body').animate({
                scrollTop: $('.products__main-page').offset().top
            }, 1000);

            $('[class^="products columns-"]').html(data);

            // delete original pagination and append ajaxed one
            $('.products__area > .woocommerce-pagination').remove();
            $('.woocommerce-pagination').appendTo('.products__area');
            
            // delete original result count + sorting and append ajaxed one
            $('.products__area > .products__ordering').remove();
            $('.products__ordering').prependTo('.products__area');

            // hide ajax loading  + show quick view
            $(".lds-ellipsis").css("display", "none");
            $('.yith-wcqv-button').css("display", "inline-block");
            
            if (searchField) {
                window.history.pushState("", "", link + `?paged=${pageNumber}&orderby=${orderby}&search=search-products&search-input=${searchField}`);
            } else {
                window.history.pushState("", "", link + `?paged=${pageNumber}&orderby=${orderby}`);
            }
        }).fail(function(data) {
            console.log(data.responseText);
            console.log('Request failed: ' + data.statusText);
        });
    });

    $(document).on('click', '#search-submit', function(e) {
        var searchField = $('#search__form input[name="search-input"]').val();
        var orderby = $('.orderby').find(":selected").val();
        var link = decodeURIComponent($('.cats.current-cat').attr('href'));
        var pageNumber = 1;

        if (link === "undefined") link = "";

        $.ajax({
            url,
            type: 'POST',
            data: {
                action: 'ajax__searchField',
                searchField,
                orderby
            },
            beforeSend: function() {
               $(".lds-ellipsis").css("display", "block");
            },
        }).then(function(data) {
            //console.log("data: ", data);    
            $('html, body').animate({
                scrollTop: $('.products__main-page').offset().top
            }, 1000);

            $('[class^="products columns-"]').html(data);

            // delete original pagination and append ajaxed one
            $('.products__area > .woocommerce-pagination').remove();
            $('.woocommerce-pagination').appendTo('.products__area');
            
            // delete original result count + sorting and append ajaxed one
            $('.products__area > .products__ordering').remove();
            $('.products__ordering').prependTo('.products__area');

            // hide ajax loading  + show quick view
            $(".lds-ellipsis").css("display", "none");
            $('.yith-wcqv-button').css("display", "inline-block");
            
            window.history.pushState("", "", link + `?paged=${pageNumber}&orderby=${orderby}&search=search-products&search-input=${searchField}`);
        }).fail(function(data) {
            console.log(data.responseText);
            console.log('Request failed: ' + data.statusText);
        });
    });
});