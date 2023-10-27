<?php
// Conexão com o banco de dados
include('../conexao.php');

// Recupere os valores do formulário
$marcaProd = $_POST['marca']; // Nome dos campos deve corresponder aos atributos 'name' do formulário
$modeloProd = $_POST['modelo'];
$corProd = $_POST['cor'];
$armazenamentoProd = (int)$_POST['armazenamento'];
$bateriaProd = (int)$_POST['bateria'];
$imeiProd = $_POST['imei'];
$memoriaRamProd = (int)$_POST['memoriaRam'];
$nomeAntigoDono = $_POST['nomeAntigoDono'];
$telefoneAntigoDono = $_POST['telefoneAntigoDono'];
$cpfAntigoDono = $_POST['cpfAntigoDono'];
$valorCompraProd = (float)$_POST['valorCompra'];
$observacaoProd = $_POST['observacao'];
$aquisicaoProd = $_POST['aquisicao'];
$dataProd = $_POST['data'];
$fkCodAntigoDono = (int)$_POST['fkCodAntigoDono'];

$caminhoImagem = $_FILES['termo']['tmp_name']; // Usando o nome do campo do arquivo do formulário
$imagem = file_get_contents($caminhoImagem);


$consulta = $conexao->prepare("SELECT pkCodAntigoDono from tbAntigoDono where cpfAntigoDono = '$cpfAntigoDono'");
$resultado = $conexao->query($consulta);

if (!$resultado || $resultado->num_rows === 0 && $nomeAntigoDono != null) {
    $consulta = $conexao->prepare("INSERT INTO tbAntigoDono(nomeAntigoDono, telefoneAntigoDono, cpfAntigoDono) VALUES(?, ?, ?);");
    $consulta->bind_param("sss", $nomeAntigoDono, $telefoneAntigoDono, $cpfAntigoDono);
    if ($consulta->execute()) {
        $fkCodAntigoDono = $conexao->insert_id;

        $consulta = $conexao->prepare("INSERT INTO tbProdutos (marcaProd, modeloProd, corProd, armazenamentoProd, bateriaProd, imeiProd, memoriaRamProd, valorCompraProd, observacaoProd, aquisicaoProd, dataProd, CompraVendaProd, fkCodAntigoDono) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $consulta->bind_param("sssiisidsissi", $marcaProd, $modeloProd, $corProd, $armazenamentoProd, $bateriaProd, $imeiProd, $memoriaRamProd, $valorCompraProd, $observacaoProd, $aquisicaoProd, $dataProd, $imagem, $fkCodAntigoDono);

        if ($consulta->execute()) {

            $fkCodProd = $conexao->insert_id;

            $caminhoImagens = $_FILES['imagem']['tmp_name'];
            $imagens = array();

            foreach ($caminhoImagens as $caminhoImagem) {
                $imagem = file_get_contents($caminhoImagem);
                $imagens[] = $imagem;
            }

            foreach ($imagens as $imagem) {
                // Inserir a imagem no banco de dados para o mesmo produto
                $consultaImagem = $conexao->prepare("INSERT INTO tbImagemProduto (imagem, fkCodProd) VALUES (?, ?)");
                $consultaImagem->bind_param("si", $imagem, $fkCodProd);
                
                if ($consultaImagem->execute()) {
                    echo "Produto cadastrado com sucesso!!!";
                    header("Location: ../../Paginas/PaginaPrincipal.php"); // Redireciona para a página principal
                } else {
                    echo "Erro na consulta de imagem: " . $consultaImagem->error;
                }
            }
        } else {
            echo "Erro na consulta: " . $consulta->error;
        }
    } else {
        echo "Erro na consulta: " . $consulta->error;
    }
}
else{
    echo "ERRO";
}

// Fecha a conexão após o uso
$conexao->close();
?>
