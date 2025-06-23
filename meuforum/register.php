<?php
include("conexao.php");

if(isset($_POST['nick']) && isset($_POST['senha'])) {
    $nick = mysqli_real_escape_string($conn, $_POST['nick']);
    $check_sql = "SELECT nick FROM users WHERE nick = '$nick'";
    $check_result = $conn->query($check_sql);
    if($check_result->num_rows > 0) {
        echo "<p class='error'>Este nick já está registrado!</p>";
    } else {
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nick, senha) VALUES ('$nick', '$senha')";
        if($conn->query($sql)) {
            echo "<p class='success'>Conta criada! <a href='index.php'>Faça login</a></p>";
        } else {
            echo "<p class='error'>Erro: " . $conn->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Meu Fórum</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2><i class="fas fa-user-plus"></i> Criar Conta</h2>
            <form method="post">
                <div class="input-group">
                    <input type="text" name="nick" placeholder="Nick" required>
                </div>
                <div class="input-group">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn">Registrar</button>
            </form>
            <p>Já tem conta? <a href="index.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>