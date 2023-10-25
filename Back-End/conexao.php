<?php
// Conexão com o banco de dados
$conexao = new mysqli("tronicdb.c1z34cllhcs6.us-east-2.rds.amazonaws.com", "admin", "SenhaTronic100", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
?>