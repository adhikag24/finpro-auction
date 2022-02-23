<?php


defined('BASEPATH') or exit('No direct script access allowed');

class M_base extends CI_Model
{

    public function insertTable($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function getAll($table)
    {
        $query = $this->db->get($table);
        return $query;
    }

    public function countWhere($table, $where)
    {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function getDetail($table, $id)
    {
        $query = $this->db->get_where($table, array('user_id' => $id));
        return $query;
    }
    public function getWhere($table, $where)
    {
        $query = $this->db->get_where($table, $where);
        return $query;
    }

    public function getOneToMany($table1, $table2, $connection1, $connection2, $condition = null)
    {
        $this->db->select('*');
        $this->db->from($table1);
        if (isset($condition)) {
            $this->db->where($condition);
        }
        $this->db->join($table2, $table2 . '.' . $connection2 . '=' . $table1 . '.' . $connection1);
        $query = $this->db->get();

        return $query;
    }


    public function getOneToManyBid($table1, $table2, $connection1, $connection2, $condition = null)
    {
        $this->db->select('*');
        $this->db->from($table1);
        if (isset($where)) {
            $this->db->where($condition);
        }
        $this->db->join($table2, $table2 . '.' . $connection2 . '=' . $table1 . '.' . $connection1);
        $this->db->join('user', 'user.id' . '=' . 'bid.user_id');
        $query = $this->db->get();

        return $query;
    }

    public function getOneToManyBidWinner($table1, $table2, $connection1, $connection2, $condition = null)
    {
        $this->db->select('*');
        $this->db->from($table1);
        if (isset($where)) {
            $this->db->where($condition);
        }
        $this->db->join($table2, $table2 . '.' . $connection2 . '=' . $table1 . '.' . $connection1);
        $this->db->join('user', 'user.id' . '=' . 'bid_winner.user_id');
        $query = $this->db->get();

        return $query;
    }

    public function sendemail($target,  $subject, $message)
    { 
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'noreplyauctionsproject@gmail.com';
        $config['smtp_pass']    = 'raikage12345';
        $config['charset']    = 'iso-8859-1';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('noreplyauctionsproject@gmail.com', 'Auction Finpro');
        $this->email->to($target); 

        $this->email->subject($subject);
        $this->email->message($message);  

        $result = $this->email->send();

        var_dump($result);

        echo $this->email->print_debugger();
        
    }
}

/* End of file M_auth.php */
