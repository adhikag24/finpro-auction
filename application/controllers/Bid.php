<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bid extends CI_Controller
{

    public $firebaseConn;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('firebase');
        $this->load->model('m_base');
        $firebaseConn = $this->firebase->init();
    }

    public function index()
    {
    }

    public function mybid()
    {
        $id = $this->session->userdata('id');
        $condition = array('id' => $id);

        $bid['data'] = $this->m_base->getOneToMany('bid', 'product_bid', 'product_id', 'id', $condition)->result_array();

        $this->load->view('template/header_view.php');
        $this->load->view('my_bid.php', $bid);
        $this->load->view('template/footer_view.php');
    }

    public function syncbidwinner()
    {
        $products = $this->m_base->getWhere('product_bid', ['is_active' => 1])->result_array();

        foreach ($products as $product) {
            $today = date("Y-m-d");
            if ($product['end_date'] < $today) {
                $bidData = $this->m_base->getWhere('bid', ['product_id' => $product['id']])->result_array();
                foreach ($bidData as $bid) {
                    if ($bid['amount'] == $product['highest_bid']) {
                        $check = $this->m_base->countWhere('bid_winner', ['product_id' => $product['id'], 'user_id' => $bid['user_id']]);
                        if ($check == 0) {
                            $data = [
                                'user_id'   => $bid['user_id'],
                                'product_id'   => $product['id']
                            ];
                            $insert = $this->m_base->insertTable('bid_winner', $data);
                        }
                    }
                }
            }
        }

    }
}
