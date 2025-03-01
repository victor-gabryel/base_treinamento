<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>
<style>
    /* Resetando margens e preenchimento */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Estilo geral do corpo da página */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        min-height: 100vh;
        padding: 20px;
    }

    /* Título principal */
    h1 {
        color: #4CAF50;
        margin-bottom: 20px;
        font-size: 2.5em;
        text-align: center;
    }

    /* Subtítulos */
    h2 {
        color: #555;
        margin-top: 20px;
        font-size: 1.8em;
        text-align: center; /* Adicionada a centralização */
    }


    /* Estilo do formulário */
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        width: 100%;
        max-width: 500px;
        display: flex;
        flex-direction: column;
    }

    /* Estilo dos campos de entrada e textarea */
    input, textarea {
        width: 100%;
        padding: 12px;
        margin-top: 8px;
        border-radius: 4px;
        border: 1px solid #ddd;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    /* Estilo do campo textarea */
    textarea {
        height: 100px;
        resize: vertical;
    }

    /* Foco nos campos de entrada */
    input:focus, textarea:focus {
        border-color: #4CAF50;
        outline: none;
    }

    /* Estilo dos botões */
    button {
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 15px;
    }

    /* Efeito de hover nos botões */
    button:hover {
        background-color: #45a049;
    }

    /* Lista de produtos e vendas */
    ul {
        list-style-type: none;
        margin-top: 15px;
        padding: 0;
    }

    li {
        background-color: #f4f4f4;
        padding: 12px;
        margin: 5px 0;
        border-radius: 4px;
        font-size: 16px;
    }

    /* Estilo das mensagens (produtos e vendas) */
    p {
        color: #777;
        font-size: 16px;
    }

    /* Estilo dos links */
    a {
        text-decoration: none;
        color: #4CAF50;
        font-weight: bold;
    }

    a:hover {
        color: #388E3C;
    }

</style>
<body>
    <h1>Bem-vindo à sua loja!</h1>

    <h2>Cadastrar Produto</h2>
    
    <form action="<?php echo site_url('loja/salvarProduto'); ?>" method="POST">
        <label for="nome">Nome do Produto:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="preco">Preço:</label>
        <input type="number" name="preco" id="preco" step="0.01" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao" required></textarea>

        <label for="categoria">Categoria:</label>
        <input type="text" name="categoria" id="categoria" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" required>

        <button type="submit">Cadastrar</button>
    </form>

    <h2>Produtos da Loja</h2>
    <?php if (!empty($produtos)): ?>
        <ul>
            <?php foreach ($produtos as $produto): ?>
                <li>
                    <?php echo $produto['nome']; ?> - R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?> - Quantidade: <?php echo $produto['quantidade']; ?>
                    <a href="<?php echo site_url('loja/deletarProduto/' . $produto['id_produto']); ?>" onclick="return confirm('Você tem certeza que deseja excluir este produto?')">Excluir</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Não há produtos disponíveis.</p>
    <?php endif; ?>

    <h2>Vendas Recentes</h2>
    <form action="<?php echo site_url('loja/vendas'); ?>" method="POST">
        <label for="data_inicio">Data Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" required>

        <label for="data_fim">Data Fim:</label>
        <input type="date" name="data_fim" id="data_fim" required>

        <button type="submit">Filtrar</button>
    </form>

    <?php if (!empty($vendas)): ?>
        <ul>
            <?php foreach ($vendas as $venda): ?>
                <li>Venda ID: <?php echo $venda['id_venda']; ?> - Data: <?php echo date("d/m/Y", strtotime($venda['data'])); ?> - Total: R$ <?php echo number_format($venda['total'], 2, ',', '.'); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Não há vendas recentes.</p>
    <?php endif; ?>
</body>
</html>
