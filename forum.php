<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
include("conexao.php");

$cats = $conn->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum - Meu Fórum</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-comments"></i> Fórum</h1>
            <div class="profile-menu">
                <button class="btn profile-btn"><i class="fas fa-user"></i> Perfil</button>
                <div class="profile-dropdown">
                    <img src="https://minotar.net/avatar/<?php echo htmlspecialchars($_SESSION['minecraft_nick']); ?>/100" alt="Skin">
                    <p><?php echo htmlspecialchars($_SESSION['user_nick']); ?></p>
                    <a href="logout.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
                    <?php if($_SESSION['user_nick'] === 'LaranjitoYT' && $_SESSION['is_admin']): ?>
                        <a href="admin.php" class="btn admin-btn"><i class="fas fa-user-shield"></i> Gerenciar Admins</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php while($c = $cats->fetch_assoc()): ?>
            <div class="card">
                <h2><a href="categoria.php?id=<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nome']); ?></a></h2>
                <p><?php echo htmlspecialchars($c['descricao']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>
    <script>
        document.querySelector('.profile-btn').addEventListener('click', () => {
            document.querySelector('.profile-dropdown').classList.toggle('show');
        });
    </script>
</body>
</html>