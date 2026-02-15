<?php
    function criar_sessao($username)
    {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['logado'] = true;
        $_SESSION['idUsuario'] = select_usuario($username)['idUsuario'];
    }
?>