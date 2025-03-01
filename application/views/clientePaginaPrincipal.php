<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        .produto-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .produto {
            border: 1px solid #ddd;
            padding: 10px;
            width: 200px;
            text-align: center;
        }
        .produto img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<h1>Produtos Disponíveis</h1>

<?php if (!empty($produtos)): ?>
    <ul>
        <?php foreach ($produtos as $produto): ?>
            <li>
                <strong><?php echo $produto['nome']; ?></strong><br>
                Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?><br>
                Estoque: <?php echo $produto['estoque']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Nenhum produto disponível.</p>
<?php endif; ?>




</body>
</html>
