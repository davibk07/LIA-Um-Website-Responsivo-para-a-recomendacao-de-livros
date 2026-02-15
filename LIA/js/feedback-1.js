const blocoMensagem = document.getElementById("mensagem");
const mensagem_texto = document.getElementById("texto-mensagem");
function enviarFeedback(mensagem, tipo)
{

    blocoMensagem.classList.remove("d-none");
    blocoMensagem.classList.add("d-block");
    blocoMensagem.classList.add(tipo);
    mensagem_texto.innerText = mensagem;
    setTimeout(() => 
    {
        blocoMensagem.classList.remove("d-block");
        blocoMensagem.classList.add("d-none");
    }, 3500);
}
enviarFeedback(mensagem[0], mensagem[1]);