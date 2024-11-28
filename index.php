<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Login</title>
</head>
<body>
    <?php session_start(); ?>
    <?php if (isset($_SESSION['login_error'])) { ?>
        <p style="color:red;"><?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?></p>
    <?php } ?>
    <form action="login.php" method="POST">
    <h2>Login</h2>
        <label for="input_usuario">Usuário:</label>
        <input type="text" id="input_usuario" name="input_usuario" required>
        <br>
        <label for="input_senha">Senha:</label>
        <input type="password" id="input_senha" name="input_senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>