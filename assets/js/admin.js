(function ($) {
    $.fn.inlineStyle = function (prop) {
        return this.prop("style")[$.camelCase(prop)];
    };
}(jQuery));

function removeAcento (text){       
    text = text.toLowerCase();                                                         
    text = text.replace(new RegExp('[ÁÀÂÃ]','gi'), 'a');
    text = text.replace(new RegExp('[ÉÈÊ]','gi'), 'e');
    text = text.replace(new RegExp('[ÍÌÎ]','gi'), 'i');
    text = text.replace(new RegExp('[ÓÒÔÕ]','gi'), 'o');
    text = text.replace(new RegExp('[ÚÙÛ]','gi'), 'u');
    text = text.replace(new RegExp('[Ç]','gi'), 'c');
    text = text.replace(new RegExp('[^a-z0-9]','gi'), '_');
    text = text.replace(new RegExp('_+','gi'), '_');
    return text;                 
}


$(document).ready(function(){
    $('.menu .item').tab();
    $('.has-popup').popup();
    $('.ui.dropdown').dropdown();

    $("#logout").click(function(event){
        //return confirm("Tem certeza que deseja sair?");

        event.preventDefault();

        $("#logout-confirmation").modal('show');
    });

    $("#searcher").search({
        type: 'category',
        minCharacters: 3,
        apiSettings: {
            onResponse: function(serverResponse) {
                var
                    response = {
                        results: {}
                    }
                ;
                //translate Server API response to work with search
                $.each(serverResponse.results, function(index, result) {
                    
                    // create new language category
                    if(response.results[result._source.nome_tipo] === undefined) {
                        response.results[result._source.nome_tipo] = {
                        name    : result._source.nome_tipo,
                        results : []
                        };
                    }
                    
                    //add result to category
                    response.results[result._source.nome_tipo].results.push({
                        title: result._source.nome_marca,
                        description: result._source.nome_modelo,
                        url: base_url('admin/veiculos?a=update&id_veiculo=' + result._id)
                    });
                });
                return response;
            },
            url: base_url('veiculos/search.json?type=c&q={query}', 'HTTPLESS')
        }
    });
});



function wordInString(s, word){
    return new RegExp( '\\b' + word + '\\b', 'i').test(s);
  }

  