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
        
    }
}
