<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas_model extends CI_Model {

    // Método para listar as vendas com filtro de data
    public function listarVendas($id_usuario_loja, $data_inicio = null, $data_fim = null)
    {
        $this->db->select('*');
        $this->db->from('vendas');
        $this->db->where('id_usuario_loja', $id_usuario_loja);

        // Se houver um filtro de data, aplicamos
        if ($data_inicio) {
            $this->db->where('data >=', $data_inicio);
        }
        if ($data_fim) {
            $this->db->where('data <=', $data_fim);
        }

        return $this->db->get()->result_array(); // Retorna as vendas
    }
}