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


$('a[data-slide]').click(function(e) {
  e.preventDefault();
  var slideno = $(this).data('slide');
  $('.slider-nav').slick('slickGoTo', slideno - 1);
});


/**sensual buscador */


  $('.search').on('click', function () {
    $('.search .list_search').addClass('active_s')
   
  })

  $('.nav-grid').bind('mouseleave',function(){
    $('.list_search').removeClass('active_s') 
});