<?php
    session_start();
    require_once 'dao.php';
    require_once 'iniciarSessao.php';
    if(dados_corretos_usuario($_POST["username"], $_POST["senha"])) //usuário informou os dados corretos
    {
        criar_sessao($_POST["username"]);
        header("Location: ../home.php");
        exit;
    }
    else //usuário informou os dados errados
    {
        $_SESSION['mensagem'] = ["Dados incorretos!", "alert-danger"];
        header("Location: ../login.php");
        exit;
        //retornar o feedback para o usuário
    }
?>