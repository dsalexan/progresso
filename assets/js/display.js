function expand_display(display){
    //verificar se ja n tem algum expanddido
    if($('.ui.card.expanded').length){
        colapse_display($('.ui.card.expanded + .content > .ui.display'));
    }

    card = $(display).closest('.card');
    cards = $(display).closest('.card').closest('.cards');

    middle_cards = $('<div></div>').attr('class', cards.attr('class')).addClass('mid-display');
    end_cards = $('<div></div>').attr('class', cards.attr('class')).addClass('bot-display'); 
    cards.addClass('top-display');

    cards.after(middle_cards);// create the second cards
    middle_cards.after(end_cards);// create the second cards
    
    /*separar os cards em 3 listas (topo, display, fim)*/
    var i = cards.children().index(card);
    
    if(i == 0){
        cards.children().not(card).appendTo(middle_cards);
    }else if(i == cards.children().length-1){
        card.appendTo(middle_cards)
    }else{
        cards.children().slice(i+1).appendTo(end_cards);
        card.appendTo(middle_cards);
    }

    card.addClass('expanded');
    card.data('card', i);
    $(display).find('p:first-child > i').removeClass('right').addClass('left');
    
    var content = $(display).find('.content');
    content.appendTo(card.parent());

    $(display).appendTo(content);

    
    $('html,body').animate({
        scrollTop: card.offset().top - $(window).height()/3},
        'fast');

    
    $(display).addClass('expanded');
}

function colapse_display(display){
    cards = $(display).closest('.cards');
    card = cards.find('.ui.card.expanded');

    middle_cards = cards.parent().find('.mid-display');
    end_cards = cards.parent().find('.bot-display');
    cards = cards.parent().find('.top-display');

    var content = $(display).parent();
    $(display).prependTo(card);
    content.appendTo($(display));

    end_cards.find('.ui.card').appendTo(middle_cards);
    middle_cards.find('.ui.card').appendTo(cards);

    end_cards.remove();
    middle_cards.remove();
    cards.removeClass('top-display');

    card.removeClass('expanded');
    card.data('card', -1);
    $(display).find('p:first-child > i').removeClass('left').addClass('right');

    
    $('html,body').animate({
        scrollTop: card.offset().top - $(window).height()/3},
        'fast');

    $(display).removeClass('expanded');
}

$(document).ready(function(){
    $('.ui.display').click(function(){

        if(!$(this).hasClass('expanded')){   
            expand_display(this);
        }else{
            colapse_display(this);
        }
    
    });
});