<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('m_auth');
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

      if ($validate) {
        $data = [
          'name'     => $validate['user_name'],
          'email'     => $validate['user_email'],
          'id'     => $validate['id'],
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

    $nik =  $post['nik'];
    $birthDateInput =  $post['birthdate'];
    $file = $_FILES["image"];

    $dataNIK = $this->getAgeandGenderFromNIK($nik);
    $resultCurl = $this->identifyImageGenderAndAge($file);
    $response = json_decode($resultCurl, true);
    $ageRange = array();
    foreach ($response as $result) {
      $result['age'] = substr($result['age'], 1, -1);
      $numArr =  explode("-", $result['age']);
      array_push($ageRange, $numArr[0], $numArr[1]);
    }
    $minRange = min($ageRange);
    $maxRange = max($ageRange);

    $imageGender = $response[0]['gender'];
    $isUserVerified = $this->verifyUser($dataNIK['age'], $dataNIK['birthdate'], $birthDateInput, $minRange, $maxRange, $dataNIK['gender'], $imageGender);

    var_dump($isUserVerified);
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

  public function kode_provinsi($i)
  {
    $i = intval($i);
    $data = array(
      11 => 'Aceh',
      12 => 'Sumatera Utara',
      13 => 'Sumatera Barat',
      14 => 'Riau',
      15 => 'Jambi',
      16 => 'Sumatera Selatan',
      17 => 'Bengkulu',
      18 => 'Lampung',
      19 => 'Kep. Bangka Belitung',
      21 => 'Kep. Riau',
      31 => 'DKI Jakarta',
      32 => 'Jawa Barat',
      33 => 'Jawa Tengah',
      34 => 'Yogyakarta',
      35 => 'Jawa Timur',
      36 => 'Banten',
      51 => 'Bali',
      52 => 'Nusa Tenggara Barat',
      53 => 'Nusa Tenggara Timur',
      61 => 'Kalimantan Barat',
      62 => 'Kalimantan Tengah',
      63 => 'Kalimantan Selatan',
      64 => 'Kalimantan Timur',
      71 => 'Sulawesi Utara',
      72 => 'Sulawesi Tengah',
      73 => 'Sulawesi Selatan',
      74 => 'Sulawesi Tenggara',
      75 => 'Gorontalo',
      76 => 'Sulawesi Barat',
      81 => 'Maluku',
      82 => 'Maluku Utara',
      91 => 'Papua Barat',
      94 => 'Papua'
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
}
