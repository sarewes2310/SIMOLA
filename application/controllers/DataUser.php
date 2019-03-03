<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#
# Class yang digunakan untuk memanggil fungsi yang ada pada website (sebagai CRUD dari aplikasi)
#
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
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk menghasilkan output PENCARIAN DATA pada tabel users dalam database PostgresSql dalam bentuk array.
        # bernilai null atau 0 jika saat data yang dicari tidak ada.
        # ------------------------------------------------------------------------------------------------------------------------------------
        foreach($this->input->post() as $key => $value){
            echo $key." ".$value."<br>";
        }
        $hasil = $this->UserModel->searchUserMAND($this->input->post());
        //var_dump($hasil);
        if(empty($hasil)){
            header('Location:'.base_url());   
        }else{
            $session = [];
			foreach ($hasil as $value) {
				foreach ($value as $key => $isi) {
					$session[$key] = $isi; # inisialisasi dari session
				}
            }
            $this->session->set_userdata($session);
			header('Location:https:'.base_url().'index.php/User/dashboard');
        }
    }
    
    public function inputUser()
    {
        $hasil = $this->UserModel->inputUserM($this->input->post());
        var_dump($hasil);
    }

    public function addFingerPrint(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://simolasocket-nodejs.herokuapp.com/home");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch);
        var_dump($output);
        echo $output;
        curl_close($ch); 
    }

    public function getFingerPrint(){

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
