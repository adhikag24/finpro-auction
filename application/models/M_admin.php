<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

    public function select_table($table){
        return $this->db->get($table)->result_array();
    }

}

/* End of file M_admin.php */
