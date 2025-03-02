<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('Produtos_Price_model');
        $this->load->model('Vendas_model');
        $this->load->model('Cliente_model');
    }

    public function clientePaginaPrincipal()
    {
        $this->load->library('session');
        $dados['produtos'] = $this->Produtos_Price_model->get_produtos();
        echo "<pre>";
        print_r($dados['produtos']);
        echo "</pre>";
        exit;
        $dados['title'] = 'Página Principal do Cliente';
        $this->template->load('clientePaginaPrincipal', $dados);
    }

    public function pagina_principal($id_cliente = null)
    {
        $dados['cliente'] = $this->Cliente_model->get_cliente($id_cliente);
        $dados['produtos'] = $this->Produtos_Price_model->get_produtos();
        $dados['title'] = 'Página Principal do Cliente';
        $this->template->load('clientePaginaPrincipal', $dados);
    }

    public function carrinho()
    {
        $carrinho = $this->session->userdata('carrinho');
        $dados = [
            'title' => 'Carrinho de Compras',
            'carrinho' => $carrinho
        ];
        $this->template->load('clienteCarrinho', $dados);
    }

    public function adicionarAoCarrinho($id_produto)
    {
        $produto = $this->Produtos_Price_model->get_produtos_by_id($id_produto);

        if ($produto && $produto->estoque > 0) {
            $carrinho = $this->session->userdata('carrinho') ?? [];
            $quantidade = $this->input->post('quantidade') ?? 1;

            if ($quantidade <= $produto->estoque) {
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

    public function confirmarCompra()
    {
        $this->Loja->confirmarCompra();
    }

    public function adicionar()
    {
        $dados = array(
            'nome' => $this->input->post('nome'),
            'email' => $this->input->post('email')
        );

        if ($this->Cliente_model->insert_cliente($dados)) {
            redirect('cliente/lista');
        } else {
            echo "Erro ao adicionar o cliente.";
        }
    }

    public function editar($id_cliente)
    {
        $dados = array(
            'nome' => $this->input->post('nome'),
            'email' => $this->input->post('email')
        );

        if ($this->Cliente_model->update_cliente($id_cliente, $dados)) {
            redirect('cliente/pagina_principal/' . $id_cliente);
        } else {
            echo "Erro ao atualizar os dados.";
        }
    }

    public function excluir($id_cliente)
    {
        if ($this->Cliente_model->delete_cliente($id_cliente)) {
            redirect('cliente/lista');
        } else {
            echo "Erro ao excluir o cliente.";
        }
    }
}