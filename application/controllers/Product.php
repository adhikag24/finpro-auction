<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    public $firebaseConn;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('firebase');
        $this->load->model('m_base');
        $this->load->library('form_validation');

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

    public function insertProduct()
    {
        $post = $this->input->post();

        $this->form_validation->set_rules('product_name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('starting_price', 'Starting Price', 'required|trim');
        $this->form_validation->set_rules('end_date', 'End Date', 'required|trim');

        if (!empty($_FILES['product_image']['name'])) {
            $config['upload_path']          = './assets/image';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 2000;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['overwrite']            = FALSE;
            $config['remove_spaces']        = TRUE;
            
            $this->load->library('upload', $config);
    

            if ($this->form_validation->run() == false) {
                $this->requestproduct();
            } else {
                if (!$this->upload->do_upload('product_image')) {
                    print_r($this->upload->display_errors());
                    $this->requestproduct();
                } else {
                    //upload to firebase
                    $defaultBucket = $this->firebaseConn->getStorage();
                    $name = $_FILES['product_image']['name'];


                    $uploadedfile = fopen('./assets/image/'.$name, 'r');

                    $uploadedName = $this->upload->data('raw_name').time().$this->upload->data('file_ext');

                    $defaultBucket->getBucket()->upload($uploadedfile, ['name' =>  $uploadedName]);

                    unlink('./assets/image/'.$name);

                    $image_url = 'https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/' . $uploadedName;

                    $data = array(
                        'name' => $post['product_name'],
                        'starting_price' => $post['starting_price'],
                        'end_date' => $post['end_date'],
                        'user_id' => $this->session->userdata('id'),
                        'product_image'  => $image_url,
                    );

                    $this->m_base->insertTable('product_bid', $data);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! your product has been submitted, the process of checking taking 24hour.
					</div>');

                    redirect(base_url('product/requestproduct'));
                }
            }
        }
    }

    public function myproduct()
    {
        $id = $this->session->userdata('id');

        $product['data'] = $this->m_base->getDetail('product_bid', $id)->result_array();

        $this->load->view('template/header_view.php');
        $this->load->view('my_product.php', $product);
        $this->load->view('template/footer_view.php');
    }

    public function detail($productId)
    {
        $data['id'] = $productId;
        $this->load->view('template/header_view.php');
        $this->load->view('detail_product.php', $data);
        $this->load->view('template/footer_view.php');
    }
}
