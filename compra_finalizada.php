<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Não limpar o carrinho aqui para manter os produtos após a finalização da compra.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Compra Finalizada</title>
</head>
<body>
    <div class="container">
        <h2>Compra Finalizada com Sucesso!</h2>
        <p>Obrigado pela sua compra, <?php echo $_SESSION['user']; ?>! Sua ordem foi processada e você receberá uma mensagem de confirmação em breve.</p>

        <!-- Botões para voltar às compras ou ver o carrinho -->
        <div class="action-buttons">
            <button type="button" onclick="window.location.href='compras.php';">Voltar para as Compras</button>
            <button type="button" onclick="window.location.href='carrinho.php';">Ver Carrinho</button>
        </div>
    </div>
</body>
</html>