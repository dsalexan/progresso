$(document).ready(function(){
    $('.tabs .item[disabled]').each(function(){
        disable_tab($(this).data('tab'));
    });
});

function change_tab(data_tab){
    $('.ui.tab.active').removeClass('active');
    $('.ui.tab[data-tab=' + data_tab).addClass('active');

    $('.ui.menu .item.active').removeClass('active');
    $('.ui.menu .item[data-tab=' + data_tab+']').addClass('active');

    enable_tab(data_tab);
}

function disable_tab(data_tab){
    $('.menu .item[data-tab='+ data_tab + ']').off('click').addClass('disabled');
}

function enable_tab(data_tab){
    $('.menu .item[data-tab='+ data_tab + ']').removeClass('disabled').tab();
}

function add_tab(tab, alt){
    $menu = $('.tabs > .menu');
    $tabs = $('.tabs');

    $menu.append('<a class="item" data-tab="' +tab+ '">' +alt+ '</a>');
}