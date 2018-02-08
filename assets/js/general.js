$(document).ready(function(){    
    $('#myCarousel').carousel();

    $('#myCarousel').find('[role=button]').click(function(){
        $('#myCarousel').carousel($(this).data('slide'));
    });

    $('.ui.dropdown').dropdown();

    $('#filtro-marca').change(function(){
        var marcas = $(this).find('[name=marcas]').val();
    });
    $('#filtro-outros').change(function(){
        var opcao = $(this).find('[name=filtro]').val();
        
        $('#vehicle-display').dimmer('show');
        $('#vehicle-display').find('.cards').css('opacity', 0.5);
        while($('#vehicle-display').find('.card').length > 3){
            $('#vehicle-display').find('.card')[3].remove()
        }

        /* DO SHIT */

        $('#vehicle-display').find('.cards').css('opacity', 1);
        $('#vehicle-display').dimmer('hide');
    });
});
