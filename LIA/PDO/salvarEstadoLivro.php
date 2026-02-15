<?php
    session_start();
    require_once 'dao.php';
    $idLivro = $_POST['idLivro'];
    //file_put_contents('meu_arquivo.txt', print($_POST['imagem']));
    //se os dados de salvo, gostou, nao_gostou forem iguais a zero, melhor não manter o registro. A não ser que o livro tenha sido recomendado
    if($_POST['like'] == 0 && $_POST['dislike'] == 0 && $_POST['estrela'] == 0 && select_livro($idLivro, $_SESSION['idUsuario'])["recomendado"] == 0)
    {
        if(livro_ja_existe_bd($idLivro, $_SESSION['idUsuario']))
        {
            excluir_livro($idLivro, $_SESSION['idUsuario']);
        }
    }
    else
    {
        //se o livro já existe no bd, atualizar os dados no banco
        if(livro_ja_existe_bd($idLivro, $_SESSION['idUsuario']))
        {
            atualizar_livro($_SESSION['idUsuario'], $idLivro, $_POST['like'], $_POST['dislike'], $_POST['estrela']);
        }
        //do contra, criar um registro.
        else
        {
            criar_livro($_SESSION['idUsuario'], $idLivro, $_POST['like'], $_POST['dislike'], $_POST['estrela'], 0, $_POST['imagem']);
        }
    }
?>