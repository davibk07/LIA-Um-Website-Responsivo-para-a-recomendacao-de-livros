const btnAlterarSenha = document.getElementById("alterar-senha");
const formulario = document.getElementById("formulario");
formulario.style.display = "none";
btnAlterarSenha.addEventListener("click", formularioVisivel);

function formularioVisivel()
{
    btnAlterarSenha.style.display = "none";
    formulario.style.display = "block";
}