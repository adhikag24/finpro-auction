<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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

    public function requestproduct()
	{
        
        $this->load->view('template/header_view.php');
        $this->load->view('request_product.php');
        $this->load->view('template/footer_view.php');
	}

    public function myproduct()
	{
        $id = $this->session->userdata('id');

        $product['data'] = $this->m_base->getDetail('product_bid', $id)->result_array();
      
        $this->load->view('template/header_view.php');
        $this->load->view('my_product.php',$product);
        $this->load->view('template/footer_view.php');
	}
}
