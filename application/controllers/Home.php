<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

        public $firebaseConn;

        public function __construct()
        {
                parent::__construct();
                $this->load->library('firebase');
                $this->load->library('session');
                $this->load->model('m_base');
                $firebaseConn = $this->firebase->init();
        }

        public function index()
        {
                // $newdata = array( 
                //     'username'  => 'johndoe', 
                //     'email'     => 'johndoe@some-site.com', 
                //     'logged_in' => TRUE
                //  );  

                // $this->session->set_userdata($newdata);

                $this->load->view('template/header_view.php');
                $this->load->view('home/home.php');
                $this->load->view('template/footer_view.php');
        }

        public function upcomingbid()
        {
                $this->load->view('template/header_view.php');
                // $this->load->view('home/finished_bid.php');
                $this->load->view('template/footer_view.php');
        }

        public function finishedbid()
        {
                $products = $this->m_base->getWhere('product_bid', ['is_active' => 1])->result_array();
                $data['data'] = array();

                foreach ($products as $product) {
                        $today = date("Y-m-d");
                        if ($product['end_date'] < $today) {
                                $check = $this->m_base->countWhere('bid_winner', ['product_id' => $product['id']]);
                                if ($check > 0) {
                                        $product['winner_announced'] = 1;
                                } else {
                                        $product['winner_announced'] = 0;
                                }
                                array_push($data['data'], $product);
                        }
                }



                $this->load->view('template/header_view.php');
                $this->load->view('home/finished_bid.php', $data);
                $this->load->view('template/footer_view.php');
        }


        public function requestproduct()
        {

                $this->load->view('template/header_view.php');
                $this->load->view('request_product.php');
                $this->load->view('template/footer_view.php');
        }
}
