<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loja extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('template'); 
        $this->load->model('Produtos_Price_model'); 
        $this->load->model('Vendas_model'); 
        $this->load->model('Usuarios_model'); 

        if (!$this->session->userdata('id_usuario')) {
            redirect('login');
        }
    }

    public function index(){
        $produtos = $this->Produtos_Price_model->get_produtos(); 
        $dados = [
            'title' => 'Loja',
            'produtos' => $produtos
        ];
        $this->template->load('lojaPaginaPrincipal', $dados);
    }

    public function cadastrarProduto() {
        $this->load->view('cadastrarProduto');
    }

    public function salvarProduto() {
        $id_usuario_loja = $this->session->userdata('id_usuario');
        
        if (!$this->Usuarios_model->usuarioExiste($id_usuario_loja)) {
            $this->session->set_flashdata('error', 'Usuário não encontrado!');
            redirect('loja');
            return;
        }

        $dadosProduto = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao'),
            'categoria' => $this->input->post('categoria'),
            'id_usuario_loja' => $id_usuario_loja,
            'quantidade' => $this->input->post('quantidade')
        ];

        $this->Produtos_Price_model->store($dadosProduto);
        $this->session->set_flashdata('success', 'Produto cadastrado com sucesso!');
        redirect('loja');
    }

    public function vendas()
    {
        $id_usuario_loja = $this->session->userdata('id_usuario');
        $data_inicio = $this->input->post('data_inicio') ? $this->input->post('data_inicio') : date('Y-m-d');
        $data_fim = $this->input->post('data_fim') ? $this->input->post('data_fim') : date('Y-m-d');

        $vendas = $this->Vendas_model->listarVendas($id_usuario_loja, $data_inicio, $data_fim); 
        $dados = [
            'title' => 'Vendas Recentes',
            'vendas' => $vendas
        ];
        $this->template->load('lojaPaginaPrincipal', $dados);
    }

    public function produtos() {
        $id_usuario_loja = $this->session->userdata('id_usuario');
        
        if (!$this->Usuarios_model->usuarioExiste($id_usuario_loja)) {
            $this->session->set_flashdata('error', 'Usuário não encontrado!');
            redirect('loja');
            return;
        }

        $produtos = $this->Produtos_Price_model->getProdutosPorUsuario($id_usuario_loja);
        $data['produtos'] = $produtos;
        $this->load->view('lojaPaginaPrincipal', $data);
    }

    public function salvarNovoProduto() {
        $id_usuario_loja = $this->session->userdata('id_usuario');
        
        $produto = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao'),
            'categoria' => $this->input->post('categoria'),
            'quantidade' => $this->input->post('quantidade'),
            'id_usuario_loja' => $id_usuario_loja
        ];

        $this->Produtos_Price_model->salvarProduto($produto);
        redirect('loja/produtos');
    }

    public function deletarProduto($id_produto) {
        $this->Produtos_Price_model->deletarProduto($id_produto);
        $this->session->set_flashdata('success', 'Produto excluído com sucesso!');
        redirect('loja');
    }

    public function produto($id_produto) {
        $produto = $this->Produtos_Price_model->get_produtos_by_id($id_produto);
        $this->load->view('produtoDetalhes', ['produto' => $produto]);
    }
}