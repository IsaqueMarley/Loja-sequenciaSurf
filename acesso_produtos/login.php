<?php
// login.php

// Inclua a conexão com o banco de dados
require_once('conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/acesso_produtos/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="form-container">
        <h1>ADMINISTRADOR</h1>
        <form method="post" action="login.php">
            <div class="campos">
                <label for="email">Email:</label>
                <input type="email" name="email" required class="campo">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required class="campo">
            </div>

            <div class="mensagem">
                <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        try {
                            // Obtenha os dados do formulário
                            $email = $_POST['email'];
                            $senha = $_POST['senha'];

                            // Use prepared statements para prevenir SQL injection
                            $query = "SELECT * FROM usuarios WHERE email = :email";
                            $stmt = $conexao->prepare($query);
                            $stmt->bindParam(':email', $email);
                            $stmt->execute();

                            // Verifique se o usuário existe
                            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($usuario) {
                                // Verifique a senha apenas se o usuário existe
                                if (password_verify($senha, $usuario['senha'])) {
                                    session_start();
                                    $_SESSION['usuario_id'] = $usuario['id'];
                                    header("Location: index_1.php");
                                    exit();
                                } else {
                                    echo "Credenciais inválidas.";
                                }
                            } else {
                                echo "Credenciais inválidas.";
                            }
                        } catch (PDOException $e) {
                            echo "Erro ao fazer login: " . $e->getMessage();
                        }
                    }
                ?>
            </div>

            <div class="botoes">
                <input type="submit" value="ENTRAR" class="botao">
                <input type="reset" value="LIMPAR" class="botao">
            </div>
        </form>
    </div>

</body>

</html>