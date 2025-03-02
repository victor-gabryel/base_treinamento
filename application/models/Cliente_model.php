<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Função para pegar todos os produtos disponíveis
    public function get_produtos() {
        // Seleciona todos os produtos disponíveis (estoque > 0)
        $this->db->where('estoque >', 0);  // Só produtos com estoque disponível
        $query = $this->db->get('produto'); // Obtendo todos os produtos da tabela produto
        return $query->result(); // Retorna o resultado como um array de objetos
    }

    // Função para pegar um cliente específico pelo id_cliente
    public function get_cliente($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $query = $this->db->get('cliente'); // Assume que a tabela do cliente se chama 'cliente'
        return $query->row(); // Retorna um único objeto de cliente
    }

    // Função para atualizar os dados do cliente
    public function update_cliente($id_cliente, $dados) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->update('cliente', $dados); // Assume que a tabela se chama 'cliente'
    }

    // Função para excluir um cliente
    public function delete_cliente($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->delete('cliente'); // Assume que a tabela se chama 'cliente'
    }

    // Função para adicionar um novo cliente
    public function insert_cliente($dados) {
        return $this->db->insert('cliente', $dados); // Assume que a tabela se chama 'cliente'
    }
}
?>
