<?php
    session_start();
    require_once 'dao.php';
    require_once 'iniciarSessao.php';
    if(!existe_usuario($_POST["email"], $_POST["username"])) //nenhum outro usuário usa o mesmo email ou username
    {
        criar_usuario($_POST["username"], $_POST["email"], $_POST["senha"]);
        criar_sessao($_POST["username"]);
        header("Location: ../home.php");
        exit;
    }
    else //existem contas que usam o mesmo email ou usuário
    {
        //retornar o feedback para o usuário
        $_SESSION['mensagem'] = ["Os dados já foram usados (Usuário ou email)!", "alert-danger"];
        header("Location: ../cadastro.php");
        exit;
    }
?>