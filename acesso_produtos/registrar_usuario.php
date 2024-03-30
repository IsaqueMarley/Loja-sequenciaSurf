<?php
// Defina o tempo máximo de inatividade da sessão (em segundos)
ini_set('session.gc_maxlifetime', 3600); // 1 hora

// Defina a duração do cookie de sessão (em segundos)
ini_set('session.cookie_lifetime', 3600); // 1 hora

// Inclua a verificação de autenticação no início
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Inclua a conexão com o banco de dados
require_once('conexao.php');

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        // Use prepared statements para prevenir SQL injection
        $query = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        echo "Usuário registrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao registrar usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuário</title>
    <style>
        /* Adicione seus estilos CSS aqui */
    </style>
</head>
<body>
    <h2>Registrar Usuário</h2>
    <form method="post" action="registrar_usuario.php">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>
        
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
