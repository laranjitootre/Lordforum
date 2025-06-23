<?php
session_start();
include("conexao.php");

if(isset($_POST['nick']) && isset($_POST['senha'])){
    $nick = mysqli_real_escape_string($conn, $_POST['nick']);
    $senha = $_POST['senha'];
    $sql = "SELECT * FROM users WHERE nick='$nick'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($senha, $user['senha'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nick'] = $user['nick'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['minecraft_nick'] = $user['minecraft_nick'] ?: 'Steve';
            header("Location: forum.php");
        } else {
            echo "<p class='error'>Senha incorreta!</p>";
        }
    } else {
        echo "<p class='error'>Usuário não encontrado!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Meu Fórum</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2><i class="fas fa-lock"></i> Entrar no Fórum</h2>
            <form method="post">
                <div class="input-group">
                    <input type="text" name="nick" placeholder="Nick" required>
                </div>
                <div class="input-group">
                    <input type="password" name="senha" placeholder="Senha" required>
                </div>
                <button type="submit" class="btn">Entrar</button>
            </form>
            <p>Não tem conta? <a href="register.php">Registre-se</a></p>
        </div>
    </div>
</body>
</html>