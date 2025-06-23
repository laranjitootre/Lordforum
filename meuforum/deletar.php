<?php
session_start();
if(!isset($_SESSION['user_id']) || !$_SESSION['is_admin']){ header("Location: index.php"); exit(); }
include("conexao.php");

$tipo = $_GET['tipo'];
$id = (int)$_GET['id'];

if($tipo === 'topico'){
    $cat = (int)$_GET['cat'];
    $conn->query("DELETE FROM respostas WHERE topico_id = $id");
    $conn->query("DELETE FROM topicos WHERE id = $id");
    header("Location: categoria.php?id=$cat");
} elseif($tipo === 'resposta'){
    $topico = (int)$_GET['topico'];
    $conn->query("DELETE FROM respostas WHERE id = $id");
    header("Location: topico.php?id=$topico");
}
exit();
?>