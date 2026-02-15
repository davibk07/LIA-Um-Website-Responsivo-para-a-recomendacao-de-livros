const botoes_paginacao = document.getElementsByClassName("paginacao-btn");
const botoes_controle = document.getElementById("btns-controle");
for (let botao of botoes_paginacao) 
{
    botao.addEventListener("click", trocarPagina);
}

function trocarPagina()
{
    for(let i = 1; i < 3; i++)
    {
        string_id_bloco = "pagina"+(i)+"-questoes";
        string_id_btn = "btn-paginacao-"+i;
        let bloco_questoes = document.getElementById(string_id_bloco);
        let botao_paginacao = document.getElementById(string_id_btn);
        if(i == this.id) //o botão que foi clicado tem o mesmo id do índice i
        {
            //mostra o bloco de questõse (1-4) ou (5-8)
            bloco_questoes.hidden = false;
            if(!botao_paginacao.classList.contains("bg-dark"))
            {
                botao_paginacao.classList.remove("text-dark");
                botao_paginacao.classList.add("bg-dark");
                botao_paginacao.classList.add("text-white");
            }
            if(i == 2) //se a página ativa for a 2, mostrar os botões de controle
            {
                botoes_controle.hidden = false;
            }
        }
        else //o botão que foi clicado tem id diferente do índice i
        {
            //esconde o bloco de questões (1-4) ou (5-8)
            bloco_questoes.hidden = true; 
            if(botao_paginacao.classList.contains("bg-dark"))
            {
                botao_paginacao.classList.remove("bg-dark");
                botao_paginacao.classList.remove("text-white");
                botao_paginacao.classList.add("text-dark");
            }
            if(i == 2) //se a página ativa for a 2, esconder os botões de controle
            {
                botoes_controle.hidden = true;
            }
        }
    }
}