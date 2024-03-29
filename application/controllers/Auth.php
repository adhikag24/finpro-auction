<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public $firebaseConn;

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->library('firebase');
    $this->load->model('m_auth');
    $this->load->model('m_base');
    $this->firebaseConn = $this->firebase->init();
  }


  public function registration()
  {
    $this->load->view('template/header_view.php');
    $this->load->view('auth/register');
    $this->load->view('template/footer_view.php');
  }

  public function register_process()
  {
    $post = $this->input->post();

    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.user_email]');
    $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
    $this->form_validation->set_rules('password2', 'Re-Type Password', 'required|matches[password1]');
    if ($this->form_validation->run() == false) {
      $this->registration();
    } else {
      $data = [
        'user_name' => $post['name'],
        'user_email' => $post['email'],
        'user_password' => md5($post['password1'])
      ];

      $this->m_auth->insertUser('user', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
					Congratulation! you successfully register. Go Login!.
					</div>');

      redirect(base_url('auth/login'));
    }
  }


  public function login()
  {
    $this->load->view('auth/login');
  }

  public function verify($id)
  {

    $dataUpdate = [
      'is_verified' => 1
    ];

    $this->db->where('id', $id);
    $this->db->update('user', $dataUpdate);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    Done! verify user.
    </div>');

    redirect(base_url('admin/users'));
  }

  public function login_process()
  {

    $this->form_validation->set_rules('email', 'Email', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    if ($this->form_validation->run() == false) {
      $this->login();
    } else {
      $post = $this->input->post();

      $email = $post['email'];
      $password = $post['password'];



      $validate = $this->m_auth->validateLogin($email, $password);

      //check user is active
      if ($validate['is_verified'] == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        Your account has not been verified
        </div>');
        redirect('auth/login');
      }


      if ($validate) {
        $data = [
          'name'     => $validate['user_name'],
          'email'     => $validate['user_email'],
          'id'     => $validate['id'],
          'role'  => $validate['role'],
          'is_login'  => 1
        ];

        $this->session->set_userdata($data);
        redirect(base_url() . 'home');
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email / Password is Wrong.
            </div>');
        redirect('auth/login');
      }
    }
  }

  public function kycverif()
  {
    $post = $this->input->post();

    $nim =  $post['nim'];
    $fullname =  $post['fullname'];
    $where = ['nim' => $nim];
    $ceknim = $this->m_base->countWhere('user', $where);
    $jsonResponse = '';

    if ($ceknim > 0) {
      $response['data'] = false;
      $response['message'] = 'Maaf NIM sudah terdaftar.';
      $jsonResponse = json_encode($response);
    } else {
      $isUserVerified = $this->checkIfMahasiswaExist($fullname, $nim);
      $response['data'] = $isUserVerified;
      $response['message'] = $isUserVerified ? 'Selamat anda telah terverifikasi, dan dapat lanjut ke proses selanjutnya.' : 'Maaf anda belum terverifikasi, pastikan NIM, dan Nama Panjang benar dan Lengkap.';

      $jsonResponse = json_encode($response);
    }

    echo $jsonResponse;
  }

  public function checkIfMahasiswaExist($name, $nim)
  {
    $equalTo = sprintf("%s(%s)", strtoupper($name), $nim);
    $query = str_replace(" ", "%20", $name);
    $result = $this->curlDataMahasiswa($query);
    $data = json_decode($result, true);
    $data = $data['mahasiswa'];


    foreach ($data as $i) {
      $dataMhs = explode(",", $i['text']);
      if ($equalTo == $dataMhs[0]) {
        return true;
      }
    }
    return false;
  }

  public function curlDataMahasiswa($query)
  {
    $url = "https://api-frontend.kemdikbud.go.id/hit_mhs/" . $query;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
  }

  public function registerprocess()
  {
    $post = $this->input->post();

    if (!empty($_FILES['ktp']['name'])) {
      $config['upload_path']          = './assets/image';
      $config['allowed_types']        = 'jpg|png|jpeg';
      $config['max_size']             = 0;
      $config['max_width']            = 0;
      $config['max_height']           = 0;
      $config['overwrite']            = FALSE;
      $config['remove_spaces']        = TRUE;

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('ktp')) {
        print_r($this->upload->display_errors());
        $this->registration();
      } else {
        //upload to firebase
        $defaultBucket = $this->firebaseConn->getStorage();
        $name = $_FILES['ktp']['name'];
        $name = str_replace(' ', '_', $name);


        $uploadedfile = fopen('./assets/image/' . $name, 'r');
        $uploadedName = $this->upload->data('raw_name') . time() . $this->upload->data('file_ext');

        $defaultBucket->getBucket()->upload($uploadedfile, ['name' =>  $uploadedName]);

        unlink('./assets/image/'. $name);

        $image_url = "https://firebasestorage.googleapis.com/v0/b/auction-website-1cc67.appspot.com/o/" . $uploadedName;

        $data = [
          'user_name' => $post['name'],
          'user_email' => $post['email'],
          'user_password' => md5($post['password']),
          'nim' => $post['nim'],
          'role' => 0,
          'ktp' => $image_url,
          'is_verified' => 1
        ];

        $this->m_base->insertTable('user', $data);

        echo "success";
      }
    }

    echo "KTP is required";
  }

  public function verifyUser($age, $birthDateNIK, $birthDateInput, $min, $max, $genderNIK, $genderImage)
  {
    if (($min <= $age) && ($max <= $age)) {
      if (($birthDateNIK == $birthDateInput) && ($genderNIK == $genderImage)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }



  public function identifyImageGenderAndAge($file)
  {
    /* API URL */
    $url = 'http://127.0.0.1:5000/validate-kyc';

    /* Init cURL resource */
    $ch = curl_init($url);

    $cfile = new CURLFile($file['tmp_name'], $file['type'], $file['name']);

    /* Array Parameter Data */
    $data = ['imagefile' => $cfile];

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

  public function getAgeandGenderFromNIK($nik)
  {
    $data = array();
    $data['provinsi'] = substr($nik, 0, 2);
    $data['kota'] = substr($nik, 2, 2);
    $data['kecamatan'] = substr($nik, 4, 2);
    $data['tanggal_lahir'] = substr($nik, 6, 2);
    $data['bulan_lahir'] = substr($nik, 8, 2);
    $data['tahun_lahir'] = substr($nik, 10, 2);
    $data['unik'] = substr($nik, 12, 4);
    if (intval($data['tanggal_lahir']) > 40) {
      $data['tanggal_lahir_2'] = intval($data['tanggal_lahir']) - 40;
      $gender = 'Female';
    } else {
      $data['tanggal_lahir_2'] = intval($data['tanggal_lahir']);
      $gender = 'Male';
    }

    if ($data['tahun_lahir'] < 30) {
      $data['tahun_lahir'] = '20' . $data['tahun_lahir'];
    } else {
      $data['tahun_lahir'] = '19' . $data['tahun_lahir'];
    }

    $bornDate = sprintf("%s/%s/%s", $data['bulan_lahir'], $data['tanggal_lahir'], $data['tahun_lahir']);

    $age = $this->countAge($bornDate);

    $ageGender['age'] = $age;
    $ageGender['gender'] = $gender;
    $ageGender['birthdate'] = sprintf("%s-%s-%s", $data['tahun_lahir'], $data['bulan_lahir'], $data['tanggal_lahir']);

    return $ageGender;
  }

  public function countAge($birthDate)
  {
    // $birthDate = "12/17/1983";
    //explode the date to get month, day and year
    $birthDate = explode("/", $birthDate);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
      ? ((date("Y") - $birthDate[2]) - 1)
      : (date("Y") - $birthDate[2]));


    return $age;
  }

  public function bulan($i)
  {
    $i = intval($i) - 1;
    $data = array(
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );
    if (isset($data[$i])) {
      return trim($data[$i]);
    }
    return '<span class="error">Invalid</span>';
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect(base_url());
  }

  public function forgot_password()
  {
    $this->load->view('auth/forgot_password');
  }

  public function forgot_password_process()
  {
    $post = $this->input->post();

    $dataUpdate = [
      'user_password' => md5($post['password'])
    ];

    $this->db->where('user_email', $post['email']);
    $this->db->update('user', $dataUpdate);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    Congratulation! you successfully change your password. Go Login!.
    </div>');

    redirect(base_url('auth/login'));
  }
}
