const estrela = document.getElementById("estrela");
const mensagem_favorito = document.getElementById("mensagem_favorito");
const texto_mensagem_favorito = document.getElementById("texto_mensagem_favorito");
let ativado = 0;
let mensagem = "";
estrela.addEventListener("click", favoritar);
function favoritar()
{
    if(!esta_favoritado())
    {
        estrela.setAttribute("fill", "#ffc107");
        mensagem = "Livro salvo!";
    }
    else
    {
        estrela.setAttribute("fill", "white");
        mensagem = "Livro retirado da lista de salvos!";
    }
    texto_mensagem_favorito.innerText = mensagem;
    mensagem_favorito.classList.remove("d-none");
    mensagem_favorito.classList.add("d-block");
    setTimeout(() => 
    {
        mensagem_favorito.classList.remove("d-block");
        mensagem_favorito.classList.add("d-none");
    }, 3000);
}
function esta_favoritado()
{
    return estrela.getAttribute('fill') === "#ffc107" ? ativado = 1 : ativado = 0;
}