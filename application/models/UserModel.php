<?php
/*
# CLASS yang digunakan untuk mengambil atau memanggil data dari database PostgresSql
# parameter default dari semua function yaitu:
# 1. $data   (mengambil data dari controller)
# 2. $id     (mengambil id dari controller)
# 3. $offset (mengambil kelipatan dari sebuah pencarian data hanya digunakan pada function getAllUserM)
*/
class UserModel extends CI_Model
{

    function getListDevice()
    {
        return $this->db->query("SELECT * FROM device;")->result_array();
    }
    
    function getListAuth()
    {
        return $this->db->query("SELECT * FROM users;")->result_array();
    }
    
    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menghasilkan output PENCARIAN DATA pada tabel users dalam database PostgresSql dalam bentuk array.
    # bernilai null atau 0 jika saat data yang dicari tidak ada.
    # ------------------------------------------------------------------------------------------------------------------------------------
    function searchUserMAND($data)
    {
        $hasil = '';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= " AND ";
        }
        return $this->db->query("SELECT * FROM users INNER JOIN authorizations ON users.idus = authorizations.idus WHERE ".$hasil." AND authorizations.idau=4;")->result_array();      
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menghasilkan output SEMUA DATA pada tabel users dalam database PostgresSql dalam bentuk array.
    # bernilai null atau 0 jika data tidak ada.
    # ------------------------------------------------------------------------------------------------------------------------------------
    function getAllUserM($offset)
    {
        return $this->db->query("SELECT * FROM users INNER JOIN authorizations ON users.idus = authorizations.idus ORDER BY users.idus LIMIT 12 OFFSET ".$offset.";")->result_array();
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk INPUT DATA pada tabel users dalam database PostgresSql.
    # hasil bernilai null jika atau 0 saat data yang di simpan berhasil.
    # ------------------------------------------------------------------------------------------------------------------------------------
    function inputUserM($data)
    {
        $hasil = 'VALUES (';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= "'".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("INSERT INTO users (nama,username,password,email) ".$hasil.";");
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk INPUT DATA pada tabel authorizations dalam database PostgresSql.
    # hasil bernilai null jika atau 0 saat data yang di simpan berhasil.
    # ------------------------------------------------------------------------------------------------------------------------------------
    function inputUserMAuth($data)
    {
        $hasil = 'VALUES (';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $value;
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("INSERT INTO authorizations (idau,idus) ".$hasil.";");
    }

    # ------------------------------------------------------------------------------------------------------------------------------------
    # fungsi yang digunakan untuk menghasilkan output PENCARIAN DATA pada tabel users dalam database PostgresSql dalam bentuk array.
    # bernilai null atau 0 jika saat data yang dicari tidak ada.
    # ------------------------------------------------------------------------------------------------------------------------------------
    function searchUserinputUserMAuth($data)
    {
        $hasil = '';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= " AND ";
        }
        return $this->db->query("SELECT idus FROM users WHERE ".$hasil.";")->result_array();      
    }

    function saveEditUserM($id,$data)
    {
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        return $this->db->query("UPDATE users ".$hasil." WHERE idus=".$id.";");
    }

    function saveEditUserMAuth($id,$data)
    {
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        return $this->db->query("UPDATE authorizations ".$hasil." WHERE idus=".$id.";");
    }

    function deleteUserM($id)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk DELETE DATA pada tabel users dalam database PostgresSql.
        # hasil bernilai null jika atau 0 saat data yang di delete berhasil.
        # ------------------------------------------------------------------------------------------------------------------------------------
        return $this->db->query("DELETE FROM users WHERE idus=".$id.";");
    }
    
    function saveATDropbox()
    {
        # BELUM JADI
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("UPDATE  fingerP ".$hasil." WHERE idus=".$id.";")->result_array();
    }

    function saveSHA256FP()
    {
        # BELUM JADI
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("UPDATE  fingerP ".$hasil." WHERE idus=".$id.";")->result_array();
    }

    function saveDeviceM($data)
    {
        $hasil = 'VALUES (';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= "'".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("INSERT INTO device(nama,check_connect) ".$hasil.";");
        #return $this->db->query("insert into device(nama,check_connect) values;");
    }

    function checkDeviceM($id)
    {
        return $this->db->query("SELECT * FROM device WHERE nama='".$id."';")->result_array();
    }

    function editDeviceM($id,$data)
    {
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        return $this->db->query("UPDATE device ".$hasil." WHERE nama='".$id."';");
        #return $this->db->query("INSERT INTO device(nama,check_connect) ".$hasil.";");
        #return $this->db->query("insert into device(nama,check_connect) values;");
    }

    function checkDeviceMid($id)
    {
        return $this->db->query("SELECT device_id FROM device WHERE device_id=".$id.";")->result_array();
    }

    function offDeviceM($id, $data)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk mematikan device pada tabel device dalam database PostgresSql dalam bentuk array.
        # bernilai null atau 0 jika data gagal di update.
        # ------------------------------------------------------------------------------------------------------------------------------------
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        return $this->db->query("UPDATE device ".$hasil." WHERE device_id=".$id.";");
    }

    function getViewEditProfilM($id)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk menghasilkan output SEMUA DATA pada tabel users dalam database PostgresSql dalam bentuk array.
        # bernilai null atau 0 jika data tidak ada.
        # ------------------------------------------------------------------------------------------------------------------------------------
        return $this->db->query("SELECT * FROM users INNER JOIN authorizations ON users.idus = authorizations.idus WHERE users.idus=".$id.";")->result_array();
    }

    function saveEditProfilM($id,$data)
    {
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        return $this->db->query("UPDATE users ".$hasil." WHERE idus=".$id.";");
    }

    function get_data_pdf($data)
    {
        return $this->db->query("SELECT users.nama AS nama, DATE(laporan.last_masuk) AS tanggal, cast(laporan.last_masuk::timestamp as time) AS time FROM laporan INNER JOIN users ON 
            laporan.idus = users.idus WHERE laporan.last_masuk BETWEEN '".$data['tgl_awal']."' AND '".$data['tgl_akhir']."';")->result_array();   
    }

    function search_pdf_users($username)
    {
        return $this->db->query("SELECT * FROM users WHERE username='".$username."';")->result_array();      
    }  
    function insert_data_pdf($data)
    {   
        return $this->db->query("INSERT INTO laporan (idus,last_masuk) VALUES('".$data['idus']."','".$data['tanggal']."');"); 
    }
}
?>