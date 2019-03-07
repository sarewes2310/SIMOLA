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
        # fungsi yang digunakan untuk menghasilkan output SESSION LOGIN pada tabel users dalam database PostgresSql dalam bentuk array.
        # bernilai 1 jika saat data yang dicari tidak ada.
        # ------------------------------------------------------------------------------------------------------------------------------------
        // foreach($this->input->post() as $key => $value){
        //    echo $key." ".$value."<br>";
        // }
        $hasil = $this->UserModel->searchUserMAND($this->input->post()); # Get from UserModel Model Class
        //var_dump($hasil);
        if(empty($hasil)){
            $satus = array(
                'status' => 1 # Inisialisasi dari data yang tidak ditemukan   
            );
            echo json_encode($satus,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }else{
            $session = [];
			foreach ($hasil as $value) {
				foreach ($value as $key => $isi) {
                    if($key == 'idus' || $key == 'nama')$session[$key] = $isi; # Inisialisasi dari session
				}
            }
            $this->session->set_userdata($session);
            #array_push($session, 0, base_url().'index.php/User/dashboard');
            $session['status'] = 0;
            $session['link'] = base_url().'index.php/User/dashboard';
			echo json_encode($session,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
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
        //var_dump($output);
        curl_close($ch); 
        echo json_encode($output);
    }

    public function getFingerPrint(){
        var_dump($this->input->post());
        $this->UserModel->saveSHA256FP($this->input->post());
    }

    public function removeFingerPrint(){

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

    public function checkDevice(){
        #var_dump($this->input->post());   
        $data = array(
            'nama' => $this->input->post('device'),
            'check_connect' => 1
        );
        $check = $this->UserModel->checkDeviceM($data['nama']);
        var_dump(empty($check));
        if(empty($check)){
            $hasil = $this->UserModel->saveDeviceM($data);
            var_dump($hasil);
        }else{
            $data1 = array(
                'check_connect' => 1
            );
            $hasil = $this->UserModel->editDeviceM($data['nama'],$data1);
            var_dump($hasil);
        }
    }

    public function disconnectkDevice(){
        #var_dump($this->input->post());   
        $data = array(
            'nama' => $this->input->post('device'),
            'check_connect' => 0
        );
        $check = $this->UserModel->checkDeviceM($data['nama']);
        var_dump(empty($check));
        if(!empty($check)){
            $hasil = $this->UserModel->editDeviceM($data['nama'],$data);
            var_dump($hasil);
        }
    }
}
