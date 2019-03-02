<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller 
{
    ##########################################################################################################################################
    # Class yang digunakan untuk memanggil tammpilan pada website (sebagai route dari aplikasi)
    # seluruh tampilan di control dengan menggunakan kelas ini. untuk alur proses penggunaan data menggunakan class Controller DataUser
    ##########################################################################################################################################
    
    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
    }
	
	public function index() 
	{
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk memanggil halaman login 
        # Output berupa page login
        # ------------------------------------------------------------------------------------------------------------------------------------
		$this->load->view('login');
    }
    
    public function dashboard()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk memanggil halaman login 
        # Output berupa page dashboard
        # ------------------------------------------------------------------------------------------------------------------------------------
		$this->load->view('dashboard');
    }

    public function getViewDashboard(){
    
    }

    public function getViewUser(){
        $this->load->view('user_view');
    }

    public function getViewEditProfil(){
        $this->load->view('edit_profil');
    }

    public function getViewDropbox()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # Fungsi yang digunakan untuk memanggil halaman dropbox
        # Output berupa page dropbox
        # ------------------------------------------------------------------------------------------------------------------------------------
        $this->load->view('dropbox_auth');
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
            CURLOPT_POSTFIELDS => "code=".substr($_SERVER['QUERY_STRING'],5)."&grant_type=authorization_code&redirect_uri=https%3A%2F%2Fsimola.herokuapp.com%2Findex.php%user%2FgetDropBoxAT%2F",
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
            #echo $response;
            $response = json_decode($response);
        }
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://simolasocket-nodejs.herokuapp.com/sendAT?at=".$response->{'access_token'},
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
            echo $response;
        }
	}

    public function logout()
    {
        $this->session->sess_destroy();
    }
}
