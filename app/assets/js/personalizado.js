/*Carregar os dados do bairro*/
$("#cidade_id").on("change", function(){
    var cidade_id = $("#cidade_id").val();
    //alert(cidade_id);
    $.ajax({
        url: '../process/search/search_bairros.php',
        type: 'POST',
        data:{id:cidade_id},
        success: function(data){
            $("#bairro_id").html(data);
        },
        error: function(data){
            $("#bairro_id").html("Erro ao carregar");
        }
    });
});

jQuery(function ($) {
    $("#cpf").mask("999.999.999-99");
    $("#cel").mask("(99) 99999-9999");
    $("#fone").mask("(99) 9999-9999");
});