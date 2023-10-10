<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Prepara e executa a consulta SQL para selecionar todos os produtos
$consulta = "SELECT * FROM tbProdutos";
$resultado = $conexao->query($consulta);

// Verifica se a consulta foi executada com sucesso
if ($resultado) {
    // Loop para exibir os resultados
    while ($linha = $resultado->fetch_assoc()) {
        // Configura o cabeçalho antes de exibir a imagem
        header("Content-Type: image/png"); // Substitua pelo tipo de imagem correto, se necessário

        // Exibir a imagem
        echo $linha["CompraVendaProd"];

        // Depois de exibir a imagem, você pode continuar com as outras informações
        echo "ID: " . $linha["pkCodProd"] . "\n";
        echo "Marca: " . $linha["marcaProd"] . "\n";
        echo "Modelo: " . $linha["modeloProd"] . "\n";
        echo "Cor: " . $linha["corProd"] . "\n";
        echo "Armazenamento: " . $linha["armazenamentoProd"] . "\n";
        echo "Bateria: " . $linha["bateriaProd"] . "\n";
        echo "IMEI: " . $linha["imeiProd"] . "\n";
        echo "RAM: " . $linha["memoriaRamProd"] . "\n";
        echo "Valor de Compra: " . $linha["valorCompraProd"] . "\n";
        echo "Observação: " . $linha["observacaoProd"] . "\n";
        echo "Aquisição: " . $linha["aquisicaoProd"] . "\n";
        echo "Data: " . $linha["dataProd"] . "\n";
        echo "Imagem: ". $linha["CompraVendaProd"] . "\n";
        echo "Antigo Dono: " . $linha["fkCodAntigoDono"] . "\n";
    }
} else {
    echo "Erro na consulta: " . $conexao->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
