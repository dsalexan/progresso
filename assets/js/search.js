
$(document).ready(function () {
    $('#myCarousel').carousel();

    $('.ui.card .ui.ribbon.label').hover(function(){
        $(this).toggleClass('grey');
        $(this).toggleClass('red');
    });
});