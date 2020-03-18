<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReactApi_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_products()
    {
        $this->db->where('is_active', 1);
        $query = $this->db->get('products');
        return $query->result();
    }

    public function get_product($productId)
    {
        $this->db->where('is_active', 1);
        $this->db->where('id', $productId);
        $query = $this->db->get('products');
        return $query->row();
    }

    public function insert_product($productData)
    {
        $this->db->insert('products', $productData);
        return $this->db->insert_id();
    }

    public function update_product($id, $productData)
    {
        $this->db->where('id', $id);
        $this->db->update('products', $productData);
    }

    public function delete_product($productId)
    {
        $this->db->where('id', $productId);
        $this->db->delete('products');
    }

}