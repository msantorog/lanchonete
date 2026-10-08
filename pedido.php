<?php
require 'conexao.php';
 
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    HEADER('Location: index.php');
    exit;
}
$codigo = filter_input(INPUT_POST, 'id_lanche',
FILTER_VALIDATE_INT);
$quantidade = filter_input(INPUT_POST, 'quantidade',
FILTER_VALIDATE_INT);
 
if(!$codigo || $codigo < 1) {
    exit('codigo do produto invalido.
    <a href="index.php">Voltar</a>|');
 
}
 
$sql = 'SELECT nome, preco_cliente FROM produto
where id_lanche = ? and ativo = 1';
$consulta = $conexao->prepare($sql);
$consulta->execute([$codigo]);
 
$produto = $consulta->fetch(PDO::FETCH_ASSOC);
 
if(!$produto) {
    exit('Produto nao encontrado ou inativo.
    <a href="index.php">Voltar</a>');
}
 
if ($produto['preco_cliente'] === null ||
$produto['preco_cliente'] < 0) {
    exit('produto sem preco definido.
    <a href="index.php">Voltar</a>');
}
$total = $produto['preco_cliente'] * $quantidade;
?>
 
 <!DOCTYPE html>
 <html lang="pt-BR">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link rel="stylesheet" href="estilo.css">
 </head>
 <body>
    <main class="container resumo">
        <h1>Resumo do pedido</h1>
        <p>Produto: <?php echo htmlspecialchars($produto['nome']
        , ENT_QUOTES, 'UTF-8') ?></p>
        <p>Quantidade: <?php echo $quantidade ?></p>
        <p>Preço unitário: R$ <?php echo number_format($produto['preco_cliente'], 2, ',', '.') ?></p>
        <p>Total: R$ <?php echo number_format($total, 2, ',', '.') ?></p>
        <p>total: R$ <?php echo number_format($total, 2, ',', '.') ?></p>
        <p><a href="index.php">Voltar ao cardápio</a></p>
    </main>
    
 </body>
 </html>