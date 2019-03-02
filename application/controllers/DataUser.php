<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
// Class yang digunakan untuk memanggil fungsi yang ada pada website (sebagai CRUD dari aplikasi)
//
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
    public function submitUserLogin()
    {
        //$
        //$this->UserModel->searchUserMAND();
    }
    
    public function inputUser()
    {

    }

    public function getDataEditUser()
    {

    }
    
    public function saveEditUser()
    {

    }

    public function deleteUser()
    {

    }

    public function getSaveEditProfil()
    {

    }

    public function saveEditProfil()
    {

    }
}
