<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Verificar se há produtos no carrinho
$temProduto = !empty($_SESSION['carrinho']);

// Excluir todos os produtos de um tipo
if (isset($_GET['excluir_todos'])) {
    $produtoExcluirTodos = $_GET['excluir_todos'];
    if (isset($_SESSION['carrinho'][$produtoExcluirTodos])) {
        unset($_SESSION['carrinho'][$produtoExcluirTodos]); // Remove todos os itens do produto
    }
    header("Location: carrinho.php");
    exit();
}

// Excluir um produto
if (isset($_GET['excluir'])) {
    $produtoExcluir = $_GET['excluir'];
    if (isset($_SESSION['carrinho'][$produtoExcluir])) {
        // Decrementar a quantidade ou remover o item completamente
        if ($_SESSION['carrinho'][$produtoExcluir]['quantidade'] > 1) {
            $_SESSION['carrinho'][$produtoExcluir]['quantidade']--;
        } else {
            unset($_SESSION['carrinho'][$produtoExcluir]);
        }
    }
    header("Location: carrinho.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Seu Carrinho</title>
</head>
<body>
    <div class="container">
        <h2>Carrinho de Compras</h2>

        <div class="carrinho-container">
            <?php if ($temProduto): ?>
                <?php
                foreach ($_SESSION['carrinho'] as $produtoId => $produtoInfo) {
                    echo "
                    <div class='carrinho-item'>
                        <img src='{$produtoInfo['caminho']}' alt='Produto $produtoId'>
                        <span>Camisa $produtoId (Quantidade: {$produtoInfo['quantidade']})</span>
                        <div class='item-actions'>
                            <a href='?excluir=$produtoId'>Excluir 1</a>
                            <a href='?excluir_todos=$produtoId'>Excluir Todos</a>
                        </div>
                    </div>";
                }
                ?>
                <!-- Botão para finalizar a compra -->
                <form action="compra_finalizada.php" method="POST">
                    <button type="submit">Finalizar Compra</button>
                </form>
            <?php else: ?>
                <p>Carrinho vazio. Adicione produtos para finalizar a compra.</p>
                <button type="button" onclick="window.location.href='compras.php';">Voltar para as Compras</button>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>