<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
include("conexao.php");

$id = (int)$_GET['id'];
$topico = $conn->query("SELECT t.*, u.nick FROM topicos t JOIN users u ON t.autor_id = u.id WHERE t.id = $id")->fetch_assoc();
$respostas = $conn->query("SELECT r.*, u.nick FROM respostas r JOIN users u ON r.autor_id = u.id WHERE r.topico_id = $id ORDER BY data ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($topico['titulo']); ?> - Meu Fórum</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-file-alt"></i> <?php echo htmlspecialchars($topico['titulo']); ?></h1>
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
            <p><?php echo nl2br(htmlspecialchars($topico['conteudo'])); ?></p>
            <p><small>Por: <?php echo htmlspecialchars($topico['nick']); ?> em <?php echo $topico['data']; ?></small></p>
            <?php if($_SESSION['is_admin']): ?>
                <a href="deletar.php?tipo=topico&id=<?php echo $topico['id']; ?>&cat=<?php echo $topico['categoria_id']; ?>" class="btn delete-btn" onclick="return confirm('Tem certeza que deseja deletar?');"><i class="fas fa-trash"></i> Deletar</a>
            <?php endif; ?>
        </div>
        <h2>Respostas:</h2>
        <?php while($r = $respostas->fetch_assoc()): ?>
            <div class="card">
                <p><?php echo nl2br(htmlspecialchars($r['conteudo'])); ?></p>
                <p><small>Por: <?php echo htmlspecialchars($r['nick']); ?> em <?php echo $r['data']; ?></small></p>
                <?php if($_SESSION['is_admin']): ?>
                    <a href="deletar.php?tipo=resposta&id=<?php echo $r['id']; ?>&topico=<?php echo $id; ?>" class="btn delete-btn" onclick="return confirm('Tem certeza que deseja deletar?');"><i class="fas fa-trash"></i> Deletar</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
        <?php if($_SESSION['is_admin']): ?>
            <h3><i class="fas fa-comment"></i> Responder:</h3>
            <form method="post" action="responder.php" class="card">
                <textarea name="conteudo" rows="4" placeholder="Escreva sua resposta..." required></textarea>
                <input type="hidden" name="topico" value="<?php echo $id; ?>">
                <button type="submit" class="btn">Enviar</button>
            </form>
        <?php else: ?>
            <p class="error">Apenas administradores podem responder.</p>
        <?php endif; ?>
        <a href="forum.php" class="btn"><i class="fas fa-arrow-left"></i> Voltar</a>
    </div>
    <script>
        document.querySelector('.profile-btn').addEventListener('click', () => {
            document.querySelector('.profile-dropdown').classList.toggle('show');
        });
    </script>
</body>
</html>