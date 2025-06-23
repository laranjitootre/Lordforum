<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
include("conexao.php");

$id = (int)$_GET['id'];
$categoria = $conn->query("SELECT * FROM categorias WHERE id = $id")->fetch_assoc();
$topicos = $conn->query("SELECT t.*, u.nick FROM topicos t JOIN users u ON t.autor_id = u.id WHERE t.categoria_id = $id ORDER BY data DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($categoria['nome']); ?> - Meu Fórum</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-folder"></i> Categoria: <?php echo htmlspecialchars($categoria['nome']); ?></h1>
            <div class="profile-menu">
                <button class="btn profile-btn"><i class="fas fa-user"></i> Perfil</button>
                <div class="profile-dropdown">
                    <img src="https://minotar.net/avatar/<?php echo htmlspecialchars($_SESSION['minecraft_nick']); ?>/100" alt="Skin">
                    <p><?php echo htmlspecialchars($_SESSION['user_nick']); ?></p>
                    <a href="logout.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </div>
        </div>
        <p><?php echo htmlspecialchars($categoria['descricao']); ?></p>
        <a href="novo_topico.php?cat=<?php echo $id; ?>" class="btn"><i class="fas fa-plus"></i> Criar Novo Tópico</a>
        <?php while($t = $topicos->fetch_assoc()): ?>
            <div class="card">
                <h3><a href="topico.php?id=<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['titulo']); ?></a></h3>
                <p>Por: <?php echo htmlspecialchars($t['nick']); ?> em <?php echo $t['data']; ?></p>
                <?php if($_SESSION['is_admin']): ?>
                    <a href="deletar.php?tipo=topico&id=<?php echo $t['id']; ?>&cat=<?php echo $id; ?>" class="btn delete-btn" onclick="return confirm('Tem certeza que deseja deletar?');"><i class="fas fa-trash"></i> Deletar</a>
                <?php endif; ?>
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