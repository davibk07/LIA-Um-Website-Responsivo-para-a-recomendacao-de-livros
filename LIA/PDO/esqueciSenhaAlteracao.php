<?php
    session_start();
    require_once 'dao.php';
    $idRequisicao = $_POST["idRequisicao"];
    if(!empty($idRequisicao))
    {
        $idUsuario = select_requisicao($idRequisicao)[0]['idUsuario'];
        if(atualizar_usuario_id($idUsuario, $_POST["senha"]) == 1)
        {
            encerrar_requisicao($idRequisicao);
            $_SESSION['mensagem'] = ["Senha alterada!", "img/concluido.png"];
        }
        else
        {
            $_SESSION['mensagem'] = ["Algo ocorreu de forma errada!", "img/erro.png"];
        }
    }
    header("Location: ../recuperacaoSenha.php?token=".$_POST['token']);
    exit;
?>