<?php
    session_start();
    if(isset($_SESSION['mensagem']))
    {
        $mensagem = $_SESSION['mensagem'];
    }
    $_SESSION = array();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/teste13.css" rel="stylesheet">
    <title>Cadastro</title>
</head>
<body>
    <div>
        <header class="d-flex align-items-center px-5 w-100 justify-content-between">
            <div class="icones-menu align-content-center">
                <a href="index.php"><img src="img/book-open.png"></a>
                <img src="img/menu-button.png" id="menu_aberto_botao" hidden>
                <img src="img/menu-fechado.png" id="menu_fechado_botao">
            </div>
            <div class="links-navegacao d-flex justify-content-between col-8 col-md-5 col-lg-6 pt-3 pt-3" id="menu_aberto">
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="catalogo.php" class="elemento-navegacao"><img src="img/book.png"></a>
                    <p class="elemento-navegacao">Catálogo</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="index.php" class="elemento-navegacao"><img src="img/home.png"></a>
                    <p class="elemento-navegacao">Home</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="#" class="elemento-navegacao"><img src="img/info.png"></a>
                    <p class="elemento-navegacao">Sobre</p>
                </div>
            </div>
            <div style="width:40px;"></div>
        </header>
    </div>
    <div class="d-flex justify-content-center bg-cinza-claro container-custom py-5 flex-column">
        <div class="cadastro-container bg-cinza-medio px-5 pt-5 col-12 col-md-6 col-lg-4 mx-auto">
            <div class="cadastro-header">
                <h1 class="text-center text-secondary">Cadastro</h1>
                <hr>
            </div>
            <form method="post" action="PDO/cadastrarUsuario.php" class="d-flex flex-column p-5">
                <div class="d-flex gap-2">
                    <img src="img/perfil-login.png">
                    <input type="text" class="form-control col-8 col-md-6 col-lg-12" id="username" placeholder="Usuário" name="username" required>
                </div>
                <div class="d-flex py-3 gap-2">
                    <img src="img/email-login.png">
                    <input type="email" class="form-control col-8 col-md-6 col-lg-12" id="email" placeholder="Email" name="email" required>
                </div>
                <div class="d-flex gap-2">
                    <img src="img/senha-login.png">
                    <input type="password" class="form-control col-8 col-md-6 col-lg-12" id="senha" placeholder="Senha" name="senha" required>
                </div>
                <div class="d-flex justify-content-center py-3">
                    <input type="submit" value="Cadastrar" class="btn btn-primary">
                </div>
                <div class="p-3 text-center">
                    <hr>
                    Já tem uma conta? <a href="login.php" class="fw-bold text-dark">Faça login</a>
                </div> 
            </form>
        </div>
        <div id="mensagem" class="d-none alert alert-dismissible fade show mx-auto text-center w-75 mt-3">
            <p id="texto-mensagem" class="m-0 p-2 rounded"></p>
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
    <script>
        const mensagem = <?php echo json_encode($mensagem ?? null); ?>;
    </script>
    <script src="js/feedback-1.js"></script>
</body>
</html>