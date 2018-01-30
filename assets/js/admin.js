
$(document).ready(function(){
    let Dimmer = require('semantic-ui-dimmer');
    $.fn.dimmer = Dimmer;
    
    $("#logout").click(function(event){
        return confirm("Tem certeza que deseja sair?");
    });


    $("#dashboard").dimmer('show');
});


$.ajax({
    url: base_url('admin/analytics'),
    type: 'POST',
    data: {
        'tables': ['acesso_semanal']
    },
    cache: false,
    type: 'json',
    success: function(text_data) {

        return;
        var data = JSON.parse(text_data);
        var dimensions_formatted = [];

        data.acesso_semanal.dimensions.forEach(function(valor){
            var date = moment(valor);
            dimensions_formatted.push(date.locale('pt-br').format('L'));
        });

        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dimensions_formatted,
                datasets: [{
                data: data.acesso_semanal.sessions,
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                scales: {
                yAxes: [{
                    ticks: {
                    beginAtZero: false
                    }
                }]
                },
                legend: {
                display: false,
                }
            }
        });
    }
});
