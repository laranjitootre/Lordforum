<?php
$conn = new mysqli("localhost", "root", "", "forum");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4"); // Suporte a caracteres especiais
?>