<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid extends CI_Controller {

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
        $condition = array('id' =>$id);
        
        $bid['data'] = $this->m_base->getOneToMany('bid', 'product_bid', 'product_id', 'id', $condition)->result_array();

        $this->load->view('template/header_view.php');
        $this->load->view('my_bid.php',$bid);
        $this->load->view('template/footer_view.php');
	}
}
