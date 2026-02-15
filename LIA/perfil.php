<?php
    require_once 'PDO/controleSessao.php';
    require_once 'PDO/dao.php';
    $idUsuario = select_usuario($_SESSION['username'])['idUsuario'];
    $livros = select_livros($idUsuario);
    $livrosSalvos = array();
    $livrosRecomendados = array();
    if(!empty($livros))
    {
        if (!empty($_SESSION['mensagem'])) 
        {
            $mensagem = $_SESSION['mensagem'];
            unset($_SESSION['mensagem']);
        }
        foreach($livros as $livro)
        {
            if($livro['salvo'] == '1')
            {
                array_push($livrosSalvos, $livro);
            }
            if($livro['recomendado'] == '1')
            {
                array_push($livrosRecomendados, $livro);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/teste13.css" rel="stylesheet">
    <title>Perfil</title>
</head>
<body>
    <div>
        <header class="d-flex align-items-center px-5 w-100 justify-content-between">
            <div class="icones-menu align-content-center">
                <a href="home.php"><img src="img/book-open.png"></a>
                <img src="img/menu-button.png" id="menu_aberto_botao" hidden>
                <img src="img/menu-fechado.png" id="menu_fechado_botao">
            </div>
            <div class="links-navegacao d-flex justify-content-between col-8 col-md-5 col-lg-6 pt-3" id="menu_aberto">
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="catalogo.php" class="elemento-navegacao"><img src="img/book.png"></a>
                    <p class="elemento-navegacao">Catálogo</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="home.php" class="elemento-navegacao"><img src="img/home.png"></a>
                    <p class="elemento-navegacao">Home</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="perfil.php" class="elemento-navegacao"><img src="img/perfil.png"></a>
                    <p class="elemento-navegacao">Perfil</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="sobre.php" class="elemento-navegacao"><img src="img/info.png"></a>
                    <p class="elemento-navegacao">Sobre</p>
                </div>
            </div>
            <div style="width:40px;">
                <div class="d-flex flex-column mb-2 mt-3 align-items-center justify-content-center">
                    <a href="PDO/finalizarSessao.php" class="elemento-navegacao"><img src="img/logout.png"></a>
                    <p class="elemento-navegacao">Sair</p>
                </div>
            </div>
        </header>
    </div>
    <div class="d-flex flex-column bg-cinza-claro py-5 align-items-center">
        <div class="d-flex flex-column px-5 py-3 container bg-cinza-medio align-items-center col-12 col-md-6 col-lg-4">
            <h2 class="text-center"><?= $_SESSION['username']?></h2>
            <img src="img/perfil-login.png" class="border border-dark rounded-circle img-fluid imagem-perfil">
            <a class="btn btn-dark mt-1" id="alterar-senha">Alterar senha<a>
            <form method="post" action="PDO/alterarSenha.php" class="mt-1 p-3" id="formulario">
                <div class="d-flex py-3 gap-2">
                    <img src="img/senha-login.png">
                    <input type="password" class="form-control" id="senha" placeholder="Senha atual" name="senha" required>
                </div>
                <div class="d-flex py-3 gap-2">
                    <img src="img/senha-login.png">
                    <input type="password" class="form-control" id="novaSenha" placeholder="Nova Senha" name="novaSenha" required>
                </div>
                <div class="d-flex justify-content-center">
                    <input type="submit" value="Alterar Senha" class="btn btn-dark">
                </div>
            </form>
        </div>
        <div id="mensagem" class="d-none alert alert-dismissible fade show mx-auto text-center w-auto mt-3">
            <p id="texto-mensagem" class="m-0 p-2 rounded"></p>
        </div>
        <div class="d-flex flex-column container-fluid py-4 align-items-center"> 
            <label class="fw-bold fs-5 pb-2">Livros Salvos</label>
            <?php 
                $quantidadeLivrosSalvos = count($livrosSalvos);
                $grupos = array_chunk($livrosSalvos, 5); #agrupa os livros em 5
                echo '<div class="bg-cinza-medio px-5 py-4 col-12 col-md-12 col-lg-10">';
                if(empty($livrosSalvos))
                {
                    echo '<p class="text-center">Nenhum livro salvo por enquanto!</p>';
                }
                else
                {
                    echo '<div class="carousel slide" id="carousel-salvos">'; #carousel slide
                    echo "<div class='carousel-indicators'>";
                    for ($i = 0; $i < sizeof($grupos); $i++) 
                    {
                        $class = $i === 0 ? "active" : "";
                        echo "<button type='button' data-bs-target='#carousel-salvos' data-bs-slide-to='{$i}' class='{$class}' aria-current='".($i === 0 ? "true" : "false")."' aria-label='Slide ".($i+1)."'></button>";
                    }
                    echo "</div>";
                    echo '<div class="carousel-inner">'; #carousel inner
                    #cria um carousel-item para cada grupo de 7
                    foreach ($grupos as $indice => $grupo_livro)
                    {
                        $indice === 0 ? $ativo = 'active' : $ativo = '';
                        echo '<div class="carousel-item '.$ativo.'">'; #cria o carousel-item, o primeiro é ativo
                        echo '<div class="d-flex justify-content-center align-items-center flex-wrap p-5">';
                        foreach($grupo_livro as $livro)
                        {
                            $idLivro = $livro['idLivro'];
                            $imagemLivro = $livro['imagem'] ?: 'img/capa-generica.jpeg';
                            echo "<a href='livro.php?id=$idLivro'><img src='{$imagemLivro}' class='livro-capa mx-2 my-1 img-fluid' alt='Capa do livro'></a>"; #conteúdo da div de carousel-item
                        }
                        echo '</div>'; #fecha o flex
                        echo '</div>'; #fecha o carousel-item
                    }
                    echo '</div>'; #fecha carousel-inner
                    #controles
                    echo '<button class="carousel-control-prev btn-carousel" type="button" data-bs-target="#carousel-salvos" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>';
                    echo '<button class="carousel-control-next btn-carousel" type="button" data-bs-target="#carousel-salvos" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>';
                    echo '</div>'; #fecha carousel-slide
                }
                echo '</div>';
            ?>
        </div>
        <div class="d-flex flex-column container-fluid py-4 align-items-center"> 
            <label class="fw-bold fs-5 pb-2">Livros Recomendados</label>
            <?php 
                $quantidadeLivrosRecomendados = count($livrosRecomendados);
                $grupos = array_chunk($livrosRecomendados, 5); #agrupa os livros em 5
                echo '<div class="bg-cinza-medio px-5 py-4 col-12 col-md-12 col-lg-10">';
                if(empty($livrosRecomendados))
                {
                    echo '<p class="text-center">Nenhum livro recomendado por enquanto!</p>';
                }
                else
                {
                    echo '<div class="carousel slide" id="carousel" autoplay="false">'; #carousel slide
                    echo "<div class='carousel-indicators'>";
                    for ($i = 0; $i < sizeof($grupos); $i++) 
                    {
                        $class = $i === 0 ? "active" : "";
                        echo "<button type='button' data-bs-target='#carousel' data-bs-slide-to='{$i}' class='{$class}' aria-current='".($i === 0 ? "true" : "false")."' aria-label='Slide ".($i+1)."'></button>";
                    }
                    echo "</div>";
                    echo '<div class="carousel-inner">'; #carousel inner
                    #cria um carousel-item para cada grupo de 7
                    foreach ($grupos as $indice => $grupo_livro)
                    {
                        $indice === 0 ? $ativo = 'active' : $ativo = '';
                        echo '<div class="carousel-item '.$ativo.'">'; #cria o carousel-item, o primeiro é ativo
                        echo '<div class="d-flex justify-content-center align-items-center flex-wrap p-5">';
                        foreach($grupo_livro as $livro)
                        {
                            $idLivro = $livro['idLivro'];
                            $imagemLivro = $livro['imagem'] ?: 'img/capa-generica.jpeg';
                            echo "<a href='livro.php?id=$idLivro'><img src='{$imagemLivro}' class='livro-capa mx-2 my-1 img-fluid' alt='Capa do livro'></a>"; #conteúdo da div de carousel-item
                        }
                        echo '</div>'; #fecha o flex
                        echo '</div>'; #fecha o carousel-item
                    }
                    echo '</div>'; #fecha carousel-inner
                    #controles
                    echo '<button class="carousel-control-prev btn-carousel" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>';
                    echo '<button class="carousel-control-next btn-carousel" type="button" data-bs-target="#carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>';
                    echo '</div>'; #fecha carousel-slide
                }
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="d-flex flex-column bg-cinza-medio footer-padding">
        <footer>
            <p>Miguel Freitas da Rosa</p>
            <div class="d-flex gap-3">
                <a href=""><img src="img/Instagram.png"></a>
                <a href=""><img src="img/LinkedIn.png"></a>
                <a href=""><img src="img/Github.png"></a>
            </div>
            <p>Davi Bazzanella Kuhn</p>
            <div class="d-flex gap-3">
                <a href=""><img src="img/Instagram.png"></a>
                <a href=""><img src="img/LinkedIn.png"></a>
                <a href=""><img src="img/Github.png"></a>
            </div>
            <p class="text-center">*Projeto de TCC criado por Miguel Freitas da Rosa e Davi Bazzanella Kuhn</p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/menu_script-3.js"></script>
    <script type="text/javascript" src="js/alterarSenha.js"></script>
    <script>
        const mensagem = <?php echo json_encode($mensagem ?? null); ?>;
    </script>
    <script src="js/feedback-1.js"></script>
</body>
</html>