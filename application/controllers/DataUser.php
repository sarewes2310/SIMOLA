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
        # FUNGSI TIDAK DIPAKAI
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
        $hasil = $this->UserModel->getViewEditProfilM($this->input->post('idus'));
        if(!empty($hasil)){
            echo json_encode(array(
                $hasil
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);       
        }
    }
    
    public function saveEditUser()
    {

    }

    public function deleteUser()
    {
        $hasil = $this->UserModel->deleteUserM($this->input->post('idus'));
        if($hasil){
            echo json_encode(array(
                'status' => 1
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }else{
            echo json_encode(array(
                'status' => 0
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
    }

    public function saveEditProfil()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk mengedit data profil pada tabel users dalam database PostgresSql dalam bentuk array.
        # bernilai 1 jika saat data berhasil disimpan.
        # ------------------------------------------------------------------------------------------------------------------------------------
        #var_dump($this->input->post());
        $data = array(
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
        );
        $hasil = $this->UserModel->saveEditProfilM($this->input->post('idus'),$data);
        if($hasil){
            echo json_encode(array(
                'status' => 1
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }else{
            echo json_encode(array(
                'status' => 0
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
    }

    public function checkDevice(){
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk  mengedit keadaan device pada tabel device dalam 
        # database PostgresSql dalam bentuk array. dipanggil dari server socketio. hanya
        # dipanggil pada saat device connect dari server socketio
        # ------------------------------------------------------------------------------------------------------------------------------------
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

    public function disconnectkDevice()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk  mengedit keadaan device pada tabel device dalam 
        # database PostgresSql dalam bentuk array. dipanggil dari server socketio. hanya
        # dipanggil pada saat device disconnect dari server socketio
        # ------------------------------------------------------------------------------------------------------------------------------------
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
    
    public function getDevice()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk menampilkan data device pada model di file view_online.php dengan mengambil tabel device dalam 
        # database PostgresSql dalam bentuk array. bernilai  status 1 jika device ada.
        # ------------------------------------------------------------------------------------------------------------------------------------
        $hasil = $this->UserModel->checkDeviceMid($this->input->post('device_id'));
        #var_dump($hasil);
        if(!empty($hasil)){
            $hasil = array(
                'status' => 1,
                'device_id' => $hasil[0]['device_id']
            );
           echo json_encode($hasil,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
    }

    public function offDevice()
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk mengedit data off device pada tabel device dalam database PostgresSql dalam bentuk array.
        # bernilai 1 jika saat data berhasil disimpan.
        # ------------------------------------------------------------------------------------------------------------------------------------
        #echo json_encode($this->input->post('device_id'),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        #var_dump($this->input->post('device_id'));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://simolasocket-nodejs.herokuapp.com/shutdown",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            #echo "cURL Error #:" . $err;
            echo json_encode(array(
                'status' => 0
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        } else {
            $data = array(
                'check_connect' => 0
            );
            $hasil = $this->UserModel->offDeviceM($this->input->post('device_id'),$data);
            echo json_encode(array(
                'status' => 1
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
        #var_dump($hasil);
        #if(!empty($hasil)){
        #    $hasil = array(
        #        'status' => 1,
        #        'device_id' => $hasil[0]['device_id']
        #    );
        #   echo json_encode($hasil,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        #}
    }
}
