

    // Usar delegação de eventos para elementos carregados dinamicamente
    $(document).on('click', '.like-btn', function(){
        var button = $(this);
        var recadoId = button.data("id");
        
        // Feedback visual imediato
        button.prop('disabled', true).text('Curtindo...');

        $.post("", { like_id: recadoId }, function(data){
            if(!isNaN(data)){
                button.closest("li").find(".like-count").text(data + " curtidas");
            } else {
                alert("Erro: " + data);
            }
            button.prop('disabled', false).text('Curtir');
        }).fail(function() {
            alert("Erro na requisição");
            button.prop('disabled', false).text('Curtir');
        });
    });
