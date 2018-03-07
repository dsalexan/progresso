
(function ($) {
    var get_selector = function (element) {
        var pieces = [];

        for (; element && element.tagName !== undefined; element = element.parentNode) {
            if (element.className) {
                var classes = element.className.split(' ');
                for (var i in classes) {
                    if (classes.hasOwnProperty(i) && classes[i]) {
                        pieces.unshift(classes[i]);
                        pieces.unshift('.');
                    }
                }
            }
            if (element.id && !/\s/.test(element.id)) {
                pieces.unshift(element.id);
                pieces.unshift('#');
            }
            pieces.unshift(element.tagName);
            pieces.unshift(' > ');
        }

        return pieces.slice(1).join('');
    };

    $.fn.getSelector = function (only_one) {
        if (true === only_one) {
            return get_selector(this[0]);
        } else {
            return $.map(this, function (el) {
                return get_selector(el);
            });
        }
    };

    $.fn.inlineStyle = function (prop) {
        return this.prop("style")[$.camelCase(prop)];
    };

    $.fn.refresh = function() {
        var elems = $(this.getSelector());
        this.splice(0, this.length);
        this.push.apply( this, elems );
        return this;
    };

    $.fn.fetch = function(url, func=false){
        this.append($('<loader>').load(url, function(){
            $(this).children().appendTo($(this).parent());
            $(this).remove();
            if(func !== false) func();
        }));
        return this;
    }

    
}(jQuery));

function bindCloseMessage(){
    $('.ui.message > i.icon.close').click(function(){
        $(this).parent().remove();
    });
}


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
    $('.collapse-button').click(function(){
        var state = $(this).data('state');

        if(state == 'hide'){
            $('[data-hiddable=true]').hide();
            $(this).data('state', 'show');
        }else if(state == 'show'){
            $('[data-hiddable=true]').show();
            $(this).data('state', 'hide');
        }
    });

    $('.menu .item').tab();
    $('.has-popup').popup();
    $('.ui.dropdown').dropdown();

    $("#logout").click(function(event){
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

  