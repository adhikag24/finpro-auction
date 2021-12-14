<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    public $firebaseConn;

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_login') != 1) {
            redirect('auth/login');
        }
        $this->load->library('firebase');
        $this->load->model('m_base');
        $this->load->library('form_validation');

        $this->firebaseConn = $this->firebase->init();
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
        $this->form_validation->set_rules('daterange', 'End Date', 'required|trim');

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


                    $uploadedfile = fopen('./assets/image/' . $name, 'r');

                    $uploadedName = $this->upload->data('raw_name') . time() . $this->upload->data('file_ext');

                    $defaultBucket->getBucket()->upload($uploadedfile, ['name' =>  $uploadedName]);

                    unlink('./assets/image/' . $name);

                    $image_url = 'https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/' . $uploadedName;


                    $daterange = explode('-', $post['daterange']);
                    $startDate = date("Y-m-d", strtotime($daterange[0]));
                    $endDate = date("Y-m-d", strtotime($daterange[1]));

                    $data = array(
                        'name' => $post['product_name'],
                        'starting_price' => $post['starting_price'],
                        'start_date' => $startDate,
                        'end_date' => $endDate,
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

        $product = $this->m_base->getDetail('product_bid', $id)->result_array();
        // echo "<pre>";
        // print_r($product);
        $data['data'] = array_reverse($product);
        // print_r($data);
        // echo "</pre>";

        $this->load->view('template/header_view.php');
        $this->load->view('my_product.php', $data);
        $this->load->view('template/footer_view.php');
    }

    public function detail($productId)
    {
        if ($this->session->userdata('is_login') != 1) {
            redirect('auth/login');
        }
        $data['id'] = $productId;
        $this->load->view('template/header_view.php');
        $this->load->view('detail_product.php', $data);
        $this->load->view('template/footer_view.php');
    }

    public function syncproductbid()
    {
        $where = [
            'is_active' => 0,
            'is_validated' => 0
        ];
        $products = $this->db->get_where('product_bid', $where)->result_array();

        foreach ($products as $product) {
            $resultCurl = $this->identifyBlurandObject($product['product_image']);
            $resultCurl = json_decode($resultCurl, true);

            $userData = $this->db->get_where('user', ['id'  => $product['user_id']])->row_array();

            if ($resultCurl['is_approved']) {
               
                //send notification
                $dataEmail = [
                    'to'    => $userData['user_email'],
                    'subject'   => 'Congratulations!, your product was validated and will be activated to the market.',
                    'body'      => sprintf("Hi %s, congratulations your product (%s), will go market at %s.", $userData['user_name'], $product['name'], $product['start_date'])
                ];

                $this->m_base->sendemail($dataEmail['to'], $dataEmail['subject'], $dataEmail['body']);

                $changes = [
                    'is_active' => 1,
                    'is_validated' => 1
                ];

                $this->db->where('id', $product['id']);
                $this->db->update('product_bid', $changes);

                $firebaseProduct = [
                    "end_date" => $product['end_date'],
                    "start_date" => $product['start_date'],
                    "highest_bid" => 0,
                    "initial_price" => $product['starting_price'],
                    "product_id" => $product['id'],
                    "product_images" => $product['product_image'],
                    "product_name" => $product['name'],
                    "total_bidder" => 0
                ];
                
                $this->insertfirebase($firebaseProduct);

            } else {
                $dataEmail = [
                    'to'    => $userData['user_email'],
                    'subject'   => 'Unfortunately!, your product was not validated.',
                    'body'      =>  sprintf("Hi %s, unfortunately your product (%s), was not validated. \n Please makesure your product image fullfill, requirement below: \n <ul> <li>Picture not blurry.</li> <li>Product Object is clear.</li> <li>Enough Brightness</li> </ul>", $userData['user_name'], $product['name'])
                ];

                $this->m_base->sendemail($dataEmail['to'], $dataEmail['subject'], $dataEmail['body']);

                $changes = [
                    'is_validated' => 1
                ];

                $this->db->where('id', $product['id']);
                $this->db->update('product_bid', $changes);
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Done! syncronize product data.
					</div>');

        redirect(base_url('admin/product'));
    }

    public function insertfirebase($data)
    {
        $db = $this->firebaseConn->getDatabase();
        $db->getReference('/products')->push($data);
    }


    public function identifyBlurandObject($imageurl)
    {
        /* API URL */
        $url = 'http://127.0.0.1:5000/validate-image';

        /* Init cURL resource */
        $ch = curl_init($url);


        /* Array Parameter Data */
        $data = ['image' => $imageurl];

        /* pass encoded JSON string to the POST fields */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        /* execute request */
        $result = curl_exec($ch);



        /* close cURL resource */
        curl_close($ch);

        return $result;
    }


    public function submitbid()
    {
        $userid = $this->session->userdata('id');
        $post = $this->input->post();
     
        $where = [
            'user_id' => $userid,
            'product_id' => $post['productId']
        ];

        $alreadyBidProduct = $this->m_base->getWhere('bid', $where);
        if (empty($alreadyBidProduct->row())) {
            $data = [
                'user_id' => $userid,
                'product_id' => $post['productId'],
                'amount' => $post['amount']
            ];

            $this->m_base->insertTable('bid', $data);
        } else {
            $data = array(
                'amount' => $post['amount']
            );

            $this->db->where($where);
            $this->db->update('bid', $data);
        }

        $count = $this->m_base->countWhere('bid', ['product_id' => $post['productId']]);

        //update firebase
        $updates = [
            'products/' . $post['productfbId'] . '/total_bidder' => $count,
            'products/' . $post['productfbId'] . '/highest_bid' => $post['amount'],
        ];


        $db = $this->firebaseConn->getDatabase();
        $db->getReference()->update($updates);

        $productupdatedata = array(
            'highest_bid' => $post['amount'],
            'total_bidder' => $count
        );

        $this->db->where(['id' => $post['productId']]);
        $this->db->update('product_bid', $productupdatedata);

        $response = [
            'amount'    => $post['amount']
        ];

        $responseJson = json_encode($response);

        echo $responseJson;
    }
}