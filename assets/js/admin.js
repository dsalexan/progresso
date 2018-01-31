var minimal_date;
var min_date;
var max_date;
var chart_data;


get_chart_data();
get_traffic_data();

$(document).ready(function(){
    
    $("#logout").click(function(event){
        //return confirm("Tem certeza que deseja sair?");

        event.preventDefault();

        $("#logout-confirmation").modal('show');
    });

    $("#dashboard").dimmer('show');
    $("#traffic_table").dimmer('show');


    $('#rangestart').calendar({
        type: 'date',
        endCalendar: $('#rangeend'),
        minDate: new Date("01/22/2018"),
        maxDate: new Date()
    });

    $('#rangeend').calendar({
        type: 'date',
        startCalendar: $('#rangestart'),
        minDate: new Date("01/22/2018"),
        maxDate: new Date()
    });

    $('#rangesubmit').click(function(){
        var s = moment($('#rangestart').calendar('get date'));
        var e = moment($('#rangeend').calendar('get date'));
        
        chart_update(s, e);
    });
});


function chart_update(start_date, end_date){
    var t = moment();
    var re_query = false;

    if(start_date.isBefore(min_date, 'days')){
        s = start_date;
        re_query = true;
    }else{
        s = min_date;
    }

    if(end_date.isAfter(max_date, 'days')){
        e = end_date;
        re_query = true;
    }else{
        e = max_date;
    }

    if(re_query){
        var period = [
            t.diff(s, 'days'),
            t.diff(e, 'days')
        ];
        get_chart_data(s, e, period);
    }else{
        s = t.diff(start_date, 'days');
        e = t.diff(end_date, 'days');

        load_chart_data(s+1, e+1);
    }
}

function get_chart_data(start_date=null, end_date=null, period=null){
    
    $("#dashboard").dimmer('show');

    if(start_date == null) {
        start_date = moment().add(-30, 'days');
        if(start_date.isBefore(moment('20180122'))) start_date = moment('20180122');
    }
    if(end_date == null) end_date = moment();
    if(period == null) period = [moment().diff(start_date, 'days'), moment().diff(end_date, 'days')];
    period_string = [period[0] + "daysAgo", period[1] + "daysAgo"];


    $.ajax({
        url: base_url('admin/analytics/acesso_semanal'),
        type: 'POST',
        dataType : "json",
        data: {
            'period': [period_string[0], period_string[1]]
        },
        persist: [start_date, end_date],
        success: function(data) {

            var dimensions_formatted = [];

            data.acesso_semanal.dimensions.forEach(function(valor){
                var date = moment(valor);
                dimensions_formatted.push(date.locale('pt-br').format('L'));
            });

            data.acesso_semanal.dimensions_formatted = dimensions_formatted;

            chart_data = data;

            min_date = moment(data.acesso_semanal.dimensions[0]);
            max_date = moment(data.acesso_semanal.dimensions[dimensions_formatted.length-1]);
            
            $("#rangestart").calendar('set date', new Date(this.persist[0].format('L')));
            $("#rangeend").calendar('set date', new Date(this.persist[1].format('L')));

            
            chart_update(this.persist[0], this.persist[1]);
        }
    });
}

function load_chart_data(start_index, end_index){

    var week = [];
    var week_sessions = [];

    for(i=start_index; i >= end_index; i--){
        week.push(chart_data.acesso_semanal.dimensions_formatted[chart_data.acesso_semanal.dimensions_formatted.length-i]);
        week_sessions.push(chart_data.acesso_semanal.sessions[chart_data.acesso_semanal.sessions.length-i])
    }

    var ctx = $("#myChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: week,
            datasets: [{
            data: week_sessions,
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
            
    $("#dashboard").dimmer('hide');
}

function wordInString(s, word){
    return new RegExp( '\\b' + word + '\\b', 'i').test(s);
  }

function get_traffic_data(){
    $.ajax({
        url: base_url('admin/analytics/fontes_trafego'),
        type: 'GET',
        dataType : "json",
        success: function(data) {

            $("#traffic_table table tbody").empty();

            for($i=0; $i < data.fontes_trafego.dimensions.length; $i++){
                
                icon_type = 'folder';

                source = data.fontes_trafego.dimensions[$i];
                if(wordInString(source, 'bing')) icon_type = 'windows';
                else if(wordInString(source, 'yahoo')) icon_type = 'yahoo';
                else if(wordInString(source, 'google')) icon_type = 'google';
                else if(wordInString(source, 'facebook')) icon_type = 'facebook';
                


                session = data.fontes_trafego.sessions[$i];

                table_row = '<tr>' +
                    '<td>' +
                        '<i class="'+icon_type+' icon"></i> '+source +
                    '</td>' +
                    '<td>'+session+'</td>' +
                '</tr>';

                $("#traffic_table table tbody").append(table_row);
            }

            $('#traffic_table').dimmer('hide');

        }
    });
}