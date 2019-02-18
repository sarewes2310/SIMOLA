<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
// Class yang digunakan untuk memanggil tammpilan pada website
//
class User extends CI_Controller {


	public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
    }
	
	public function index() 
	{
		# fungsi yang digunakan untuk memanggil halaman awal
		$this->load->view('login');
	}
}
