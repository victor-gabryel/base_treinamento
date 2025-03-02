<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('Produtos_Price_model');
        $this->load->model('Vendas_model');
        $this->load->model('Cliente_model');  // Adiciona o Cliente_model
    }

    // Página principal do cliente
    public function clientePaginaPrincipal()
    {
        $this->load->library('session');

        // Obtém os produtos do banco de dados
        $dados['produtos'] = $this->Produtos_Price_model->get_produtos();

        // Exibe os produtos para depuração (remova isso em produção)
        echo "<pre>";
        print_r($dados['produtos']);  // Exibe os produtos retornados
        echo "</pre>";
        exit; // Para garantir que a execução pare aqui

        // Define o título da página
        $dados['title'] = 'Página Principal do Cliente';

        // Carrega a view e envia os produtos
        $this->template->load('clientePaginaPrincipal', $dados);
    }

    // Página principal do cliente com os dados do cliente
    public function pagina_principal($id_cliente = null)
    {
        // Carregar os dados do cliente
        $dados['cliente'] = $this->Cliente_model->get_cliente($id_cliente);

        // Carregar todos os produtos disponíveis
        $dados['produtos'] = $this->Produtos_Price_model->get_produtos();
        
        // Define o título da página
        $dados['title'] = 'Página Principal do Cliente';

        // Carrega a view e passa os dados do cliente e os produtos
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
        // Chama a função para confirmar a compra
        $this->Loja->confirmarCompra();
    }

    // Adicionar cliente
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

    // Editar cliente
    public function editar($id_cliente)
    {
        // Pegando os dados do formulário de edição
        $dados = array(
            'nome' => $this->input->post('nome'),
            'email' => $this->input->post('email')
        );

        // Atualizando os dados no banco de dados
        if ($this->Cliente_model->update_cliente($id_cliente, $dados)) {
            redirect('cliente/pagina_principal/' . $id_cliente);
        } else {
            echo "Erro ao atualizar os dados.";
        }
    }

    // Excluir cliente
    public function excluir($id_cliente)
    {
        if ($this->Cliente_model->delete_cliente($id_cliente)) {
            redirect('cliente/lista');
        } else {
            echo "Erro ao excluir o cliente.";
        }
    }
}
