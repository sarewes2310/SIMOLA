<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
# Class yang digunakan untuk mentest function dari seluruh controller sebelum di pakai.
# hanya digunakan pada saat proses debugging saja.
*/
class Testing extends CI_Controller 
{
    public function __construct()
    {
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
    
    public function getFromServerJS()
    {
        var_dump($_POST);
        //var_dump($_GET);
        foreach($_POST as $val){
            echo $val;
        }
        #echo $_POST;
    }

    public function testDropboxAccessToken()
    {
        header('Location: https://www.dropbox.com/oauth2/authorize?client_id=52u9mwxlcxgv1j2&response_type=code&redirect_uri=https://simola.herokuapp.com/index.php/testing/getDropBoxAT/');
    }

    public function getDropBoxAT()
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
            CURLOPT_POSTFIELDS => "code=".substr($_SERVER['QUERY_STRING'],5)."&grant_type=authorization_code&redirect_uri=https%3A%2F%2Fsimola.herokuapp.com%2Findex.php%2Ftesting%2FgetDropBoxAT%2F",
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

    public function testFCM()
    {
        redirect("https://simola.herokuapp.com/index.php/User/");
    }
}
