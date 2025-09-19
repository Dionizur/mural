<?php
session_start();
include "conexao.php";

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = $_POST['senha'];

    $query = mysqli_query($conexao, "SELECT * FROM login WHERE email='$email'");
    if(mysqli_num_rows($query) == 1){
        $usuario = mysqli_fetch_assoc($query);
        if(password_verify($senha, $usuario['senha'])){
            $_SESSION['usuario'] = $email;
            header("Location: mural.php"); // redireciona para mural
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Login</h1>
<?php if(isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<form method="post">
    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Senha:</label>
    <input type="password" name="senha" required>

    <input type="submit" name="login" value="Entrar">
</form>
<p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
</body>
</html>
