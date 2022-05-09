<?php 
/*
-- ---------------------------------------------------------------
-- MARKETPLACE MULTI BUYER MULTI SELLER + SUPPORT RESELLER SYSTEM
-- CREATED BY : ROBBY PRIHANDAYA
-- COPYRIGHT  : Copyright (c) 2018 - 2019, PHPMU.COM. (https://phpmu.com/)
-- LICENSE    : http://opensource.org/licenses/MIT  MIT License
-- CREATED ON : 2019-03-26
-- UPDATED ON : 2019-03-27
-- ---------------------------------------------------------------
*/
class Model_app extends CI_model{
    public function view($table){
        return $this->db->get($table);
    }

    public function insert($table,$data){
        return $this->db->insert($table, $data);
    }
    public function insert_id($table,$data){
         $this->db->insert($table, $data);
         return $this->db->insert_id();
    }

    public function edit($table, $data){
        return $this->db->get_where($table, $data);
    }
 
    public function update($table, $data, $where){
        return $this->db->update($table, $data, $where); 
    }

    public function delete($table, $where){
        return $this->db->delete($table, $where);
    }

    public function view_where($table,$data){
        $this->db->where($data);
        return $this->db->get($table);
    }
    public function dataUsers($email){
        $this->db->where('users_email',$email);
        $this->db->or_where('users_username',$email);
        return $this->db->get('users');
    }

    public function view_ordering_limit($table,$order,$ordering,$baris,$dari){
        $this->db->select('*');
        $this->db->order_by($order,$ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }

    public function view_where_ordering_limit($table,$data,$order,$ordering,$baris,$dari){
        $this->db->select('*');
        $this->db->where($data);
        $this->db->order_by($order,$ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }
    
    public function view_ordering($table,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }   
    public function view_order($table,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order,$ordering);
        return $this->db->get();
    }

    public function view_where_ordering($table,$data,$order,$ordering){
        $this->db->where($data);
        $this->db->order_by($order,$ordering);
        return $this->db->get($table);
        
    }
    public function view_where_ordering_group($table,$data,$order,$ordering,$group){
        $this->db->where($data);
        $this->db->group_by($group);
        $this->db->order_by($order,$ordering);
    
        return $this->db->get($table);
        
    }

    public function view_join_one($table1,$table2,$field,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }

    public function view_join_where($table1,$table2,$field,$where,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }
    public function join_where($table1,$table2,$field1,$field2,$where){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field1.'='.$table2.'.'.$field2);
        $this->db->where($where);
       
        return $this->db->get();
    }
    public function join_where_order($table1,$table2,$field,$where,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get();
    }
    public function join_where_order2($table1,$table2,$field1,$field2,$where,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field1.'='.$table2.'.'.$field2);
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get();
    }
    public function join_order($table1,$table2,$field,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field);
     
        $this->db->order_by($order,$ordering);
        return $this->db->get();
    }
    public function view_left_join_where($table1,$table2,$field,$where,$order,$ordering){
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1.'.'.$field.'='.$table2.'.'.$field,'left');
        $this->db->where($where);
        $this->db->order_by($order,$ordering);
        return $this->db->get()->result_array();
    }
    function seo_berita($title)
	{
			
			$query = " SELECT * FROM berita WHERE  berita_seo =  '$title' ";
			$query = $this->db->query($query);
            if($query->num_rows() > 0){
                return $title.'_'.rand(4,100);
            }else{
                return $title;
            }
		
	}
     function seo_berita_update($title,$id)
	{
			
			$query = " SELECT * FROM berita WHERE  berita_seo =  '$title' AND berita_id != '$id' ";
			$query = $this->db->query($query);
            if($query->num_rows() > 0){
                return $title.'_'.rand(4,100);
            }else{
                return $title;
            }
		
	}
    function dataPelayanan($status,$start,$end){
        if($status == null OR $status == 'all'){
            $where = "";
        }else{
            $where = "pm_status= '".$status."'";
        }
        $start = "AND".$start." 00:00:00";
        $end = $end." 23:59:59";
      $query = $this->db->query("SELECT * FROM pelayanan_masyarakat a JOIN masyarakat_temp b ON a.pm_temp_id = b.temp_id  WHERE pm_date >= '".$start."' AND pm_date <= '".$end."' AND pm_status != 'undone' $where 
                 ORDER BY CASE WHEN pm_status = 'proses' THEN 0 
                               WHEN pm_status = 'done' THEN 1
                               WHEN pm_status = 'cancel' THEN 2
                               WHEN pm_status = 'expired' THEN 3
                               ELSE 4 END,
                            pm_date DESC");
        return $query;
    }
    
 
}