$(document).ready(function() {
    $("#questionario_form").on("submit", function(event) {
        event.preventDefault(); // Impede o recarregamento da página

        var formData = $(this).serialize(); // Pega os dados do formulário

        $.ajax({
            url: './processar_questionario.php',  
            type: 'POST',
            data: formData,  
            success: function(response) {
                console.log(response); // Exibe a resposta do servidor no console
                $("#questionario_form :input").prop("disabled", true); // Desabilita inputs após o envio
                
                // Redireciona para a página de premiação
                window.location.href = './premiacao/premio1.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Erro na requisição: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });
});
