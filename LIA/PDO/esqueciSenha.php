<?php
    session_start();
    require_once 'dao.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';
    require '../PHPMailer-master/src/Exception.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $mail = new PHPMailer(true);
    $email = $_POST['email-recuperacao'];
    $idUsuario = select_usuario_email($email)['idUsuario'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !isset($idUsuario)) 
    {
        $_SESSION['mensagem'] = ["Email inválido", "alert-danger"];
    }
    else 
    {
        $idRequisicao = criar_requisicao($idUsuario);
        enviar_email($email, $mail, $idRequisicao);
        $_SESSION['mensagem'] = ["Email enviado", "alert-success"];
    }
    header("Location: ../login.php");
    exit;
?>