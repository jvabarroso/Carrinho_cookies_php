<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Conectar ao banco de dados
$connect = mysqli_connect("127.0.0.1", "root", "", "loja");
mysqli_set_charset($connect, "UTF8");

// Verifica se a conexão foi bem-sucedida
if (!$connect) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Adicionar produtos ao carrinho
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inicialize o carrinho se ele ainda não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Buscar produtos disponíveis
    $query = mysqli_query($connect, "SELECT id_img, caminho FROM imagens");
    
    while ($row = mysqli_fetch_assoc($query)) {
        $produtoId = $row['id_img'];
        if (isset($_POST[$produtoId]) && isset($_POST["quantidade_$produtoId"])) {
            $quantidade = (int)$_POST["quantidade_$produtoId"];
            if ($quantidade > 0) {
                // Incrementa a quantidade do produto no carrinho
                if (isset($_SESSION['carrinho'][$produtoId])) {
                    $_SESSION['carrinho'][$produtoId]['quantidade'] += $quantidade;
                } else {
                    $_SESSION['carrinho'][$produtoId] = [
                        'caminho' => $row['caminho'],
                        'quantidade' => $quantidade,
                    ];
                }
            }
        }
    }
    
    header("Location: compras.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Loja de Camisas</title>
</head>
<body>
    <div class="container">
        <h2>Bem-vindo, <?php echo $_SESSION['user']; ?>!</h2>
        <a href="logout.php" style="color:#ff0000">Sair</a>

        <!-- Formulário para adicionar produtos ao carrinho -->
        <form action="compras.php" method="POST">
            <h3>Produtos Disponíveis</h3>
            <div class="produto-grid">
                <?php
                // Buscar os caminhos das imagens para exibir os produtos
                $query = mysqli_query($connect, "SELECT id_img, caminho FROM imagens");
                
                if (mysqli_num_rows($query) > 0) { // Verifica se há produtos disponíveis
                    while ($row = mysqli_fetch_assoc($query)) {
                        $produtoId = $row['id_img'];
                        $caminhoImagem = $row['caminho'];
                        echo "
                        <div class='produto'>
                            <img src='$caminhoImagem' alt='Produto $produtoId'>
                            <label>Camisa $produtoId</label><br>
                            <input type='number' name='quantidade_$produtoId' min='1' value='1' style='width: 50px;'> <!-- Campo para quantidade -->
                            <input type='checkbox' name='$produtoId'>
                        </div>";
                    }
                } else {
                    echo "<p>Nenhum produto disponível.</p>"; // Mensagem caso não haja produtos
                }
                ?>
            </div>
            <button type="submit">Adicionar ao Carrinho</button><br>
            <div>
                <button type="button" onclick="window.location.href='carrinho.php';">Ver Carrinho</button>
            </div>
        </form>
    </div>
</body>
</html>