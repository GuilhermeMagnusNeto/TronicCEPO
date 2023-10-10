<?php
// Conexão com o banco de dados
$conexao = new mysqli("localhost", "root", "teste123", "tronic");

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Prepara e executa a consulta SQL para selecionar todos os usuários
$consulta = "SELECT * FROM tbUsuario";
$resultado = $conexao->query($consulta);

// Verifica se a consulta foi executada com sucesso
if ($resultado) {
    // Loop para exibir os resultados
    while ($linha = $resultado->fetch_assoc()) {
        echo "ID: " . $linha["pkCodUsu"] . " - Nome: " . $linha["nomeUsu"] . " - Senha: " . $linha["senhaUsu"] . " - Nivel de Acesso: " . $linha["nivelAcessoUsu"] . "<br>";
    }
} else {
    echo "Erro na consulta: " . $conexao->error;
}

// Fecha a conexão após o uso
$conexao->close();
?>
