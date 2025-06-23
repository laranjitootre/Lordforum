<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
if(!$_SESSION['is_admin']){ header("Location: topico.php?id=".(int)$_POST['topico']); exit(); }
include("conexao.php");

if(isset($_POST['conteudo']) && isset($_POST['topico'])){
    $conteudo = mysqli_real_escape_string($conn, $_POST['conteudo']);
    $topico = (int)$_POST['topico'];
    $autor = $_SESSION['user_id'];

    $sql = "INSERT INTO respostas (conteudo, topico_id, autor_id) 
            VALUES ('$conteudo', $topico, $autor)";

    if($conn->query($sql)){
        header("Location: topico.php?id=".$topico);
    } else {
        echo "Erro: ".$conn->error;
    }
}
?>