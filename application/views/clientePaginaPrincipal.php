<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        /* CSS para melhorar a aparência */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $cliente->nome; ?>!</h1>
        <p>Email: <?php echo $cliente->email; ?></p>

        <h2>Produtos Disponíveis</h2>

        <?php if (!empty($produtos)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?php echo $produto['nome']; ?></td>
                            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo $produto['estoque'] ? $produto['estoque'] : 'Indisponível'; ?></td>
                            <td><?php echo $produto['descricao']; ?></td>
                            <td><?php echo $produto['categoria']; ?></td>
                            <td><?php echo $produto['quantidade']; ?></td>
                            <td>
                                <a href="<?php echo site_url('cliente/adicionarAoCarrinho/' . $produto['id_produto']); ?>" class="btn">Adicionar ao Carrinho</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há produtos disponíveis no momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>
