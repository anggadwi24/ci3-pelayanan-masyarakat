<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' ); 

class MY_Controller extends MX_Controller 
{ 
	public $model = "";

    public function __construct() 
    { 
        parent::__construct();  
    }

    function get_data_from_post($db_columns) {
		foreach($db_columns as $column) {
			$data[$column] = $this->input->post($column);
		}
        return $data;
    }

    /**
     * Usage
     * $data = $this->get_data_from_db($id)[0];
     */
    function get_data_from_db($id) {
        $query = $this->model->get_data_from_db($id);
        $data = array();
        foreach ($query as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }

    function show_culumn_names() {
        $query = $this->model->show_culumn_names();
        return $query;
    }

    function get($order_by = FALSE) {
    	if($order_by) {
    		$query = $this->model->get($order_by);
    	} else {
    		$query = $this->model->get();
    	}
    	return $query;
    }

    function get_where_row($row, $value) {
        $query = $this->model->get_where_row($row, $value);
        return $query;
    }

    function get_where_list($row, $value) {
        $query = $this->model->get_where_list($row, $value);
        return $query;
	}
	
	function get_with_limit($limit, $offset, $order_by) {
        $query = $this->model->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function get_where_list_limit($row, $value, $limit, $offset, $order_by) {
        $query = $this->model->get_where_list_limit($row, $value, $limit, $offset, $order_by);
        return $query;
    }

    function search_query($query, $column1, $column2=FALSE, $column3=FALSE, $column4=FALSE, $order_by=FALSE) {
        $query = $this->model->search_query($query, $column1, $column2=FALSE, $column3=FALSE, $column4=FALSE, $order_by=FALSE);
        return $query;
    }

    function custom_query($mysql_query) {
        $query = $this->model->custom_query($mysql_query);
        return $query;
    }

    function count_all() {
        $count = $this->model->count_all();
        return $count;
    }

    function count_where($column, $value) {
        $count = $this->model->count_where($column, $value);
        return $count;
    }

    function get_max($id) {
        $max_id = $this->model->get_max($id);
        return $max_id;
    }

    // Private methods
    function _insert($data) {
        $this->model->_insert($data);
    }

    function _update($id, $data) {
        $this->model->_update($id, $data);
    }

    function _delete($id) {
        $this->model->_delete($id);
    }
}
