<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('Produtos_Price_model');
        $this->load->model('Vendas_model');
    }

    public function index()
    {
        // Exibe a página principal do cliente
        $dados = [
            'title' => 'Página Cliente'
        ];
        $this->template->load('clientePaginaPrincipal', $dados);
    }

    // Exibe o carrinho de compras
    public function carrinho()
    {
        $carrinho = $this->session->userdata('carrinho');
        $dados = [
            'title' => 'Carrinho de Compras',
            'carrinho' => $carrinho
        ];
        $this->template->load('clienteCarrinho', $dados);
    }

    // Adiciona um produto ao carrinho
    public function adicionarAoCarrinho($id_produto)
    {
        $produto = $this->Produtos_Price_model->get_produtos_by_id($id_produto);

        if ($produto && $produto->estoque > 0) {
            $carrinho = $this->session->userdata('carrinho') ?? [];
            $quantidade = $this->input->post('quantidade') ?? 1;

            if ($quantidade <= $produto->estoque) {
                // Adiciona ao carrinho
                $carrinho[] = [
                    'id_produto' => $produto->id_produto,
                    'nome' => $produto->nome,
                    'preco' => $produto->preco,
                    'quantidade' => $quantidade
                ];
                $this->session->set_userdata('carrinho', $carrinho);
                $this->session->set_flashdata('success', 'Produto adicionado ao carrinho!');
            } else {
                $this->session->set_flashdata('error', 'Quantidade maior que o estoque disponível!');
            }
        }
        redirect('cliente');
    }

    // Editar a quantidade de produtos no carrinho
    public function editarCarrinho()
    {
        $id_produto = $this->input->post('id_produto');
        $quantidade = $this->input->post('quantidade');
        $carrinho = $this->session->userdata('carrinho');

        foreach ($carrinho as &$produto) {
            if ($produto['id_produto'] == $id_produto) {
                $produto['quantidade'] = $quantidade;
            }
        }

        $this->session->set_userdata('carrinho', $carrinho);
        $this->session->set_flashdata('success', 'Carrinho atualizado!');
        redirect('cliente/carrinho');
    }

    // Remover produto do carrinho
    public function removerDoCarrinho($id_produto)
    {
        $carrinho = $this->session->userdata('carrinho');
        $carrinho = array_filter($carrinho, function($produto) use ($id_produto) {
            return $produto['id_produto'] != $id_produto;
        });

        $this->session->set_userdata('carrinho', $carrinho);
        $this->session->set_flashdata('success', 'Produto removido do carrinho!');
        redirect('cliente/carrinho');
    }

    // Confirmar compra
    public function confirmarCompra()
    {
        $this->Loja->confirmarCompra();
    }

    // Página principal do cliente - agora exibindo os produtos disponíveis
	public function clientePaginaPrincipal()
	{
		$this->load->library('session');

		// Obtém os produtos do banco de dados
		$dados['produtos'] = $this->Produtos_Price_model->get_produtos();

		// Adiciona uma depuração para verificar se os produtos estão sendo recuperados corretamente
		echo "<pre>";
		print_r($dados['produtos']);  // Exibe os produtos retornados
		echo "</pre>";
		exit; // Para garantir que a execução pare aqui e possamos ver os resultados

		// Define o título da página
		$dados['title'] = 'Página Principal do Cliente';

		// Carrega a view e envia os produtos
		$this->template->load('clientePaginaPrincipal', $dados);
	}

}