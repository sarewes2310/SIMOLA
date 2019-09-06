<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
# Class yang digunakan untuk memanggil tammpilan pada website (sebagai route dari aplikasi)
# seluruh tampilan di control dengan menggunakan kelas ini. untuk alur proses penggunaan data menggunakan class Controller DataUser
*/
class User extends CI_Controller 
{   
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->model("UserModel");
    }
	
	public function index() 
	{
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk memanggil halaman login 
        # Output berupa page login
        # ------------------------------------------------------------------------------------------------------------------------------------
        if(empty($this->session->idus) && empty($this->input->get('idus'))){
            $this->load->view('login');
        }
        else {
            #$this->dashboard();
            redirect("https://simola.herokuapp.com/index.php/user/dashboard");
        }
    }
    
    public function dashboard()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk memanggil halaman login 
        # Output berupa page dashboard
        # ------------------------------------------------------------------------------------------------------------------------------------
        if(empty($this->session->idus) && empty($this->input->get('idus'))){
            redirect("https://simola.herokuapp.com");
        }else{
            $this->load->view('dashboard');
        }
    }

    public function getViewDashboard(){
        if(empty($this->session->idus) && empty($this->input->post('idus'))){
            redirect("https://simola.herokuapp.com");
        }else{
            $hasil = $this->UserModel->getListDevice();
            $h['data'] = $hasil;
            $this->load->view('view_online',$h);
        }
    }

    public function getViewUser(){
        if(empty($this->session->idus) && empty($this->input->post('idus'))){
            redirect("https://simola.herokuapp.com");
        }else{
            $hasil = $this->UserModel->getAllUserM(0);
            #var_dump($hasil);
            $h['data'] = $hasil;
            $this->load->view('user_view',$h);
        }
    }

    public function getViewEditProfil(){
        if(empty($this->session->idus) && empty($this->input->post('idus')))
        {
            #var_dump($this->input->post('idus'));
            redirect("https://simola.herokuapp.com");
        }
        else
        {
            if(empty($this->session->idus)){
                $hasil = $this->UserModel->getViewEditProfilM($this->input->post('idus'));
            }else{
                $hasil = $this->UserModel->getViewEditProfilM($this->session->idus);
            }
            #var_dump($hasil);
            $h['data'] = $hasil[0];
            $this->load->view('edit_profil',$h);
        }
        #var_dump($this->input->post('idus'));
    }

    public function getViewNotification(){
        $this->load->view('request_permission');
    }

    public function getViewDropbox()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk memanggil halaman dropbox
        # Output berupa page dropbox
        # ------------------------------------------------------------------------------------------------------------------------------------
        if(empty($this->session->idus) && empty($this->input->post('idus'))){
            redirect("https://simola.herokuapp.com");
        }else{
            if(empty($this->session->idus)){
                $hasil = $this->UserModel->getViewEditProfilM($this->input->post('idus'));
            }else{
                $hasil = $this->UserModel->getViewEditProfilM($this->session->idus);
            }
            if(empty($hasil[0]['at']))$this->load->view('dropbox_auth');
            else $this->load->view('dropbox_response');
        }
    }

    public function getDropboxLink()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk mendapatkan link authorization dropbox
        # Output berupa link menuju page authorization yang disediakan oleh dropbox dan callback ke function getDropBoxAT()
        # ------------------------------------------------------------------------------------------------------------------------------------
		header('Location: https://www.dropbox.com/oauth2/authorize?client_id=52u9mwxlcxgv1j2&response_type=code&redirect_uri=https://simola.herokuapp.com/index.php/user/getDropBoxAT/');
	}

    public function getDropboxAT()
    {
		#echo $_SERVER['HTTP_HOST']; 
        #echo substr($_SERVER['QUERY_STRING'],5);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.dropboxapi.com/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "code=".substr($_SERVER['QUERY_STRING'],5)."&grant_type=authorization_code&redirect_uri=https%3A%2F%2Fsimola.herokuapp.com%2Findex.php%2Fuser%2FgetDropBoxAT%2F",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic NTJ1OW13eGxjeGd2MWoyOmV0cG1vYjkwOW0yM3hlMg==",
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            #   echo $response;
            $response = json_decode($response);
        }
        $ch = curl_init();
        $data = array(
            
        );
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://simolasocket-nodejs.herokuapp.com/sendAT?at=".$response->{'access_token'}."&id=".$this->session->idus,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            //CURLOPT_POSTFIELDS => "at=".$response->{'access_token'},
            //CURLOPT_HTTPHEADER => array(
            //    "Authorization: Basic NTJ1OW13eGxjeGd2MWoyOmV0cG1vYjkwOW0yM3hlMg==",
            //    "cache-control: no-cache"
            //),
        ));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //$this->load->view('');
            redirect("https://simola.herokuapp.com/index.php/user/dashboard");
        }
	}

    public function logout()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk logout session user
        # Output berupa menghapus session user
        # ------------------------------------------------------------------------------------------------------------------------------------
        $this->session->sess_destroy();
        $session = array();
        $session['link'] = base_url();
        echo json_encode($session,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);        
    }

    public function print_pdf()
    {
        $this->load->library('pdf');
    }

    public function view_print_pdf()
    {
        $this->load->view('view_laporan');
    }
}