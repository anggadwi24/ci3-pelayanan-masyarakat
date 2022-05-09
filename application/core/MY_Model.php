<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' ); 

class MY_Model extends CI_Model 
{
	public $table = "";

    public function __construct() 
    { 
        parent::__construct(); 
    }

    function get($order_by = FALSE) {
    	if($order_by) {
    		$this->db->order_by($order_by);
    		$result = $this->db->get($this->table);
    	} else {
    		$result = $this->db->get($this->table);
    	}
    	return $result->result();
    }

    function get_data_from_db($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    function show_culumn_names() {
        $query = $this->db->list_fields($this->table);
        return $query;
    }

    function get_where_row($row, $value) {
        $this->db->where($row, $value);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    function get_where_list($row, $value) {
        $this->db->where($row, $value);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function get_where_list_limit($row, $value, $limit, $offset, $order_by) {
        $this->db->where($row, $value);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($this->table);
        return $query->result();
	}

	function get_with_limit($limit, $offset, $order_by) {
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function count_all() {
        $query = $this->db->get($this->table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_where($column, $value) {
        $this->db->where($column, $value);
        $query = $this->db->get($this->table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max($column) {
        $this->db->select_max($column);
        $query = $this->db->get($this->table);
        $row = $query->row();
        $result = $row->$column;
        return $result;
    }

    function search_query($query, $column1, $column2=FALSE, $column3=FALSE, $column4=FALSE, $order_by=FALSE) {
        $this->db->like($column1, $query);
        if(isset($column2) && $column2 != FALSE) {
            $this->db->or_like($column2, $query);
        }

        if(isset($column3) && $column3 != FALSE) {
            $this->db->or_like($column3, $query);
        }

        if(isset($column4) && $column4 != FALSE) {
            $this->db->or_like($column4, $query);
        }
        
        if(isset($order_by) && $order_by != FALSE) {
            $this->db->order_by(order_by);
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function custom_query($query) {
        $result = $this->db->query($query);
        return $result->result_array();
    }

    // Protected methods
    function _insert($data) {
        $result = $this->db->insert($this->table, $data);
        return $result;
    }

    function _update($id, $data) {
        $this->db->where('id', $id);
        $result = $this->db->update($this->table, $data);
        return $result;
    }

    function _delete($id) {
        $this->db->where('id', $id);
        $result = $this->db->delete($this->table);
        return $result;
    }
}
