<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_Price_model extends CI_Model {

    // Função para armazenar um novo produto
    public function store($produto)
    {
        // Verifica se o produto tem um 'id_usuario_loja', se não, pega o 'id_usuario' da sessão
        if (!$produto['id_usuario_loja']) {
            $produto['id_usuario_loja'] = $this->session->userdata('id_usuario');
        }

        // Insere o produto no banco de dados
        $this->db->insert('produto', $produto);

        // Retorna o ID do produto inserido
        return $this->db->insert_id();
    }

    // Função para obter todos os produtos da tabela 'produto'
    public function get_produtos()
    {
        // Realiza a consulta para pegar todos os produtos
        $query = $this->db->get('produto');

        // Verifica se há produtos na tabela e retorna como um array
        if ($query->num_rows() > 0) {
            return $query->result_array(); // Retorna os produtos como array
        } else {
            return []; // Retorna array vazio se não houver produtos
        }
    }

    // Função para obter um produto específico pelo ID
    public function get_produtos_by_id($id_produto)
    {
        // Realiza a consulta para pegar o produto com base no ID
        return $this->db->where('id_produto', $id_produto)->get('produto')->row();
    }

    // Função para atualizar os dados de um produto
    public function update_produto($id_produto, $produto)
    {
        // Atualiza o produto com base no ID
        $this->db->where('id_produto', $id_produto)->update('produto', $produto);
    }

    // Função para obter produtos por um usuário específico (usuário loja)
    public function getProdutosPorUsuario($id_usuario_loja) {
        // Consulta os produtos com base no ID do usuário
        return $this->db->get_where('produto', ['id_usuario_loja' => $id_usuario_loja])->result_array();
    }

    // Função para salvar um produto
    public function salvarProduto($produto) {
        // Insere o produto na tabela 'produto'
        $this->db->insert('produto', $produto);
    }

    // Função para deletar um produto
    public function deletarProduto($id_produto) {
        // Verifica se o produto existe
        $produto = $this->db->where('id_produto', $id_produto)->get('produto')->row();
        
        // Se o produto foi comprado, não pode ser deletado
        if ($produto && $produto->comprado == 1) {
            return false;
        }
        
        // Deleta o produto da tabela 'produto'
        $this->db->where('id_produto', $id_produto)->delete('produto');
        return true;
    }

}
