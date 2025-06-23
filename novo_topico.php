<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
include("conexao.php");

$cat_id = (int)$_GET['cat'];

if(isset($_POST['titulo']) && isset($_POST['conteudo'])){
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $conteudo = mysqli_real_escape_string($conn, $_POST['conteudo']);
    $autor = $_SESSION['user_id'];

    $sql = "INSERT INTO topicos (titulo, conteudo, categoria_id, autor_id) 
            VALUES ('$titulo', '$conteudo', $cat_id, $autor)";

    if($conn->query($sql)){
        header("Location: categoria.php?id=".$cat_id);
    } else {
        echo "<p class='error'>Erro: ".$conn->error."</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Tópico - Meu Fórum</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-plus"></i> Novo Tópico</h1>
            <div class="profile-menu">
                <button class="btn profile-btn"><i class="fas fa-user"></i> Perfil</button>
                <div class="profile-dropdown">
                    <img src="https://minotar.net/avatar/<?php echo htmlspecialchars($_SESSION['minecraft_nick']); ?>/100" alt="Skin">
                    <p><?php echo htmlspecialchars($_SESSION['user_nick']); ?></p>
                    <a href="logout.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </div>
        </div>
        <form method="post" class="card">
            <input type="text" name="titulo" placeholder="Título do tópico" required>
            <textarea name="conteudo" rows="5" placeholder="Conteúdo do tópico..." required></textarea>
            <button type="submit" class="btn">Criar</button>
        </form>
        <a href="categoria.php?id=<?php echo $cat_id; ?>" class="btn"><i class="fas fa-arrow-left"></i> Voltar</a>
    </div>
    <script>
        document.querySelector('.profile-btn').addEventListener('click', () => {
            document.querySelector('.profile-dropdown').classList.toggle('show');
        });
    </script>
</body>
</html>