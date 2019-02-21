<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
// Class yang digunakan untuk memanggil tammpilan pada website
//
class Testing extends CI_Controller {


	public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
    }
	
	public function test() 
	{
		# fungsi yang digunakan untuk memanggil halaman awal
        # $this->load->view('login');
        # set_time_limit(1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://simolasocket-nodejs.herokuapp.com/home");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        var_dump($output);
        echo $output;
        curl_close($ch); 
    }
    
    public function getFromServerJS(){
        var_dump($_POST[0]);
    }

    public function testDropboxAccessToken(){
        header('Location: https://www.dropbox.com/oauth2/authorize?client_id=52u9mwxlcxgv1j2&response_type=code&redirect_uri=https://simola.herokuapp.com/index.php/testing/getDropBoxAT');
    }

    public function getDropBoxAT(){
        #echo $_SERVER['HTTP_HOST']; 
        #echo $_SERVER['QUERY_STRING'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.dropboxapi.com/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "code=".substr($_SERVER['QUERY_STRING'],5)."&grant_type=authorization_code&redirect_uri=https%3A%2F%2Fsimola.herokuapp.com%2F",
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
            echo $response;
        }
    }
}
