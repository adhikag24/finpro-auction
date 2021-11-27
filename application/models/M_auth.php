<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function insertUser($table,$data){
        $this->db->insert($table,$data);
    }

    public function validateLogin($email,$password){
       $is_user =  $this->db->get_where('user',['user_email' => $email])->row_array();

       if($is_user){
            if($is_user['user_password'] == md5($password)){
                return $is_user;
            }else{
                return 0;
            }
       }else{
           return 0;
       }
    }
    

}

/* End of file M_auth.php */
