var request;
$(document).ready(function(){    
    $('#myCarousel').carousel();

    $('#myCarousel').find('[role=button]').click(function(){
        $('#myCarousel').carousel($(this).data('slide'));
    });

    $('.ui.dropdown').dropdown();

    $('#filtro-marca, #filtro-outros').change(function(){
        var marcas = $(this).find('[name=marcas]').val();
        var opcao = $(this).find('[name=filtro]').val();
        console.log(opcao);
        
        $('#vehicle-display').dimmer('show');
        $('#vehicle-display').find('.cards').css('opacity', 0.5);
        while($('#vehicle-display').find('.card').length > 3){
            $('#vehicle-display').find('.card')[3].remove();
        }

        var filterData = {
            'filtro': opcao,
            'page': 1
        };

        if(marcas != undefined) filterData['m'] = marcas;   

        
        // Abort any pending request
        if (request) {
            request.abort();
        }


        /* DO SHIT */
        request = $.ajax({
            url: base_url('veiculos/filtro'),
            type: 'GET',
            data: filterData,
            dataType : "json",
            success: function(data) {
                
                $('#vehicle-display').find('.card').remove();
                $cards = $('#vehicle-display').find('.cards');
                $lastSon = $('<div id="last-son"></div>');
                $lastSon.appendTo($cards);

                $.each(data, function (index, veiculo){
                    // console.log(veiculo);
                    $card = renderCard(veiculo);

                    $card.insertBefore($lastSon);
                    $card.show().removeAttr('hidden');
                });
                
                $('.ui.display').click(function(){
                    if(!$(this).hasClass('expanded')){   
                        expand_display(this);
                    }else{
                        colapse_display(this);
                    }
                });

                $('#vehicle-display').find('.cards').css('opacity', 1);
                $('#vehicle-display').dimmer('hide');    
            }
        });

    });
});


function renderCard(veiculo){
    var sampleCard = $("#sample-card").find('.card');
    var card = sampleCard.clone(false);

    card.find('a.ui.cover').attr('href', base_url(veiculo.tipo.url + '/' + veiculo.id_veiculo));
    //<a class="ui cover" href="<?= base_url($veiculo['tipo']['url'].'/'.$veiculo['id_veiculo']); ?>">

    $.each(veiculo['imagens'], function(i, imagem){
        var url = base_url('assets/img/veiculos/' + imagem['url_imagem']);
        card.find('[field=imagem'+ (i+1) +']').attr('src', base_url('assets/img/veiculos/image_frame.png'));

        $.get(url).done(function(){
            card.find('[field=imagem'+ (i+1) +']').attr('src', url);
        });
    });

    card.find('[field=observacoes]').text(veiculo.observacoes);
    card.find('[field=venda_valor]').text(veiculo.venda_valor);
    card.find('[field=ano]').text(veiculo.ano);
    card.find('[field=cor]').text(veiculo.cor);

    card.find('[field=estado]').text(veiculo.estado);
    var ribbon = card.find('[field=estado]').parent();
    if(ribbon.hasClass(veiculo.estado)) ribbon.show().removeAttr('hidden');

    card.find('[field=modelo]').text(veiculo.modelo.nome);
    card.find('[field=modelo]').parent().attr('href', base_url(veiculo.tipo.url + '/' + veiculo.id_veiculo))

    card.find('[field=marca]').text(veiculo.marca.nome);
    card.find('[field=marca]').parent().attr('href', base_url(veiculo.tipo.url + '/marca/' + veiculo.id_marca))


    return card;
}