<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataUser extends CI_Controller {

	public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->model("UserModel");
    }
	
	public function index()
	{
		var_dump($this->UserModel->getListAuth());
		echo sys_get_temp_dir();
    }
    public function submitUserLogin(){
        
    }
}
