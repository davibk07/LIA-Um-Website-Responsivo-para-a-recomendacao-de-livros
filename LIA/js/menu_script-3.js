const menu_aberto_botao = document.getElementById("menu_aberto_botao");
const menu_fechado_botao = document.getElementById("menu_fechado_botao");
const botoes_navegacao = document.getElementsByClassName("elemento-navegacao");
menu_aberto_botao.addEventListener("click", alterar_menu);
menu_fechado_botao.addEventListener("click", alterar_menu);
function alterar_menu() 
{
    if (menu_aberto_botao.hidden) 
    {
        // Menu aberto → fechar
        menu_aberto_botao.hidden = false;
        menu_fechado_botao.hidden = true;
        for (let botao of botoes_navegacao) 
        {
            botao.style.visibility = "hidden";
        }
    } 
    else 
    {
        // Menu fechado → abrir
        menu_aberto_botao.hidden = true;
        menu_fechado_botao.hidden = false;
        for (let botao of botoes_navegacao) 
        {
            botao.style.visibility = "visible";
        }
    }
}