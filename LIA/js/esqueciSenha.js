const btn = document.getElementById("btn-esqueci");
const formularioRecuperacao = document.getElementById("formulario-recuperacao");
btn.addEventListener("click", expandir)
function expandir()
{
    formularioRecuperacao.classList.remove("d-none");
    formularioRecuperacao.classList.add("d-block");
}