<?php
    session_start();
    require_once 'dao.php';
    $senhaAtual = $_POST['senha'];
    $senhaNova = $_POST['novaSenha'];
    if(dados_corretos_usuario($_SESSION['username'], $senhaAtual))
    {
        if(atualizar_usuario($_SESSION['username'], $senhaNova))
        {
            $_SESSION['mensagem'] = ["Dados alterados com sucesso!", "alert-success"];
        }
        else
        {
            $_SESSION['mensagem'] = ["Algum erro ocorreu!", "alert-danger"];
        }
    }
    else
    {
        $_SESSION['mensagem'] = ["Senha incorreta!", "alert-danger"];
    }
    header("Location: ../perfil.php");
    exit;
?>