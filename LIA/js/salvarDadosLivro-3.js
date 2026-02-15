window.addEventListener('beforeunload', () => 
{
    const estrelaAtiva = document.getElementById('estrela').getAttribute("fill") === "#ffc107" ? 1 : 0;
    const likeAtivo = document.getElementById('btnLike').classList.contains('btn-secondary') ? 1 : 0;
    const dislikeAtivo = document.getElementById('btnDislike').classList.contains('btn-secondary') ? 1 : 0;
    const dados = new FormData();
    dados.append('estrela', estrelaAtiva);
    dados.append('like', likeAtivo);
    dados.append('dislike', dislikeAtivo);
    dados.append('idLivro', idLivro);
    dados.append('imagem', imagem);
    navigator.sendBeacon('PDO/salvarEstadoLivro.php', dados);
});