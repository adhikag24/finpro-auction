<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->model('m_auth');
 
    }

    public function registration(){
	  	$this->load->view('auth/register');
    }

    public function register_process(){
      $post = $this->input->post();

      $this->form_validation->set_rules('name', 'Name', 'required|trim');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.user_email]');
      $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
      $this->form_validation->set_rules('password2', 'Re-Type Password', 'required|matches[password1]');
      if($this->form_validation->run() == false){
				$this->registration();
        }else{
          $data = [
            'user_name' => $post['name'],
            'user_email' => $post['email'],
            'user_password' => md5($post['password1'])
          ];

        $this->m_auth->insertUser('user',$data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! you successfully register. Go Login!.
					</div>');
    
        redirect(base_url('auth/login'));
        }
    }


    public function login(){
	  	$this->load->view('auth/login');
    }

    public function login_process(){

      $this->form_validation->set_rules('email', 'Email', 'required|trim');
      $this->form_validation->set_rules('password', 'Password', 'required|trim');

      if ($this->form_validation->run() == false){
        $this->login();
        }
        else{
          $post = $this->input->post();

          $email = $post['email'];
          $password = $post['password'];
          
          $validate = $this->m_auth->validateLogin($email,$password);
    
          if($validate){
                $data=[
                  'name'     => $validate['user_name'],
                  'email'     => $validate['user_email'],
                  'id'     => $validate['id'],
                  'is_login'  => 1
              ];
    
              $this->session->set_userdata($data);
              redirect(base_url().'home');
    
          }else{
              $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email / Password is Wrong.
            </div>');
            redirect('auth/login');
          }
        }
    }

    

    public function logout(){
      $this->session->sess_destroy();
      redirect(base_url());
    }

}

