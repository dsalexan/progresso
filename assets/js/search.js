
$(document).ready(function () {
    $('#myCarousel').carousel();

    $('.ui.card .ui.ribbon.label.hoverable').hover(function(){
        $(this).toggleClass('grey');
        $(this).toggleClass('red');
    });
});