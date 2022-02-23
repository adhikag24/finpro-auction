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
                $data['section'] = 'home';

                $this->load->view('template/header_view.php',$data);
                $this->load->view('home/home.php');
                $this->load->view('template/footer_view.php');
        }

        public function upcomingbid()
        {
                $data['section'] = 'upcomingBid';

                $this->load->view('template/header_view.php',$data);
                $this->load->view('home/upcoming_bid.php');
                $this->load->view('template/footer_view.php');
        }

        public function finishedbid()
        {
                $data['section'] = 'finishedBid';

                $products = $this->m_base->getWhere('product_bid', ['is_active' => 1])->result_array();
                $data['data'] = array();

                foreach ($products as $product) {
                        $today = date("Y-m-d");
                        // echo $product['end_date'] . $product['name'];
                        if ($product['end_date'] <= $today) {
                                $check = $this->m_base->countWhere('bid_winner', ['product_id' => $product['id']]);
                                if ($check > 0) {
                                        $product['winner_announced'] = 1;
                                } else {
                                        $product['winner_announced'] = 0;
                                }
                                array_push($data['data'], $product);
                        }
                }



                $this->load->view('template/header_view.php', $data);
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
