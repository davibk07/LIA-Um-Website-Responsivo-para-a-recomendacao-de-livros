const btnLike = document.getElementById("btnLike");
const btnDislike = document.getElementById("btnDislike");
btnLike.addEventListener("click", alterarEstadoBtns);
btnDislike.addEventListener("click", alterarEstadoBtns);

function alterarEstadoBtns()
{
    //verificar qual botão está sendo manipulado agora
    if(this == btnLike) //o botao de like foi o clicado
    {
        //o botao de like já está ativo
        if(this.classList.contains("btn-secondary"))
        {
            desativarBtn(this);
        }
        //o botao de dislike estava ativo
        else if(btnDislike.classList.contains("btn-secondary"))
        {
            ativarBtn(this);
            desativarBtn(btnDislike);
        }
        //o botao de dislike está desativado e o de like também
        else
        {
            ativarBtn(this);
        }
    }
    else //o botao de dislike foi o clicado
    {
        //o botao de dislike já está ativo
        if(this.classList.contains("btn-secondary"))
        {
            desativarBtn(this);
        }
        //o botao de like estava ativo
        else if(btnLike.classList.contains("btn-secondary"))
        {
            ativarBtn(this);
            desativarBtn(btnLike);
        }
        //o botao de dislike está desativado e o de like também
        else
        {
            ativarBtn(this);
        }
    }
}
function ativarBtn(btn)
{
    btn.classList.remove("btn-light");
    btn.classList.add("btn-secondary");
}
function desativarBtn(btn)
{
    btn.classList.remove("btn-secondary");
    btn.classList.add("btn-light");
}