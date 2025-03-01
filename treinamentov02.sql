-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/03/2025 às 18:18
-- Versão do servidor: 10.4.17-MariaDB
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `treinamento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id_carrinho` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho_item`
--

CREATE TABLE `carrinho_item` (
  `id_carrinho_item` int(11) NOT NULL,
  `id_carrinho` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cupom`
--

CREATE TABLE `cupom` (
  `id_cupom` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `desconto` double DEFAULT NULL,
  `valor_minimo` double DEFAULT NULL,
  `tipo` enum('%','$') DEFAULT NULL,
  `estoque` int(11) NOT NULL,
  `usados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `id_usuario_loja` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `custo` double NOT NULL,
  `preco` double NOT NULL,
  `estoque` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `id_usuario_loja`, `nome`, `custo`, `preco`, `estoque`, `descricao`, `categoria`, `quantidade`) VALUES
(17, 9, '2', 0, 2, NULL, '2', '2', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `ultimo_acesso` datetime DEFAULT NULL,
  `tipo_acesso` int(11) DEFAULT NULL,
  `tentativas_falhas_login` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(7, 'Nome do Usuário', 'email@dominio.com', 'senha'),
(8, 'Nome do Usuário', 'email@example.com', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id_venda` int(11) NOT NULL,
  `id_carrinho` int(11) NOT NULL,
  `id_cupom` int(11) DEFAULT NULL,
  `data_venda` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `id_usuario_loja` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id_carrinho`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `carrinho_item`
--
ALTER TABLE `carrinho_item`
  ADD PRIMARY KEY (`id_carrinho_item`),
  ADD KEY `id_carrinho` (`id_carrinho`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices de tabela `cupom`
--
ALTER TABLE `cupom`
  ADD PRIMARY KEY (`id_cupom`),
  ADD KEY `idx_cupom_nome_estoque_usados_valor_minimo` (`nome`,`estoque`,`usados`,`valor_minimo`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `idx_produto_nome` (`nome`),
  ADD KEY `idx_produto_nome_preco` (`nome`,`preco`),
  ADD KEY `idx_produto_nome_preco_estoque` (`nome`,`preco`,`estoque`),
  ADD KEY `idx_produto_nome_loja` (`nome`,`id_usuario_loja`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_usuario_email` (`email`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id_venda`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_loja` (`id_usuario_loja`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id_carrinho` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `carrinho_item`
--
ALTER TABLE `carrinho_item`
  MODIFY `id_carrinho_item` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cupom`
--
ALTER TABLE `cupom`
  MODIFY `id_cupom` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id_venda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `carrinho_item`
--
ALTER TABLE `carrinho_item`
  ADD CONSTRAINT `carrinho_item_ibfk_1` FOREIGN KEY (`id_carrinho`) REFERENCES `carrinho` (`id_carrinho`),
  ADD CONSTRAINT `carrinho_item_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_usuario_loja`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
