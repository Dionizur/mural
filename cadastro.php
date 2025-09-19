<?php
session_start();
include "conexao.php"; // conexão MySQL

if(isset($_POST['cadastrar'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];
    $senhaConfirm = $_POST['senha_confirm'];

    if($senha !== $senhaConfirm){
        $erro = "As senhas não coincidem!";
    } else {
        // Verifica se o email já existe na tabela login
        $query = mysqli_query($conexao, "SELECT * FROM login WHERE email='$email'");
        if(mysqli_num_rows($query) > 0){
            $erro = "Este email já está cadastrado!";
        } else {
            // Criptografa a senha
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            mysqli_query($conexao, "INSERT INTO login (nome, email, senha) VALUES ('$nome', '$email', '$hash')") 
                or die("Erro ao cadastrar: " . mysqli_error($conexao));
            $_SESSION['usuario'] = $email;
            header("Location: mural.php"); // redireciona após cadastro
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Cadastro</h1>
<?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post">
    <label>Nome:</label>
    <input type="text" name="nome" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Senha:</label>
    <input type="password" name="senha" required>

    <label>Confirme a senha:</label>
    <input type="password" name="senha_confirm" required>

    <input type="submit" name="cadastrar" value="Cadastrar">
</form>
<p>Já tem uma conta? <a href="login.php">Login</a></p>
</body>
</html>
