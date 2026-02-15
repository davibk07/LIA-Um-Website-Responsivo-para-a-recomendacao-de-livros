<?php
    require_once 'conexao.php';
    function getPdo() 
    {
        return cria_conexao();
    }

    function criar_usuario($username, $email, $password)
    {
        try
        {
            $pdo = getPdo();
            $sql = "INSERT INTO Usuario (username, email, password) 
                    VALUES (:username, :email, md5(:password))";
            $statement = $pdo -> prepare($sql);
            $statement -> bindParam(':username', $username);
            $statement -> bindParam(':email', $email);
            $statement -> bindParam(':password', $password);
            $statement -> execute();
            return $statement -> rowCount() > 0;
        }
        catch(PDOException $e)
        {
            print("Error: " . $e->getMessage());
        }
    }
    function atualizar_usuario($username, $password) 
    {
        try 
        {
            $pdo = getPdo();
            $sql = "UPDATE Usuario SET 
                    password = md5(:password)
                    WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return $stmt->rowCount() > 0; // retorna true se algum registro foi atualizado
        } 
        catch (PDOException $e) 
        {
            echo "Erro ao atualizar usuário: " . $e->getMessage();
            return false;
        }
    }
    function atualizar_usuario_id($idUsuario, $password) 
    {
        try 
        {
            $pdo = getPdo();
            $sql = "UPDATE Usuario SET 
                    password = md5(:password)
                    WHERE idUsuario = :idUsuario";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return $stmt->rowCount() > 0; // retorna true se algum registro foi atualizado
        } 
        catch (PDOException $e) 
        {
            echo "Erro ao atualizar usuário: " . $e->getMessage();
            return false;
        }
    }
    function existe_usuario($email, $username)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Usuario WHERE email = :email OR username = :username";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":username", $username);
        $statement->execute();

        $usuario = $statement->fetch(PDO::FETCH_ASSOC);
        return !empty($usuario);
    }
    function dados_corretos_usuario($username, $password)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Usuario WHERE username = :username AND password = md5(:password)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":username", $username);
        $statement->bindParam(":password", $password);
        $statement->execute();
        $usuario = $statement->fetch(PDO::FETCH_ASSOC);
        return !empty($usuario);
    }
    function select_usuario($username)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Usuario WHERE username = :username";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":username", $username);
        $statement->execute();
        $usuario = $statement->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    }
    function select_usuario_email($email)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Usuario WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $email);
        $statement->execute();
        $usuario = $statement->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    }
    function buscarLivroPorNome($nomeLivro) 
    {
        $baseUrl = "https://www.googleapis.com/books/v1/volumes"; //base de dados usada
        $query = http_build_query([
            "q" => "intitle:" . $nomeLivro,
            "maxResults" => 8,
            "printType" => "books",
            "orderBy" => "relevance"
        ]);
        $url = $baseUrl . "?" . $query;
        $json = file_get_contents($url);
        if ($json === false) 
        {
            return "Erro ao acessar a API.";
        }
        $dados = json_decode($json, true);
        $resultados = [];
        if (!empty($dados['items'])) 
        {
            foreach ($dados['items'] as $item) 
            {
                $info = $item['volumeInfo'];
                $imagens = $info['imageLinks'];
                if (preg_match('/box|caixa|coleção/i', $info['title'])) 
                {
                    continue;
                }
                $identificadores = $info['industryIdentifiers'];
                $link_leitura_online = $item['accessInfo']['webReaderLink'];
                $resultados[] = 
                [
                    "id" => $item['id'],
                    "titulo" => $info['title'] ?? '',
                    "imagem" => $imagens['thumbnail'] ?? ''
                ];
            }
        }
        return $resultados;
    }
    function buscarLivroPorId($id) 
    {
        $baseUrl = "https://www.googleapis.com/books/v1/volumes"; //base de dados usada
        $url = $baseUrl."/".$id;
        $json = file_get_contents($url);
        $dados = json_decode($json, true);
        $info = $dados['volumeInfo'];
        if(isset($info['imageLinks']))
        {
            $imagens = $info['imageLinks'];
        }
        $livro[] = 
                [
                    "id" => $dados['id'],
                    "titulo" => $info['title'] ?? '',
                    "autores" => $info['authors'] ?? [],
                    "descricao" => $info['description'] ?? '',
                    "linkCompra" => $info['infoLink'] ?? '',
                    "linkLeituraOnline" => $dados['accessInfo']['webReaderLink'] ?? '',
                    "ISBN13" => $info['industryIdentifiers'][0]['identifier'] ?? '',
                    "imagem" => $imagens['thumbnail'] ?? ''
                ];
        return $livro;
    }
    function select_livro($idLivro, $idUsuario)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Livro WHERE idLivro = :idLivro AND idUsuario = :idUsuario";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":idLivro", $idLivro);
        $statement->bindParam(":idUsuario", $idUsuario);
        $statement->execute();
        $livro = $statement->fetch(PDO::FETCH_ASSOC);
        return $livro;
    }
    function livro_ja_existe_bd($idLivro, $idUsuario)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Livro WHERE idLivro = :idLivro AND idUsuario = :idUsuario";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":idLivro", $idLivro);
        $statement->bindParam(":idUsuario", $idUsuario);
        $statement->execute();
        $livro = $statement->fetch(PDO::FETCH_ASSOC);
        return !empty($livro);
    }
    function atualizar_livro($idUsuario, $idLivro, $gostou, $naoGostou, $salvo) 
    {
        try 
        {
            $pdo = getPdo();
            // Monta o SQL dinamicamente para as 8 respostas
            $sql = "UPDATE Livro SET 
                        gostou = :gostou,
                        nao_gostou = :nao_gostou,
                        salvo = :salvo
                    WHERE idUsuario = :idUsuario AND idLivro = :idLivro";
            $stmt = $pdo->prepare($sql);
            // Bind do usuário
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idLivro', $idLivro);
            $stmt->bindParam(':gostou', $gostou);
            $stmt->bindParam(':nao_gostou', $naoGostou);
            $stmt->bindParam(':salvo', $salvo);
            $stmt->execute();
            return $stmt->rowCount() > 0; // retorna true se algum registro foi atualizado
        } 
        catch (PDOException $e) 
        {
            echo "Erro ao atualizar questionário: " . $e->getMessage();
            return false;
        }
    }
    function desrecomendar_livro($idUsuario, $idLivro) 
    {
        try 
        {
            $pdo = getPdo();
            $sql = "UPDATE Livro SET 
                        recomendado = 0
                    WHERE idUsuario = :idUsuario AND idLivro = :idLivro";
            $stmt = $pdo->prepare($sql);
            // Bind do usuário
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idLivro', $idLivro);
            $stmt->execute();
            return $stmt->rowCount() > 0; // retorna true se algum registro foi atualizado
        } 
        catch (PDOException $e) 
        {
            echo "Erro ao atualizar livro: " . $e->getMessage();
            return false;
        }
    }
    function recomendar_livro($idUsuario, $idLivro) 
    {
        try 
        {
            $pdo = getPdo();
            $sql = "UPDATE Livro SET 
                        recomendado = 1,
                        horaRecomendacao = now()
                    WHERE idUsuario = :idUsuario AND idLivro = :idLivro";
            $stmt = $pdo->prepare($sql);
            // Bind do usuário
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->bindParam(':idLivro', $idLivro);
            $stmt->execute();
            return $stmt->rowCount() > 0; // retorna true se algum registro foi atualizado
        } 
        catch (PDOException $e) 
        {
            echo "Erro ao atualizar livro: " . $e->getMessage();
            return false;
        }
    }
    function select_ultima_recomendacao($idUsuario)
    {
        $pdo = getPdo();
        $sqlUltimaHora = "SELECT MAX(horaRecomendacao) as ultimaHora 
                        FROM Livro 
                        WHERE idUsuario = :idUsuario";
        $stmt = $pdo->prepare($sqlUltimaHora);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->execute();
        $ultimaHora = $stmt->fetchColumn();
        $sql = "SELECT * FROM Livro 
                WHERE idUsuario = :idUsuario
                AND horaRecomendacao = :ultimaHora
                AND recomendado = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":idUsuario", $idUsuario);
        $stmt->bindParam(":ultimaHora", $ultimaHora);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function criar_livro($idUsuario, $idLivro, $gostou, $naoGostou, $salvo, $recomendado, $imagem)
    {
        try
        {
            $pdo = getPdo();
            $sql = "INSERT INTO Livro (idLivro, idUsuario, salvo, gostou, nao_gostou, recomendado, imagem) 
                    VALUES (:idLivro, :idUsuario, :salvo, :gostou, :nao_gostou, :recomendado, :imagem)";
            $statement = $pdo -> prepare($sql);
            $statement->bindParam(':idUsuario', $idUsuario);
            $statement->bindParam(':idLivro', $idLivro);
            $statement->bindParam(':gostou', $gostou);
            $statement->bindParam(':nao_gostou', $naoGostou);
            $statement->bindParam(':salvo', $salvo);
            $statement->bindParam(':recomendado', $recomendado);
            $statement->bindParam(':imagem', $imagem);
            $statement -> execute();
            return $statement -> rowCount() > 0;
        }
        catch(PDOException $e)
        {
            print("Error: " . $e->getMessage());
        }
    }
    function excluir_livro($idLivro, $idUsuario)
    {
        try
        {
            $pdo = getPdo();
            $sql = "DELETE FROM Livro WHERE idLivro = :idLivro and idUsuario = :idUsuario";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':idUsuario', $idUsuario);
            $statement->bindParam(':idLivro', $idLivro);
            $statement -> execute();
        }
        catch(PDOException $e)
        {
            print("Error: " . $e->getMessage());
        }
    }
    function select_livros($idUsuario)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Livro WHERE idUsuario = :idUsuario";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":idUsuario", $idUsuario);
        $statement->execute();
        $livro = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $livro;
    }
  function enviar_email($email, $mail, $idRequisicao)
{
    try 
    {
        // Lê config.php
        $config = include __DIR__ . '/config.php';

        $token = gerarToken($idRequisicao);

        // Config SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];   
        $mail->Password = $config['senha'];   
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom($config['email'], 'LIA'); 
        $mail->addAddress($email);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Recuperar senha!';
        $mail->Body = 'Seu email foi usado para recuperar uma senha em nosso site! (A requisição expira em 1 HORA)
            Use o link abaixo para enviar sua nova senha: http://localhost/tcc/recuperacaoSenha.php?token=' . $token;

        $mail->send();
        echo "Email enviado com sucesso!";
    } 
    catch (Exception $e) 
    {
        echo "Não foi possível enviar o email. Erro: {$mail->ErrorInfo}";
    }
}
    function criar_requisicao($idUsuario)
    {
        try
        {
            $pdo = getPdo();
            $sql = "INSERT INTO Requisicao (idUsuario, expirada, hora_inicio) 
                    VALUES (:idUsuario, 0, now())";
            $statement = $pdo -> prepare($sql);
            $statement->bindParam(':idUsuario', $idUsuario);
            $statement -> execute();
            return $pdo->lastInsertId();
        }
        catch(PDOException $e)
        {
            print("Error: " . $e->getMessage());
        }
    }
    function select_requisicao($idRequisicao)
    {
        $pdo = getPdo();
        $sql = "SELECT * FROM Requisicao WHERE idRequisicao = :idRequisicao";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":idRequisicao", $idRequisicao);
        $statement->execute();
        $requisicao = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $requisicao;
    }
    function encerrar_requisicao($idRequisicao) 
    {
        try 
        {
            $pdo = getPdo();
            $sql = "UPDATE Requisicao SET 
                    expirada = 1
                    WHERE idRequisicao = :idRequisicao";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":idRequisicao", $idRequisicao);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } 
        catch (PDOException $e) 
        {
            echo "Erro ao atualizar requisição: " . $e->getMessage();
            return false;
        }
    }
    function gerarToken($idRequisicao)
    {
        $iv = random_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $token = openssl_encrypt($idRequisicao, 'aes-256-cbc', 'JuVeNtUdE1913', 0, $iv);
        return base64_encode($token . '::' . base64_encode($iv));
    }
    function verificarToken($token) 
    {
        // Decodifica o token e o IV
        list($token_encriptado, $iv_base64) = explode('::', base64_decode($token), 2);
        $iv = base64_decode($iv_base64);

        // Descriptografa o token
        $dados = openssl_decrypt($token_encriptado, 'aes-256-cbc', 'JuVeNtUdE1913', 0, $iv);

        return $dados;
    }

?>