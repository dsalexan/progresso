$(document).ready(function(){
    $(".buttona").click(function(){
        //alert('caraaa');

        //http://localhost:90/progresso/veiculos/search?q=moto+novo
        $.ajax({
            'url': "http://localhost:90/progresso/veiculos/search?q=carro+usado",
            cache: false,
            success: function(data){
                alert(data);
            }
        });
    });

});