<?php
    session_start();
    require_once 'dao.php';
    $_SESSION['resultadoPesquisa'] = buscarLivroPorNome($_POST['nomeLivro']);
    header("Location: ../catalogo.php");
    exit;
?>