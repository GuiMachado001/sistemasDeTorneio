$(document).ready(function() {
    $("#questionario_form").on("submit", function(event) {
        event.preventDefault(); // Impede o recarregamento da página

        var formData = $(this).serialize(); // Pega os dados do formulário

        $.ajax({
            url: './processar_questionario.php',  
            type: 'POST',
            data: formData,  
            success: function(response) {
                console.log('Resposta do servidor:', response); // Log da resposta
                alert(response); // Exibe a resposta do servidor
                $("#questionario_form :input").prop("disabled", true); // Desabilita inputs após o envio
            },
            error: function(xhr, status, error) {
                console.log('Erro na requisição AJAX:', error); // Log de erro AJAX
                alert('Ocorreu um erro. Tente novamente.');
            }
        });
    });
});
