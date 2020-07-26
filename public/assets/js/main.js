// Menú responsive
$(function () {
    $('[data-toggle="offcanvas"]').on("click", function () {
        $(".offcanvas-collapse").toggleClass("open");
        $("body").toggleClasss("offcanvas-expanded");
    });
});

$(".hamburger").on("click", function () {
    $(this).toggleClass("is-active");
});

$(".nav-link").click(function () {
    $(".offcanvas-collapse").removeClass("open");
    $(".hamburger").toggleClass("is-active");
    $("body").removeClass("offcanvas-expanded");
});

$("a[data-slide]").click(function (e) {
    e.preventDefault();
    var slideno = $(this).data("slide");
    $(".slider-nav").slick("slickGoTo", slideno - 1);
});

/**sensual buscador */

$(".search").on("click", function () {
    $(".search .list_search").addClass("active_s");
});

$(".nav-grid").bind("mouseleave", function () {
    $(".list_search").removeClass("active_s");
});

$(function () {
    $("#product-grid").mixItUp();
});

/*slider precio*/
var rangeSlider = document.getElementById("rs-range-line");
var rangeBullet = document.getElementById("rs-bullet");

rangeSlider.addEventListener("input", showSliderValue, false);

function showSliderValue() {
    rangeBullet.innerHTML = rangeSlider.value;
    var bulletPosition = rangeSlider.value / rangeSlider.max;
    rangeBullet.style.left = bulletPosition * 208 + "px";
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
