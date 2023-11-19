<?php
// Conexão com o banco de dados
include("../conexao.php");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo usuário
$pkCodUsu = $_POST['pkCodUsu']; // O pkCodUsu do usuário que você deseja atualizar
$nomeUsu = $_POST['nome'];  // Nome
$nivelAcessoUsu = $_POST['acesso']; // Nível de acesso
$cargoUsu = $_POST['cargo']; //Cargo

if($nivelAcessoUsu == "simples"){
    $nivelAcessoUsu = 1;
}
elseif ($nivelAcessoUsu == "medio"){
    $nivelAcessoUsu = 2;
}
elseif ($nivelAcessoUsu == "completo"){
    $nivelAcessoUsu = 3;
}

// Prepara e executa a consulta SQL para atualizar o usuário
$consulta = "UPDATE tbUsuario SET nivelAcessoUsu = ?, nomeUsu = ?, cargoUsu = ? WHERE pkCodUsu = ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("issi", $nivelAcessoUsu, $nomeUsu, $cargoUsu, $pkCodUsu);

if ($stmt->execute()) {
    echo "Registro atualizado com sucesso.";
    header("Location: ../../Paginas/Funcionarios.php");
} else {
    echo "Erro na atualização: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
