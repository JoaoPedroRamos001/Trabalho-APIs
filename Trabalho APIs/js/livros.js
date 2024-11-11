//uso de js para imprimir alerta de erro ao ensirir dados vazio (livros.js)

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const livroInput = document.getElementById('livroInput');
    const errorMessage = document.getElementById('error-message');

    if (form && livroInput && errorMessage) { //verifica se os elementos existem
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (livroInput.value.trim() === '') {
                showErrorMessage('Por favor, digite o titulo de um livro.');
            } else {
                this.submit();
            }
        });
    }

    function showErrorMessage(message) {
        errorMessage.textContent = message;
        errorMessage.classList.add('show');
        errorMessage.style.display = 'block';

        setTimeout(() => {
            errorMessage.classList.remove('show');

            errorMessage.style.display = 'none';
        }, 3000);
    }
});

//função para imprimir imagem de capas de livros em tela cheia
function openFullscreen(img) {
    //cria o elemento de imagem em tela cheia
    const fullScreenImg = document.createElement('img');
    fullScreenImg.src = img.src; //ppega a fonte da imagem clicada
    fullScreenImg.classList.add('fullscreen-img'); //diciona a classe CSS

    //evento de clique para fechar a tela cheia
    fullScreenImg.onclick = function() {
        document.body.removeChild(fullScreenImg);
    };

    //adiciona a imagem ao corpo do documento
    document.body.appendChild(fullScreenImg);
}