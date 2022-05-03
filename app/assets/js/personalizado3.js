/*Carregar os dados do bairro*/
$("#cidade_id").on("change", function(){
    var cidade_id = $("#cidade_id").val();

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

/*Carregar os dados dos colaboradores para seleção das avaliações*/
$("#avaliacao_id").on("change", function(){
    var avaliacao_id = $("#avaliacao_id").val();

    $.ajax({
        url: '../process/search/search_avaliacao.php',
        type: 'POST',
        data:{id:avaliacao_id},
        success: function(data){
            $("#colaborador_id").html(data);
        },
        error: function(data){
            $("#colaborador_id").html("Erro ao carregar");
        }
    });
});

/*Carregar os dados das competências para iniciar a avaliação*/
$("#avaliacao_id").on("change", function(){
    var avaliacao_id = $("#avaliacao_id").val();

    $.ajax({
        url:'../process/search/search_competencia.php',
        type:'POST',
        data:{id:avaliacao_id},
        success: function(data){
            $("#competencia_id").html(data);
        },
        error: function(data){
            $("#competencia_id").html("Erro ao carregar");
        }
    });
});
jQuery(function ($) {
    $("#cpf").mask("999.999.999-99");
    $("#cel").mask("(99) 99999-9999");
    $("#fone").mask("(99) 9999-9999");
});