<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Defina as informações de atualização
$pkCodUsu = 1; // O pkCodUsu do usuário que você deseja atualizar
$novoNivelAcessoUsu = 3; // O novo atributo que você deseja definir

// Prepara e executa a consulta SQL para atualizar o usuário
$consulta = "UPDATE tbUsuario SET nivelAcessoUsu = ? WHERE pkCodUsu = ?";
$stmt = $conexao->prepare($consulta);
$stmt->bind_param("ii", $novoNivelAcessoUsu, $pkCodUsu);

if ($stmt->execute()) {
    echo "Registro atualizado com sucesso.";
} else {
    echo "Erro na atualização: " . $stmt->error;
}

// Fecha o statement e a conexão após o uso
$stmt->close();
$conexao->close();
?>
