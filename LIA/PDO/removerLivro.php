<?php
    session_start();
    require_once 'dao.php';
    print(desrecomendar_livro($_SESSION['idUsuario'], $_GET['id']));
    header("Location: ../home.php");
    exit;
?>