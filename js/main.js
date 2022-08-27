var swiper = new Swiper(".mySwiper", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 1500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});


$(document).ready(function() {
  $('.nav-toggle').click(function() {
    var collapse_content_selector = $(this).attr('href');
    var toggle_switch = $(this);
    $(collapse_content_selector).toggle(function() {
      if ($(this).css('display') == 'none') {
        toggle_switch.html('Read More');
      } else {
        toggle_switch.html('Read Less');
      }
    });
  });

});
