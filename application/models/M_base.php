<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class M_base extends CI_Model {

    public function insertTable($table,$data){
        $this->db->insert($table,$data);
    }

    public function getAll($table){
        $query = $this->db->get($table);
        return $query;
    }

    public function countWhere($table,$where){
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function getDetail($table, $id){
        $query = $this->db->get_where($table, array('user_id' => $id));
        return $query;
    }
    public function getWhere($table, $where){
        $query = $this->db->get_where($table, $where);
        return $query;
    }

    public function getOneToMany($table1, $table2, $connection1, $connection2, $condition = null){
        $this->db->select('*');
        $this->db->from($table1);
        if(isset($where)){
        $this->db->where($condition);
        }
        $this->db->join($table2, $table2.'.'.$connection2 .'='. $table1.'.'.$connection1);
        $query = $this->db->get();

        return $query;

    }


    public function getOneToManyBid($table1, $table2, $connection1, $connection2, $condition = null){
        $this->db->select('*');
        $this->db->from($table1);
        if(isset($where)){
        $this->db->where($condition);
        }
        $this->db->join($table2, $table2.'.'.$connection2 .'='. $table1.'.'.$connection1);
        $this->db->join('user', 'user.id' .'='. 'bid.user_id');
        $query = $this->db->get();

        return $query;

    }


    

}

/* End of file M_auth.php */
