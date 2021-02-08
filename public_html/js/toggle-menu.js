$(document).ready(function(){

  $('#toggleMenu').click(function() {
    $(this).toggleClass('active'),
    $('.header_menu').toggleClass('show-menu')
  });

});