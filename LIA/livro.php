<?php
    session_start();
    require_once "PDO/dao.php";
    $livroManipulado = buscarLivroPorId($_GET['id'])[0];
    $somaAutores = "";
    if(isset($_SESSION['logado'])) 
    { 
        if(livro_ja_existe_bd($_GET['id'], $_SESSION['idUsuario'])) 
        { 
            $livro_usuario = select_livro($_GET['id'], $_SESSION['idUsuario']); 
            $salvo = $livro_usuario['salvo']; 
            $gostou = $livro_usuario['gostou']; 
            $naoGostou = $livro_usuario['nao_gostou']; 
            if($salvo == 1) 
            { 
                $corSalvo = "#ffc107"; 
            } 
            else 
            { 
                $corSalvo = "white"; 
            }
            if($gostou == 1)
            {
                $classGostou = "btn-secondary";
            }
            else
            {
                $classGostou = "btn-light";
            }
            if($naoGostou == 1)
            {
                $classNaoGostou = "btn-secondary";
            }
            else
            {
                $classNaoGostou = "btn-light";
            }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/teste13.css" rel="stylesheet">
    <title>LIA</title>
</head>
<body>
    <div>
        <header class="d-flex align-items-center px-5 w-100 justify-content-between">
            <div class="icones-menu align-content-center">
                <a href="<?php echo isset($_SESSION['logado']) ? 'home.php' : 'index.php'; ?>"><img src="img/book-open.png"></a>
                <img src="img/menu-button.png" id="menu_aberto_botao" hidden>
                <img src="img/menu-fechado.png" id="menu_fechado_botao">
            </div>
            <div class="links-navegacao d-flex justify-content-between col-8 col-md-5 col-lg-6 pt-3 pt-3" id="menu_aberto">
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="catalogo.php" class="elemento-navegacao"><img src="img/book.png"></a>
                    <p class="elemento-navegacao">Catálogo</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="<?php echo isset($_SESSION['logado']) ? 'home.php' : 'index.php'; //VERIFICA SE O USUÁRIO ESTÁ LOGADO, manda para o home se estiver, ou index se não estiver?>" class="elemento-navegacao">
                        <img src="img/home.png">
                    </a>
                    <p class="elemento-navegacao">Home</p>
                </div>
                <?php if (isset($_SESSION['logado'])): //VERIFICA SE O USUÁRIO ESTÁ LOGADO?>
                    <div class="d-flex flex-column mb-2 align-items-center">
                        <a href="perfil.php" class="elemento-navegacao"><img src="img/perfil.png"></a>
                        <p class="elemento-navegacao">Perfil</p>
                    </div>
                <?php endif; ?>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="sobre.php" class="elemento-navegacao"><img src="img/info.png"></a>
                    <p class="elemento-navegacao">Sobre</p>
                </div>
            </div>
            <div style="width:40px;">
                <?php if (isset($_SESSION['logado'])): //VERIFICA SE O USUÁRIO ESTÁ LOGADO?>
                    <div class="d-flex flex-column mb-2 mt-3 align-items-center justify-content-center">
                        <a href="PDO/finalizarSessao.php" class="elemento-navegacao"><img src="img/logout.png"></a>
                        <p class="elemento-navegacao">Sair</p>
                    </div>
                <?php endif; ?>
            </div>
        </header>
    </div>
    <div class="d-flex flex-column bg-cinza-claro container-custom">
        <div class="card d-flex flex-row justify-content-center flex-wrap">
            <?php
                if(!empty($livroManipulado["imagem"])) 
                {
                    echo "<img src='{$livroManipulado['imagem']}' class='img-fluid py-5 px-1 capa-livro col-12 col-md-6 col-lg-3' alt='Capa do livro'>";
                } 
                else 
                {
                    echo "<img src='img/capa-generica.jpeg' class='py-5 img-fluid capa-livro' alt='Capa do livro'>";
                }
                echo "<div class='d-flex flex-column p-5 col-12 col-md-6 col-lg-9'>"; //classe com as informações sobre o livro
                echo "<div class='d-flex flex-row justify-content-between'>"; //classe com o título e a lista com botões de favoritar e marcar como lido
                echo "<h1>{$livroManipulado["titulo"]}</h1>";
                if (isset($_SESSION['logado'])) //VERIFICA SE O USUÁRIO ESTÁ LOGADO
                {
                    echo "<svg viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg' class='img-fluid svg-pequeno'>";
                    echo "<polygon points='30,3 36.613,20.899 55.679,21.656 40.7,33.476 45.87,51.844 30,41.25 14.13,51.844 19.3,33.476 4.321,21.656 23.387,20.899' fill='".(isset($corSalvo) ? $corSalvo : "white")."' stroke='black' id='estrela'>";
                    echo "</svg>";
                }
                echo "</div>";
                foreach($livroManipulado["autores"] as $autor)
                {
                    $somaAutores = $somaAutores.' - '.$autor;
                }
                echo "<h2>Autor(es): {$somaAutores}</h2>";
                echo "<p>ISBN13: {$livroManipulado["ISBN13"]}</p>";
                echo "<p>{$livroManipulado["descricao"]}</p>";
                echo "<div class='d-flex flex-row'>"; //classe com links
                echo "<a href='{$livroManipulado["linkLeituraOnline"]}' class='btn btn-primary mx-1'>Leitura online</a>";
                echo "<a href='{$livroManipulado["linkCompra"]}' class='btn btn-primary'>Compra</a>";
                echo "</div>"; //fechamento da classe com links
                if (isset($_SESSION['logado'])) //VERIFICA SE O USUÁRIO ESTÁ LOGADO
                {
                    echo "<div class='btn-group mt-5 col-12 col-md-9 col-lg-6' role='group'>"; //grupo de botões like e dislike
                    echo "<button class='btn ".(isset($gostou) ? "$classGostou" : "btn-light")." border' id='btnLike'><i class='fa fa-thumbs-up'></i></button>"; //like
                    echo "<button class='btn ".(isset($naoGostou) ? "$classNaoGostou" : "btn-light")." border'id='btnDislike'><i class='fa fa-thumbs-down'></i></button>"; //dislike
                    echo "</div>"; //fechamento da classe de botões like e dislike
                }
                echo "</div>"; //fechamento da classe com informações do livro
            ?>
        </div>
        <div class="d-none alert alert-info alert-dismissible fade show mt-5" id="mensagem_favorito">
            <p id='texto_mensagem_favorito' class="text-center"></p>
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
    <script>
        const idLivro = <?php echo json_encode($_GET['id']); ?>;
        const imagem = <?php echo json_encode($livroManipulado["imagem"]);?>
    </script>
    <script type="text/javascript" src="js/menu_script-3.js"></script>
    <script type="text/javascript" src="js/salvarLivro.js"></script>
    <script type="text/javascript" src="js/salvarDadosLivro-3.js"></script>
    <script type="text/javascript" src="js/likeLivro.js"></script>
</body>
</html> 