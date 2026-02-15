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
        <header class="d-flex justify-content-between px-5">
            <div class="icones-menu align-content-center col-3 col-md-3 col-lg-2">
                <a href="index.php"><img src="img/book-open.png"></a>
                <img src="img/menu-button.png" id="menu_aberto_botao" hidden>
                <img src="img/menu-fechado.png" id="menu_fechado_botao">
            </div>
            <div class="links-navegacao d-flex justify-content-between col-6 col-md-5 col-lg-6 pt-3 pt-3" id="menu_aberto">
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="catalogo.php" class="elemento-navegacao"><img src="img/book.png"></a>
                    <p class="elemento-navegacao">Catálogo</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="index.php" class="elemento-navegacao"><img src="img/home.png"></a>
                    <p class="elemento-navegacao">Home</p>
                </div>
                <div class="d-flex flex-column mb-2 align-items-center">
                    <a href="sobre.php" class="elemento-navegacao"><img src="img/info.png"></a>
                    <p class="elemento-navegacao">Sobre</p>
                </div>
            </div>
            <div class="align-content-center bloco-login">
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="cadastro.php" class="btn btn-secondary">Registrar</a>
            </div>
        </header>
    </div>
    <div class="d-flex flex-column bg-cinza-claro container-custom">
        <h1 class="title text-center">LIA</h1>
        <p class="text-center text-muted">Recomendação de Livros</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="login.php" class="btn btn-primary col-9 col-md-3 col-lg-1">Login</a>
            <a href="cadastro.php" class="btn btn-secondary col-9 col-md-3 col-lg-1">Registrar</a>
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
</body>
</html> 