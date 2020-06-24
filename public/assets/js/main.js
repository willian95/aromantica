   // Menú responsive
   $(function () {
    $('[data-toggle="offcanvas"]').on('click', function () {
      $('.offcanvas-collapse').toggleClass('open');
      $('body').toggleClasss('offcanvas-expanded');
    })
  })


  $(".hamburger").on("click", function () {
    $(this).toggleClass("is-active");
  });

  $('.nav-link').click(function () {
    $('.offcanvas-collapse').removeClass('open');
    $('.hamburger').toggleClass('is-active');
    $('body').removeClass('offcanvas-expanded');
  })

  /*top perfumes */
  $('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    arrows: true,
    focusOnSelect: true
  });


  /*prductos */
  
$('.main-productos__content').slick({
  // infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  dots: false,
  arrows: true,
  responsive: [{
    breakpoint: 1200,
    settings: {
      slidesToShow: 3,
      slidesToScroll: 3,
      infinite: true,
      dots: true
    }
  },
  {
    breakpoint: 900,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 1
    }
  },
  {
    breakpoint: 600,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,

      autoplaySpeed: 1000
    }
  }
  ]
});

/*detalle producto */

$('.slider-for__details').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav__details'
});
$('.slider-nav__details').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-for__details',
  arrows: false,
  focusOnSelect: true
});

$('a[data-slide]').click(function(e) {
  e.preventDefault();
  var slideno = $(this).data('slide');
  $('.slider-nav').slick('slickGoTo', slideno - 1);
});


