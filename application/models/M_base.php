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

    public function getDetail($table, $id){
        $query = $this->db->get_where($table, array('user_id' => $id));
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


    

}

/* End of file M_auth.php */
