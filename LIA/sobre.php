<?php
    session_start();
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
                <a href="<?php echo isset($_SESSION['logado']) ? 'home.php' : 'index.php'; ?>"><img src="img/book-open.png"></a>
                <img src="img/menu-button.png" id="menu_aberto_botao" hidden>
                <img src="img/menu-fechado.png" id="menu_fechado_botao">
            </div>
            <div class="links-navegacao d-flex justify-content-between col-8 col-md-5 col-lg-6 pt-3" id="menu_aberto">
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
        <div class="d-flex flex-column col-12 col-md-9 col-lg-9 mx-auto">
            <label class="fw-bold fs-5 text-center my-4">Miguel Freitas da Rosa</label>
            <div class="d-flex flex-column align-items-center bg-cinza-medio py-5 mx-auto border border-dark p-5">
                <p>Aluno do curso técnico em informática integrado ao ensino médio, 4º ano, IFRS - Campus Farroupilha. (2025)</p>
            </div>        
        </div>
        <div class="d-flex flex-column col-12 col-md-9 col-lg-9 mx-auto">
            <label class="fw-bold fs-5 text-center my-4">Davi Bazzanella Kuhn</label>
            <div class="d-flex flex-column align-items-center bg-cinza-medio py-5 mx-auto border border-dark p-5">
                <p>Aluno do curso técnico em informática integrado ao ensino médio, 4º ano, IFRS - Campus Farroupilha. (2025)</p>
            </div>        
        </div>
        <div class="d-flex flex-column col-12 col-md-9 col-lg-9 mx-auto">
            <label class="fw-bold fs-5 mb-2 text-center my-4">LIA</label>
            <div class="d-flex flex-column align-items-center bg-cinza-medio py-5 mx-auto border border-dark p-5">
                <p>LIA é um projeto de TCC criado por dois alunos de ensino médio técnico em informática integrado do IFRS - Campus Farroupilha em 2025. <br>O objetivo principal é estimular a leitura de uma forma tecnológica, integrando sistemas de recomendação e conceitos ensinados<br> durante o curso técnico, bem como responsividade, CSS, HTML, PHP, MySQL, JavaScript, Python, etc...</p>
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
</body>
</html> 