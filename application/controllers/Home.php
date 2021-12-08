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
                $this->load->view('template/header_view.php');
                $this->load->view('home/finished_bid.php');
                $this->load->view('template/footer_view.php');
        }


        public function requestproduct()
        {

                $this->load->view('template/header_view.php');
                $this->load->view('request_product.php');
                $this->load->view('template/footer_view.php');
        }
}
