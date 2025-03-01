<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_Price_model extends CI_Model {

    // Método para cadastrar produto
    public function store($produto)
    {
        // Adiciona o ID do usuário (caso não tenha sido passado)
        if (!$produto['id_usuario_loja']) {
            $produto['id_usuario_loja'] = $this->session->userdata('id_usuario'); // Obtém o ID da loja do usuário logado
        }

        // Insere o produto na tabela produto_create
        $this->db->insert('produto_create', $produto);
        
        // Retorna o ID do produto inserido (caso precise de confirmação)
        return $this->db->insert_id();
    }

    // Método para buscar todos os produtos
    public function get_produtos()
    {
        $produtos = $this->db->get('produto_create')->result_array();
        return $produtos;
    }

    // Método para buscar um produto pelo ID
    public function get_produtos_by_id($id)
    {
        $produto = $this->db->where('id', $id)->get('produto_create')->row();
        return $produto;
    }

    // Método para atualizar um produto
    public function update_produto($id, $produto)
    {
        $this->db->where('id', $id)->update('produto_create', $produto);
    }

    // Função para pegar os produtos de um usuário
    public function getProdutosPorUsuario($id_usuario_loja) {
        $query = $this->db->get_where('produto', array('id_usuario_loja' => $id_usuario_loja));
        return $query->result_array();
    }

    // Função para salvar um produto
    public function salvarProduto($produto) {
        $this->db->insert('produto', $produto);
    }

    // Função para deletar produto
    public function deletarProduto($id_produto) {
        // Verifica se o produto foi comprado, caso sim, não permite a exclusão
        $produto = $this->db->where('id', $id_produto)->get('produto')->row();
        
        // Se o produto foi comprado, não pode ser excluído
        if ($produto && $produto->comprado == 1) {
            return false; // Não exclui o produto
        }
        
        // Caso contrário, deleta o produto
        $this->db->where('id', $id_produto)->delete('produto');
        return true;
    }
}
