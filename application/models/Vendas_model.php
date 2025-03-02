<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas_model extends CI_Model {

    public function listarVendas($id_usuario_loja, $data_inicio = null, $data_fim = null)
    {
        $this->db->select('*');
        $this->db->from('vendas');
        $this->db->where('id_usuario_loja', $id_usuario_loja);

        if ($data_inicio) {
            $this->db->where('data_venda >=', $data_inicio);
        }
        if ($data_fim) {
            $this->db->where('data_venda <=', $data_fim);
        }

        return $this->db->get()->result_array();
    }

    public function registrarVenda($dadosVenda) {
        $this->db->insert('vendas', [
            'id_usuario_loja' => $dadosVenda['id_usuario_loja'],
            'id_produto' => $dadosVenda['id_produto'],
            'quantidade' => $dadosVenda['quantidade'],
            'valor_total' => $dadosVenda['valor_total'],
            'data_venda' => $dadosVenda['data_venda']
        ]);

        $produtosVendidos = $dadosVenda['produtos'];

        foreach ($produtosVendidos as $produto) {
            $this->db->set('estoque', 'estoque - ' . $produto['quantidade'], FALSE);
            $this->db->where('id_produto', $produto['id_produto']);
            $this->db->update('produto');
        }
    }
}