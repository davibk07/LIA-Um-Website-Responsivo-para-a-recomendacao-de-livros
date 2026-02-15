<?php
    require_once 'PDO/controleSessao.php';
    require_once 'PDO/dao.php';
    $livros = select_livros($_SESSION['idUsuario']);
    $livrosIds = array();
    $livrosLikeIds = array();
    $livrosRecomendados = array();
    $livrosRecomendadosIds = array();
    foreach($livros as $livro)
    {
        array_push($livrosIds, $livro['idLivro']);
        if($livro['gostou'])
        {
            array_push($livrosLikeIds, $livro['idLivro']);
        }
        if($livro['recomendado'])
        {
            array_push($livrosRecomendados, $livro);
            array_push($livrosRecomendadosIds, $livro['idLivro']);
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/teste13.css" rel="stylesheet">
    <title>LIA</title>
</head>
<body>
    <div>
        <header class="d-flex align-items-center px-5 w-100 justify-content-between">
            <div class="icones-menu align-content-center">
                <a href="home.php"><img src="img/book-open.png"></a>
                <img src="img/menu-button.png" id="menu_aberto_botao" hidden>
                <img src="img/menu-fechado.png" id="menu_fechado_botao">
            </div>
            <div class="links-navegacao d-flex justify-content-between col-8 col-md-5 col-lg-6 pt-3 pt-3" id="menu_aberto">
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
    <div class="d-flex flex-column bg-cinza-claro container-custom">
        <h1 class="title text-center">LIA</h1>
        <h2 class="text-center text-muted pb-5">Recomendação de Livros</h2>
        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex flex-column bg-cinza-medio container pb-2 pt-2">
                <form method="post" class="d-flex flex-column p-5">
                    <p class="text-center text-decoration-underline">Requisito para a recomendação: ao menos 1 feedback positivo (like)</p>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
                        {
                            if(sizeof($livrosLikeIds) >= 1)
                            {
                                $python = 'C:\Users\Miguel\AppData\Local\Programs\Python\Python313\python.exe';
                                $script = 'C:\xampp\htdocs\tcc\python\recomendacaoID.py';
                                $jsonLivrosLike = json_encode($livrosLikeIds, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                                $numLivros = $_POST['slider'];
                                $comando = "\"$python\" \"$script\" " 
                                . '"' . str_replace('"', '\"', $jsonLivrosLike) . '" '
                                . escapeshellarg($numLivros);
                                $saida = shell_exec($comando);
                                $recomendacoes = json_decode($saida, true);
                                if (!$recomendacoes) 
                                {
                                    echo "Nenhum resultado encontrado.";
                                    exit;
                                }
                                foreach ($recomendacoes as $livro) 
                                {
                                    //se o livro já estiver no banco e não tiver sido recomendado, atualizar para recomendá-lo
                                    if(!in_array($livro['id'], $livrosIds))
                                    {
                                        criar_livro($_SESSION['idUsuario'], $livro['id'], 0, 0, 0, 1, $livro['image']);
                                    }
                                    recomendar_livro($_SESSION['idUsuario'], $livro['id']);
                                }
                            }
                        }           
                    ?>
                    <div class="d-flex flex-row p-2 gap-1 justify-content-center">
                        <label for="sliderLabel">Número de livros recomendados:</label>
                        <span id="valorSlider">1</span>
                    </div>
                    <input type="range" id="slider" name="slider" min="1" max="10" step="1" value="1" class="form-range">
                    <button type="submit" class="btn btn-secondary text-center">Recomendar</button>
                </form>
            </div>  
            <div class="d-flex bg-cinza-medio mt-5 container pb-2 pt-2 justify-content-center col-12 col-md-12 col-lg-9">
                <?php
                    $ultimaRecomendacao = select_ultima_recomendacao($_SESSION['idUsuario']);
                    echo "<div class='d-flex flex-row flex-wrap justify-content-center w-100'>";
                    if(empty($ultimaRecomendacao))
                    {
                        echo "<p class='text-center fw-bold text-secondary'>Nenhum livro foi recomendado ainda!</p>";
                    }
                    else
                    {
                        foreach ($ultimaRecomendacao as $livro)
                        {
                            echo '<div class="card d-flex flex-column mt-1 col-12 col-md-6 col-lg-3">';
                            if(!empty($livro['imagem'])) 
                            {
                                echo "<img src='{$livro['imagem']}' class='card-img-top img-fluid w-25 h-100 mx-auto pt-3' alt='Capa do livro'>";
                            } 
                            else 
                            {
                                echo "<img src='img/capa-generica.jpeg' class='card-img-top img-fluid w-25 h-100 mx-auto pt-3' alt='Capa do livro'>";
                            }
                            echo '<div class="card-body d-flex justify-content-center flex-wrap">'; //abre o card-body
                            echo "<a href='livro.php?id={$livro['idLivro']}' class='text-white text-center btn btn-primary my-1'>Ver livro</a>";
                            echo "<a href='PDO/removerLivro.php?id={$livro['idLivro']}' class='text-white text-center btn btn-secondary mx-1 my-1'>Remover</a>";
                            echo '</div>'; //fecha o card-body
                            echo '</div>'; //fecha a div do livro
                        }
                    }
                    echo "</div>"; //fecha a div com todos os livros
                ?>
            </div>
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
    <script type="text/javascript" src="js/menu_script-3.js"></script>
    <script type="text/javascript" src="js/slider.js"></script>
</body>
</html> 