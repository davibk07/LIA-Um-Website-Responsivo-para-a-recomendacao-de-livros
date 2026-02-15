<?php
    session_start();
    require_once 'dao.php';
    //PEGAR O ID DO USUÁRIO
    $respostas = array_values($_POST);
    //VERIFICAR SE O QUESTIONÁRIO DO USUÁRIO JÁ FOI CRIADO
    if(existe_questionario($_SESSION['idUsuario']))
    {
        //fazer o alter table
        atualizar_questionario($_SESSION['idUsuario'], $respostas);
    }
    else //questionário não existe
    {
        //criar um questionário
        criar_questionario($_SESSION['idUsuario'], $respostas);
    }
    header("Location: ../home.php");
    exit;
?>