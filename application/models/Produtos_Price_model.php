<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_Price_model extends CI_Model {

    public function store($produto)
    {
        if (!$produto['id_usuario_loja']) {
            $produto['id_usuario_loja'] = $this->session->userdata('id_usuario');
        }

        $this->db->insert('produto', $produto);
        return $this->db->insert_id();
    }

    public function get_produtos()
    {
        $query = $this->db->get('produto');
        return ($query->num_rows() > 0) ? $query->result_array() : [];
    }

    public function get_produtos_by_id($id_produto)
    {
        return $this->db->where('id_produto', $id_produto)->get('produto')->row();
    }

    public function update_produto($id_produto, $produto)
    {
        $this->db->where('id_produto', $id_produto)->update('produto', $produto);
    }

    public function getProdutosPorUsuario($id_usuario_loja) {
        return $this->db->get_where('produto', ['id_usuario_loja' => $id_usuario_loja])->result_array();
    }

    public function salvarProduto($produto) {
        $this->db->insert('produto', $produto);
    }

    public function deletarProduto($id_produto) {
        $produto = $this->db->where('id_produto', $id_produto)->get('produto')->row();
        
        if ($produto && $produto->comprado == 1) {
            return false;
        }
        
        $this->db->where('id_produto', $id_produto)->delete('produto');
        return true;
    }
}