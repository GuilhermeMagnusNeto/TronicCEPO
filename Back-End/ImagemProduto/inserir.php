<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados da nova imagem
$nomeImagem = "NOME TESTE DA IMAGEM";  // Nome Imagem
// Caminho para a imagem
$caminho_da_imagem = '/Users/guilhermemagnus/Desktop/ProjetosVScode/TronicCEPO/Imagens/BannerHeader.jpeg';
// Lê o conteúdo da imagem em uma variável
$imagem = file_get_contents($caminho_da_imagem);
$fkCodProd = 2; // Codigo do produto relacionado

// Prepara e executa a consulta SQL usando prepared statements
$consulta = $conexao->prepare("INSERT INTO tbImagemProduto (nomeImagem, imagem, fkCodProd) VALUES (?, ?, ?)");
$consulta->bind_param("sss", $nomeImagem, $imagem, $fkCodProd);

if ($consulta->execute()) {
    echo "Imagem cadastrado com sucesso!!!";
} else {
    echo "Erro na consulta: " . $consulta->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
