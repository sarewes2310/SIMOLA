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

    public function test_Laporan()
    {
        $this->load->model("UserModel");
        /*$data = array(
            'tgl_awal'  => $this->input->post('tgl_awal'),
            'tgl_akhir' => $this->input->post('tgl_akhir')
        );*/
        $data = array(
            'tgl_awal'  => '2019-08-08',
            'tgl_akhir' => '2019-08-10'
        );
        $hasil = $this->UserModel->get_data_pdf($data);
        //echo json_encode($hasil);
        $this->screen_pdf($hasil);
    }

    public function screen_pdf($hasil)
    {
        $this->load->library('Pdf');
        $pdf = new FPDF('l','mm','A5');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190,7,'SEKOLAH MENENGAH KEJURUSAN NEEGRI 2 LANGSA',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'DAFTAR PENGGUNA LAB KOMPUTER SMA NEGERI 12',0,1,'C');
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
}
