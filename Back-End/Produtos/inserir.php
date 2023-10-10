<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo produto
$marcaProd = "Apple";  // Marca
$modeloProd = "iPhone 15"; // Modelo
$corProd = "Preto"; // Cor
$armazenamentoProd = 256; //Armazenamento
$bateriaProd = 100; //Porcentagem Bateria
$imeiProd = "IMEI DO APARELHO"; //IMEI
$memoriaRamProd = 6; //Memoria RAM
$valorCompraProd = 8000.58; //Valor Compra
$observacaoProd = "Campo de observação"; //Observação
$aquisicaoProd = 1; // Forma de aquisição
$dataProd = date("Y-m-d", strtotime("2023-09-25")); //Data da Aquisição
$fkCodAntigoDono = 1; //Código do antigo dono

// Caminho para o arquivo de imagem
$caminhoImagem = '/Users/guilhermemagnus/Desktop/ProjetosVScode/TronicCEPO/Imagens/DIGITAL.png';

// Lê o conteúdo do arquivo de imagem
$imagem = file_get_contents($caminhoImagem);

// Prepara e executa a consulta SQL usando prepared statements
$consulta = $conexao->prepare("INSERT INTO tbProdutos (marcaProd, modeloProd, corProd, armazenamentoProd, bateriaProd, imeiProd, memoriaRamProd, 
valorCompraProd, observacaoProd, aquisicaoProd, dataProd, CompraVendaProd, fkCodAntigoDono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$consulta->bind_param("sssiisidssssi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $imeiProd, $memoriaRamProd, $valorCompraProd, 
$observacaoProd, $aquisicaoProd, $dataProd, $imagem, $fkCodAntigoDono);

if ($consulta->execute()) {
    echo "Produto cadastrado com sucesso!!!";
} else {
    echo "Erro na consulta: " . $consulta->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
