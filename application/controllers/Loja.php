<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('template'); // Carrega a biblioteca de template
        $this->load->model('Produtos_Price_model'); // Carrega o modelo de produtos
        $this->load->model('Vendas_model'); // Carrega o modelo de vendas
        $this->load->model('Usuarios_model'); // Carrega o modelo de usuários
    }

    // Página inicial da loja
    public function index(){
        $produtos = $this->Produtos_Price_model->get_produtos(); // Pega todos os produtos
        $dados = [
            'title' => 'Loja',
            'produtos' => $produtos // Passa os produtos para a view
        ];
        $this->template->load('lojaPaginaPrincipal', $dados); // Chama a view lojaPaginaPrincipal com os produtos
    }

    // Função para exibir o formulário de cadastro de produto
    public function cadastrarProduto() {
        $this->load->view('cadastrarProduto'); // Chama a view cadastrarProduto.php
    }

    // Função para salvar o produto no banco de dados
    public function salvarProduto() {
        // Pega o id do usuário da sessão
        $id_usuario_loja = $this->session->userdata('id_usuario');
        
        // Verifica se o usuário existe na tabela usuarios
        if (!$this->Usuarios_model->usuarioExiste($id_usuario_loja)) {
            // Se o usuário não existir, redireciona ou exibe uma mensagem de erro
            $this->session->set_flashdata('error', 'Usuário não encontrado!');
            redirect('loja');
            return;
        }

        // Pega os dados do formulário
        $dadosProduto = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao'),
            'categoria' => $this->input->post('categoria'),
            'id_usuario_loja' => $id_usuario_loja, // Supondo que o ID do usuário da loja esteja na sessão
            'quantidade' => $this->input->post('quantidade') // Adicionando a quantidade
        ];

        // Chama o modelo para salvar os dados
        $this->Produtos_Price_model->store($dadosProduto);

        // Redireciona para a página principal da loja ou outra página de confirmação
        $this->session->set_flashdata('success', 'Produto cadastrado com sucesso!');
        redirect('loja');
    }

    // Função para listar as vendas recentes com base nas datas fornecidas
    public function vendas()
    {
        $id_usuario_loja = $this->session->userdata('id_usuario'); // Pegando o id do usuário da loja da sessão
        $data_inicio = $this->input->post('data_inicio'); // Pega as datas do formulário
        $data_fim = $this->input->post('data_fim');

        // Filtra as vendas com as datas fornecidas
        $vendas = $this->Vendas_model->listarVendas($id_usuario_loja, $data_inicio, $data_fim); 
        $dados = [
            'title' => 'Vendas Recentes',
            'vendas' => $vendas // Passa as vendas para a view
        ];
        $this->template->load('lojaPaginaPrincipal', $dados); // Chama a view lojaPaginaPrincipal com as vendas
    }

    // Função para exibir os produtos da loja
    public function produtos() {
        $id_usuario_loja = $this->session->userdata('id_usuario');
        
        $produtos = $this->Produtos_Price_model->getProdutosPorUsuario($id_usuario_loja);
        $data['produtos'] = $produtos;

        $this->load->view('loja/produtos', $data);
    }

    // Função para salvar um novo produto
    public function salvarNovoProduto() {
        $id_usuario_loja = $this->session->userdata('id_usuario');
        
        $produto = array(
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao'),
            'categoria' => $this->input->post('categoria'),
            'quantidade' => $this->input->post('quantidade'),
            'id_usuario_loja' => $id_usuario_loja
        );

        $this->Produtos_Price_model->salvarProduto($produto);
        redirect('loja/produtos');
    }

    // Função para deletar o produto
    public function deletarProduto($id_produto) {
        $this->Produtos_Price_model->deletarProduto($id_produto); // Passando o id_produto corretamente
        redirect('loja/produtos');
    }

    // Exemplo para pegar um produto
    public function produto($id_produto) {
        $produto = $this->Produtos_Price_model->get_produto_by_id($id_produto); // Ajuste aqui também
        // Passando o produto para a view
        $this->load->view('produtoDetalhes', ['produto' => $produto]);
    }

}
