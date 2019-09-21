<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*#
*
* Class yang digunakan untuk memanggil fungsi yang ada pada website (sebagai CRUD dari aplikasi)
*
*/
class DataUser extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->model("UserModel");
    }
	
	# ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang dippakai untuk checl session dari user
    # bernilai 1 jika saat data yang dicari tidak ada.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function index()
	{
        # FUNGSI TIDAK DIPAKAI
		var_dump($this->UserModel->getListAuth());
		echo sys_get_temp_dir();
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menghasilkan output SESSION LOGIN pada tabel users dalam database PostgresSql dalam bentuk array.
    # bernilai 1 jika saat data yang dicari tidak ada.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function submitUserLogin()
    {
        $hasil = $this->UserModel->searchUserMAND($this->input->post()); # Get from UserModel Model Class
        //var_dump($hasil); # MODE DEBUGGING
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
            #var_dump($_SESSION);
            #array_push($session, 0, base_url().'index.php/User/dashboard');
            $session['status'] = 0;
            $session['link'] = base_url().'index.php/User/dashboard';
			echo json_encode($session,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
    }
    
    public function inputUser()
    {
        $data = array(
            'nama' => $this->input->post('nama'), # mengambil data post dengan index "nama"
            'username' => $this->input->post('username'), # mengambil data post dengan index "username"
            'password' => $this->input->post('password'), # mengambil data post dengan index "password"
            'email' => $this->input->post('email') # mengambil data post dengan index "email"
        );   
        $hasil = $this->UserModel->inputUserM($data);
        if($hasil){
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $hasil = $this->UserModel->searchUserinputUserMAuth($data);
            if($hasil){
                #var_dump($hasil);
                $data = array(
                    "idau" => $this->input->post('idau'),
                    "idus" => $hasil[0]['idus']
                );
                $hasil = $this->UserModel->inputUserMAuth($data);
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
        }
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang digunakan untuk mengedit sidik jari pada rasoberry
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function editFingerPrint()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://simolasocket-nodejs.herokuapp.com/editfingerprint?us=".$this->input->post("username")."&usold=".$this->input->post("usernameold"),
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang digunakan untuk menambah sidik jari pada raspberry
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function addFingerPrint()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://simolasocket-nodejs.herokuapp.com/addfingerprint?us=".$this->input->post("username"),
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang digunakan untuk menghapus sidik jari pada raspberry
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function removeFingerPrint()
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://simolasocket-nodejs.herokuapp.com/removefingerprint?us=".$this->input->post("username"),
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

    public function getFingerPrint()
    {
        var_dump($this->input->post());
        $this->UserModel->saveSHA256FP($this->input->post());
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menampilkan data users pada tabel users untuk diedit dalam database PostgresSql dalam bentuk array.
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function getDataEditUser()
    {
        $hasil = $this->UserModel->getViewEditProfilM($this->input->post('idus'));
        if(!empty($hasil)){
            echo json_encode(array(
                $hasil[0]
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);       
        }
    }
    
    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk mengedit data users pada tabel users dalam database PostgresSql dalam bentuk array.
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function saveEditUser()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
        );
        $hasil = $this->UserModel->saveEditUserM($this->input->post('idus'),$data);
        if($hasil){
            $data = array(
                'idus' => $this->input->post('idus'),
                'idau' => $this->input->post('idau')
            );
            $hasil = $this->UserModel->saveEditUserMAuth($this->input->post('idus'),$data);
            if($hasil){
                echo json_encode(array(
                    'status' => 1
                ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
            }else{
                echo json_encode(array(
                    'status' => 0
                ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
            }
        }else{
            echo json_encode(array(
                'status' => 0
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menghapus data user pada tabel users dalam database PostgresSql dalam bentuk array.
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk mengedit data profil pada tabel profil dalam database PostgresSql dalam bentuk array.
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function saveEditProfil()
    {
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk  mengedit keadaan device pada tabel device dalam 
    # database PostgresSql dalam bentuk array. dipanggil dari server socketio. hanya
    # dipanggil pada saat device connect dari server socketio
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function checkDevice()
    {
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk  mengedit keadaan device pada tabel device dalam 
    # database PostgresSql dalam bentuk array. dipanggil dari server socketio. hanya
    # dipanggil pada saat device disconnect dari server socketio
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function disconnectkDevice()
    {
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

    public function curl_settings($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
        return $curl;
    }
    
    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menampilkan data device pada model di file view_online.php dengan mengambil tabel device dalam 
    # database PostgresSql dalam bentuk array. bernilai  status 1 jika device ada.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function getDevice() # fungsi yang digunakan untuk menampilkan data device pada model di file view_online.php dengan mengambil tabel device dalam 
    {
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk mengedit data off device pada tabel device dalam database PostgresSql dalam bentuk array.
    # bernilai 1 jika saat data berhasil disimpan.
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function offDevice()
    {
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

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang dipakai untuk mengedit access token dropbox pada sistem
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function updateATDevice()
    {
        #var_dump($this->input->post());
        $data = array(
            'at' => $this->input->post('at')
        );
        $hasil = $this->UserModel->editDeviceM($this->input->post('nama'),$data);
        if($hasil){
            $hasil = $this->UserModel->saveEditProfilM($this->input->post('idus'),$data);
        }
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang dipakai untuk menghapus access token dropbox pada sistem
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function removeATDevice()
    {
        #var_dump($this->input->post());
        $data = array(
            'at' => ''
        );
        $hasil = $this->UserModel->saveEditProfilM($this->input->post('id'),$data);
        if($hasil){
        #    $hasil = $this->UserModel->saveEditProfilM($this->input->post('idus'),$data);
            #redirect("https://simola.herokuapp.com/index.php/User/");
            echo json_encode(array(
                'status' => 1
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);   
        }else{
            echo json_encode(array(
                'status' => 0
            ),JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
        }
    }

    public function viewUser(){
        if(empty($this->session->idus) && empty($this->input->post('idus'))){
            redirect("https://simola.herokuapp.com");
        }else{
            $hasil = $this->UserModel->getAllUserM($this->input->post('offset'));
            #var_dump($hasil);
            $h['data'] = $hasil;
            echo json_encode($hasil,JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);  
        }
    }
    
    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk  mengedit keadaan device pada tabel device dalam 
    # database PostgresSql dalam bentuk array. dipanggil dari server socketio. hanya
    # dipanggil pada saat device connect dari server socketio
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function updatebuzzer()
    {
        #var_dump($this->input->post());   
        $data = array(
            'nama' => $this->input->post('device'),
            'buzzer' => $this->input->post('buzzer')
        );
        $check = $this->UserModel->checkDeviceM($data['nama']);
        var_dump(empty($check));
        if(empty($check)){
            $hasil = $this->UserModel->saveDeviceM($data);
            var_dump($hasil);
        }else{
            $data1 = array(
                'buzzer' => $this->input->post('buzzer')
            );
            $hasil = $this->UserModel->editDeviceM($data['nama'],$data1);
            var_dump($hasil);
        }
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang dipakai untuk menampilkan menu laporan
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function view_print_pdf()
    {
        $this->load->view('view_laporan');
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang dipakai untuk menambah data laporan user yang masuk lab pada sistem
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function add_data_laporan()
    {
        $data = $this->input->post();
        $hasil = $this->UserModel->search_pdf_users($data['username']);
        //var_dump($hasil);
        if(empty($hasil))
        {
            echo json_encode(array('messages' => 0));
        }else
        {
            foreach ($hasil as $key => $value) {
                # code...
                $new_data = array(
                    'idus' => $value['idus'],
                    'tanggal' => $data['tanggal'],
                );
                $cek = $this->UserModel->insert_data_pdf($new_data);
                if($cek)
                {
                    echo json_encode(array('messages' => 1));
                }else
                {
                    echo json_encode(array('messages' => 0));
                }
            }
        }
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # Fungsi yang dipakai untuk menjalankan perintah dowload file pdf dari laporan pada sistem
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function download_print_pdf_laporan()
    {
        $data = $this->input->post();
        $data = array(
            'tgl_awal'  => $data['tgl_awal'],
            'tgl_akhir' => $data['tgl_akhir'], 
        );
        $hasil = $this->UserModel->get_data_pdf($data);
        //echo json_encode($hasil);
        $this->screen_pdf($hasil);
    }
    
    # ------------------------------------------------------------------------------------------------------------------------------------
    # FORMAT LAPORAN PDF
    # ------------------------------------------------------------------------------------------------------------------------------------
    public function screen_pdf($hasil)
    {
        $this->load->library('Pdf');
        $pdf = new FPDF('l','mm','A5');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190,7,'SEKOLAH MENENGAH ATAS NEGRI 1 LIMBANGAN',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'DAFTAR PENGGUNA LAB KOMPUTER SMA NEGERI 1 LIMBANGAN',0,1,'C');
        $pdf->Cell(10,7,'',0,1); 
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(15,6,'NO',1,0);
        $pdf->Cell(85,6,'NAMA ',1,0);
        $pdf->Cell(27,6,'JAM',1,0);
        $pdf->Cell(25,6,'TANGGAL',1,1);
        $pdf->SetFont('Arial','',10);
        $i = 1;
        foreach ($hasil as $key => $value) {
            $pdf->Cell(15,6,$i,1,0);
            $pdf->Cell(85,6,$value['nama'],1,0);
            $pdf->Cell(27,6,$value['time'],1,0);
            $pdf->Cell(25,6,$value['tanggal'],1,1);                
            $i++;
        }
        /*foreach ($hasil as $key => $value) {
            var_dump($value['nama']);
        }*/
        $pdf->Output();
    }

    public function download_settings_pdf()
    {

    }
}
