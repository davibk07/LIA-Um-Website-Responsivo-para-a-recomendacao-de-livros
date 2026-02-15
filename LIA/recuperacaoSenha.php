<?php
    session_start();
    require_once 'PDO/dao.php';
    date_default_timezone_set('America/Sao_Paulo');
    $idRequisicao = verificarToken($_GET['token']);
    $requisicao = select_requisicao($idRequisicao)[0];
    if(empty($requisicao))
    {
        header("Location: index.php");
        exit;
    }
    $expirada = $requisicao['expirada'];
    $inicioRequisicao = new DateTime($requisicao['hora_inicio']);
    if($expirada == 0)
    {
        $horarioAtual = new DateTime();
        $duracaoRequisicao = $horarioAtual->diff($inicioRequisicao);
        $totalMinutos = $duracaoRequisicao->days * 24 * 60;
        $totalMinutos += $duracaoRequisicao->h * 60;
        $totalMinutos += $duracaoRequisicao->i;
        if ($totalMinutos >= 60) 
        {
            encerrar_requisicao($_GET['idRequisicao']);
        }
    }
    if(isset($_SESSION['mensagem']))
    {
        $mensagem = $_SESSION['mensagem'];
    }
    else if($expirada == 1)
    {
        $mensagem = ["Sessão expirada!", "img/expirado.png"];
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
    <title>LIA</title>
</head>
<body>
    <?php if(isset($mensagem)): ?>
        <div class="d-flex flex-column container-custom bg-cinza-claro">
            <div class="d-flex flex-column justify-content-center align-items-center mt-4">
                <div class="w-50">
                    <div class="p-4 rounded text-center bg-cinza-medio">
                        <img src=<?=$mensagem[1]?> alt="Imagem de feedback" class="w-25">
                        <div class="text-center p-3 rounded">
                            <h1><?= htmlspecialchars($mensagem[0], ENT_QUOTES) ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($mensagem[0] != "Algo ocorreu de forma errada!"): ?>
            <div class="d-flex justify-content-center mt-5">
                <a href="index.php" class="btn btn-primary">Retornar para o sistema</a>
            </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if ($expirada == 0): ?>
        <div class="d-flex justify-content-center bg-cinza-claro container-custom py-5 flex-column">
            <div class="login-container border border-dark bg-cinza-medio px-5 pt-3 col-12 col-md-6 col-lg-4 mx-auto">
                <div class="login-header">
                    <h1 class="text-center text-secondary">Alterar Senha</h1>
                    <hr>
                </div>
                <form method="post" action="PDO/esqueciSenhaAlteracao.php" class="d-flex flex-column p-5">
                    <input type="hidden" name="idRequisicao" id="idRequisicao" value="<?= htmlspecialchars($idRequisicao ?? '', ENT_QUOTES) ?>">
                    <input type="hidden" name="token" id="token" value="<?= htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES)?>">
                    <div class="d-flex pb-3 gap-2">
                        <img src="img/senha-login.png">
                        <input type="password" class="form-control" id="senha" placeholder="Nova senha" name="senha" required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" value="Alterar Senha" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
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
</body>
</html>