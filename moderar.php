<?php
include "conexao.php";

// Atualizar recado
if(isset($_POST['atualiza'])){
    $idatualiza = intval($_POST['id']);
    $nome       = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email      = mysqli_real_escape_string($conexao, $_POST['email']);
    $msg        = mysqli_real_escape_string($conexao, $_POST['msg']);

    $sql = "UPDATE recados SET nome='$nome', email='$email', mensagem='$msg' WHERE id=$idatualiza";
    mysqli_query($conexao, $sql) or die("Erro ao atualizar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}

// Excluir recado
if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
    $id = intval($_GET['id']);
    mysqli_query($conexao, "DELETE FROM recados WHERE id=$id") or die("Erro ao deletar: " . mysqli_error($conexao));
    header("Location: moderar.php");
    exit;
}

// Editar recado
$editar_id = isset($_GET['acao']) && $_GET['acao'] == 'editar' ? intval($_GET['id']) : 0;
$recado_editar = null;
if($editar_id){
    $res = mysqli_query($conexao, "SELECT * FROM recados WHERE id=$editar_id");
    $recado_editar = mysqli_fetch_assoc($res);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Moderar pedidos</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="main">
<div id="geral">
<div id="header">
    <h1>Mural de pedidos</h1>
</div>

<?php if($recado_editar): ?>
<div id="formulario_mural">
<form method="post">
    <label>Nome:</label>
    <input type="text" name="nome" value="<?php echo htmlspecialchars($recado_editar['nome']); ?>"/><br/>
    <label>Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($recado_editar['email']); ?>"/><br/>
    <label>Mensagem:</label>
    <textarea name="msg"><?php echo htmlspecialchars($recado_editar['mensagem']); ?></textarea><br/>
    <input type="hidden" name="id" value="<?php echo $recado_editar['id']; ?>"/>
    <input type="submit" name="atualiza" value="Modificar Recado" class="btn"/>
</form>
</div>
<?php endif; ?>

<?php
$seleciona = mysqli_query($conexao, "SELECT * FROM recados ORDER BY id DESC");
if(mysqli_num_rows($seleciona) <= 0):
?>
    <p>Nenhum pedido no mural!</p>
<?php else: ?>
    <?php while($res = mysqli_fetch_assoc($seleciona)): ?>
        <ul class="recados">
            <li class="header">
                <span class="nome-usuario"><?= htmlspecialchars($res['nome']) ?></span>
                <span class="id-msg">ID:<?= $res['id'] ?></span>
                <br/>
                <span class="email-usuario"><?= htmlspecialchars($res['email']) ?></span>
            </li>
            <li class="mensagem">
                <em><?= class="email-usuario" nl2br(htmlspecialchars($res['mensagem'])) ?></em>
            </li>
        </ul>
    <?php endwhile; ?>
<?php endif; ?>


<div id="footer">
</div>
</div>
</div>
</body>
</html>
