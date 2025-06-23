<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_nick'] !== 'LaranjitoYT' || !$_SESSION['is_admin']){ header("Location: index.php"); exit(); }
include("conexao.php");

if(isset($_POST['new_admin_nick'])) {
    $new_admin_nick = mysqli_real_escape_string($conn, $_POST['new_admin_nick']);
    $check_sql = "SELECT nick FROM users WHERE nick = '$new_admin_nick'";
    $check_result = $conn->query($check_sql);
    if($check_result->num_rows > 0) {
        $update_sql = "UPDATE users SET is_admin = 1 WHERE nick = '$new_admin_nick'";
        $conn->query($update_sql);
    } else {
        echo "<p class='error'>Usuário $new_admin_nick não encontrado!</p>";
    }
}

if(isset($_GET['remove_admin']) && isset($_GET['nick'])) {
    $remove_nick = mysqli_real_escape_string($conn, $_GET['nick']);
    $update_sql = "UPDATE users SET is_admin = 0 WHERE nick = '$remove_nick'";
    $conn->query($update_sql);
    header("Location: admin.php");
    exit();
}

$admins = $conn->query("SELECT nick, minecraft_nick FROM users WHERE is_admin = 1");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Admins - Meu Fórum</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-shield"></i> Gerenciar Administradores</h1>
            <div class="profile-menu">
                <button class="btn profile-btn"><i class="fas fa-user"></i> Perfil</button>
                <div class="profile-dropdown">
                    <img src="https://minotar.net/avatar/<?php echo htmlspecialchars($_SESSION['minecraft_nick']); ?>/100" alt="Skin">
                    <p><?php echo htmlspecialchars($_SESSION['user_nick']); ?></p>
                    <a href="logout.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </div>
        </div>
        <div class="card">
            <h2>Adicionar Novo Admin</h2>
            <form method="post">
                <div class="input-group">
                    <input type="text" name="new_admin_nick" placeholder="Nick do novo admin" required>
                </div>
                <button type="submit" class="btn">Adicionar</button>
            </form>
        </div>
        <h2>Lista de Admins</h2>
        <?php while($admin = $admins->fetch_assoc()): ?>
            <div class="card">
                <img src="https://minotar.net/avatar/<?php echo htmlspecialchars($admin['minecraft_nick'] ?: 'Steve'); ?>/100" alt="Skin">
                <p><?php echo htmlspecialchars($admin['nick']); ?></p>
                <a href="?remove_admin=1&nick=<?php echo htmlspecialchars($admin['nick']); ?>" class="btn delete-btn" onclick="return confirm('Tem certeza que deseja remover este admin?');"><i class="fas fa-trash"></i> Remover</a>
            </div>
        <?php endwhile; ?>
        <a href="forum.php" class="btn"><i class="fas fa-arrow-left"></i> Voltar</a>
    </div>
    <script>
        document.querySelector('.profile-btn').addEventListener('click', () => {
            document.querySelector('.profile-dropdown').classList.toggle('show');
        });
    </script>
</body>
</html>