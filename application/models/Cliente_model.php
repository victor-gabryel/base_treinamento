<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_produtos() {
        $this->db->where('estoque >', 0);
        $query = $this->db->get('produto');
        return $query->result();
    }

    public function get_cliente($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        $query = $this->db->get('cliente');
        return $query->row();
    }

    public function update_cliente($id_cliente, $dados) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->update('cliente', $dados);
    }

    public function delete_cliente($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->delete('cliente');
    }

    public function insert_cliente($dados) {
        return $this->db->insert('cliente', $dados);
    }
}
?>