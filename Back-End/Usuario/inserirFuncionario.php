<?php
// // Conexão com o banco de dados
include('../conexao.php');

// Verifica a conexão
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

// Dados do novo usuário
$nomeUsu = $_POST['nome'];  // Nome
$senhaUsu = $_POST['senha']; // Senha (deve ser tratada com hash)
$confirmarSenha = $_POST['confirmarSenha'];
$nivelAcessoUsu = $_POST['acesso']; // Nível de acesso

if($nivelAcessoUsu == "simples"){
    $nivelAcessoUsu = 1;
}
elseif ($nivelAcessoUsu == "medio"){
    $nivelAcessoUsu = 2;
}
elseif ($nivelAcessoUsu == "completo"){
    $nivelAcessoUsu = 3;
}
echo $nivelAcessoUsu;

if($senhaUsu != $confirmarSenha){
    echo'SENHAS DIFERENTES!';
}
else{
    // Hash da senha
    $senhaHash = password_hash($senhaUsu, PASSWORD_DEFAULT);

    // Prepara e executa a consulta SQL usando prepared statements
    $consulta = $conexao->prepare("INSERT INTO tbUsuario(nomeUsu, senhaUsu, nivelAcessoUsu) VALUES(?, ?, ?)");
    $consulta->bind_param("ssi", $nomeUsu, $senhaHash, $nivelAcessoUsu);

    if ($consulta->execute()) {
        echo "Usuário cadastrado com sucesso!!!";
        header("Location: ../../Paginas/Funcionarios.php"); // Redireciona para a página principal
    } else {
        echo "Erro na consulta: " . $consulta->error;
        header("Location: ../../Paginas/CadastroDeUsuario.php"); // Redireciona para a página principal
    }
    // Fecha a conexão após o uso
    $conexao->close();
}
?>
