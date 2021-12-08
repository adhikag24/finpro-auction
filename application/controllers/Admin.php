<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('m_base');
        if($this->session->userdata('role') != 1){
            redirect(base_url());
        }
    }

    public function index()
    {

		$this->load->view('admin/template/header');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/template/footer');
	}
	
	public function product()
	{
        // $data['newsData'] = $this->m_news->getNewsData();
        $data['data'] = $this->m_base->getAll('product_bid')->result_array();
        
		$this->load->view('admin/template/header');
		$this->load->view('admin/product',$data);
		$this->load->view('admin/template/footer');
	}

    public function bid()
	{
        // $data['newsData'] = $this->m_news->getNewsData();
        $data['data'] = $this->m_base->getOneToManyBid('bid', 'product_bid', 'product_id', 'id')->result_array();
        // print_r($data);
        // die;
        
		$this->load->view('admin/template/header');
		$this->load->view('admin/bid_list',$data);
		$this->load->view('admin/template/footer');
	}

	public function create_news()
	{
		$this->load->view('admin/template/header');
		$this->load->view('admin/insert_news');
		$this->load->view('admin/template/footer');
    }
    
    public function insert_news()
    {
        $post = $this->input->post();

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Event', 'required|trim');
        $this->form_validation->set_rules('slug', 'Event Time', 'required|trim');
        $this->form_validation->set_rules('news_author', 'News Author', 'required|trim');

        if (!empty($_FILES['news_image']['name'])){
            $config['upload_path']          = './assets/image/news';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = 2000;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['overwrite']            = FALSE;
            $config['remove_spaces']        = TRUE;

    
            $this->load->library('upload', $config);
    
            if($this->form_validation->run() == false){
				$this->create_news();
            }else{
                if (!$this->upload->do_upload('news_image')){
                    $this->create_news();
                }else{
                    $data = array(
                        'news_title' => $post['title'],
                        'news_content' => $post['content'],
                        'news_slug' => $post['slug'],
                        'author_id'  => $post['news_author'],
                        'news_image' =>  $this->upload->data('file_name'),
                    );
                   
					$this->m_news->insertNews('news',$data);
					
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! your news has been published.
					</div>');
    
                    redirect(base_url('admin/news'));
                }
            }
        }
    }

	public function edit_news($newsSlug)
	{
        $data['news'] =  $this->m_news->getNewsData($newsSlug);

        $this->load->view('admin/template/header');
		$this->load->view('admin/edit_news',$data);
		$this->load->view('admin/template/footer');
    }

    public function update_news()
    {
        $post = $this->input->post();

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('content', 'Event', 'required|trim');
        $this->form_validation->set_rules('slug', 'Event Time', 'required|trim');

        if (!empty($_FILES['news_image']['name'])){
            $config['upload_path']          = './assets/image/news';
            $config['allowed_types']        = 'jpg|png';
            $config['max_size']             = 2000;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['overwrite']            = FALSE;
            $config['remove_spaces']        = TRUE;

    
            $this->load->library('upload', $config);
    
            if($this->form_validation->run() == false){
				$this->create_news();
            }else{
                if (!$this->upload->do_upload('news_image')){
                    $this->create_news();
                }else{
                    $data = array(
                        'news_title' => $post['title'],
                        'news_content' => $post['content'],
                        'news_slug' => $post['slug'],
                        'news_image' =>  $this->upload->data('file_name'),
                    );
                   
					$this->m_news->updateNews($post['news_id'],$data);
					
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! your news has been updated.
					</div>');
    
                    redirect(base_url('admin/news'));
                }
            }
        }else{
            $data = array(
                'news_title' => $post['title'],
                'news_content' => $post['content'],
                'news_slug' => $post['slug'],
            );
           
            $this->m_news->updateNews($post['news_id'],$data);
            
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! your news has been updated.
            </div>');

            redirect(base_url('admin/news'));
        }
    }
    
    public function delete_news($newsSlug)
    {
        $this->m_news->deleteNews($newsSlug);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! your news has been deleted.
					</div>');
    
        redirect(base_url('admin/news'));
    }

	public function users()
	{
        $data['members'] = $this->m_admin->select_table('member');

		$this->load->view('admin/template/header');
		$this->load->view('admin/users_list',$data);
		$this->load->view('admin/template/footer');
    }
    
    public function update_user()
    {
        $post = $this->input->post();

        if(empty($post['member_name'])){
            unset($post['member_name']);
        }elseif(empty($post['member_email'])){
            unset($post['member_email']);
        }


        $this->db->where('member_id', $post['member_id']);
        $this->db->update('member', $post);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! user has been updated.
					</div>');
    
        redirect(base_url('admin/users'));
    }
    
    public function delete_user($user_id)
    {
        $this->db->delete('member',['member_id' => $user_id]);
        $this->db->delete('news',['author_id' => $user_id]);
        $this->db->delete('comments',['user_id' => $user_id]);
        $this->db->delete('news_document',['user_id' => $user_id]);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! user has been deleted.
					</div>');
    
        redirect(base_url('admin/users'));
    }

	public function comments()
	{
        $data['comments'] = $this->m_admin->select_table('comments');

		$this->load->view('admin/template/header');
		$this->load->view('admin/comments_list',$data);
		$this->load->view('admin/template/footer');
    }
    
    public function delete_comment($commentId){
        $this->db->delete('comments',['comment_id' => $commentId]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Congratulation! comment has been deleted.
        </div>');

        redirect(base_url('admin/comments'));
    }

	public function documents()
	{
        $data['documents'] = $this->m_admin->select_table('news_document');

		$this->load->view('admin/template/header');
		$this->load->view('admin/documents_list',$data);
		$this->load->view('admin/template/footer');
    }
    
    public function delete_document($docId)
    {
        $this->db->delete('news_document',['newsdoc_id' => $docId]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Congratulation! document has been deleted.
        </div>');

        redirect(base_url('admin/documents'));
    }

    
}

