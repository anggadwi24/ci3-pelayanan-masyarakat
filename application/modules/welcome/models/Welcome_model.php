<?php

class Welcome_model extends CI_Model {

    protected static $_table_name = 'table name here';

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        return static::$_table_name;
    }

    function get($order_by=FALSE) {
        $table = $this->get_table();
        if($order_by != FALSE) {
            $this->db->order_by($order_by);
        }
        $query = $this->db->get($table);
        return $query->result();
    }

    function search($row, $query, $order_by, $limit, $offset) {
        $table = $this->get_table();
        $this->db->like($row, $query);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query->result();
    }
    
    function get_where_id($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query;
    }
    
    function get_where($row, $value) {
        $table = $this->get_table();
        $this->db->where($row, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query->result();
    }

    function get_where_list($row, $value) {
        $table = $this->get_table();
        $this->db->where($row, $value);
        $query = $this->db->get($table);
        return $query->result();
    }

    function get_where_row($row, $value) {
        $table = $this->get_table();
        $this->db->where($row, $value);
        $query = $this->db->get($table);
        return $query->row();
    }

    function _insert($data) {
        $table = $this->get_table();
        $result = $this->db->insert($table, $data);
        return $result;
    }

    function _update($id, $data) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $result = $this->db->update($table, $data);
        return $result;
    }

    function _delete($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $result = $this->db->delete($table);
        return $result;
    }

    function count_where($column, $value) {
        $table = $this->get_table();
        $this->db->where($column, $value);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_all() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max() {
        $table = $this->get_table();
        $this->db->select_max('id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }

}
