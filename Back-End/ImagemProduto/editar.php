<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Defina as informações de atualização
$pkCodImagemProduto = 1; // Codigo Imagem do produto 
$nomeImagem = "NOVO NOME"; // Atributo a ser atualizado

// Prepara e executa a consulta SQL para atualizar o usuário
$consulta = "UPDATE tbImagemProduto SET nomeImagem = ? WHERE pkCodImagemProduto >= ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("si", $nomeImagem, $pkCodImagemProduto);

if ($stmt->execute()) {
    echo "Registro atualizado com sucesso.";
} else {
    echo "Erro na atualização: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
