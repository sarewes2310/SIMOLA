<?php
class UserModel extends CI_Model
{
    ##########################################################################################################################################
    # CLASS yang digunakan untuk mengambil atau memanggil data dari database PostgresSql
    # parameter default dari semua function yaitu:
    # 1. $data   (mengambil data dari controller)
    # 2. $id     (mengambil id dari controller)
    # 3. $offset (mengambil kelipatan dari sebuah pencarian data hanya digunakan pada function getAllUserM)
    ##########################################################################################################################################

    function getListDevice()
    {
        return $this->db->query("SELECT * FROM device;")->result_array();
    }
    
    function getListAuth()
    {
        return $this->db->query("SELECT * FROM users;")->result_array();
    }
    
    function searchUserMAND($data)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk menghasilkan output PENCARIAN DATA pada tabel users dalam database PostgresSql dalam bentuk array.
        # bernilai null atau 0 jika saat data yang dicari tidak ada.
        # ------------------------------------------------------------------------------------------------------------------------------------
        $hasil = '';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= " AND ";
        }
        return $this->db->query("SELECT * FROM users WHERE ".$hasil.";")->result_array();      
    }

    function getAllUserM($offset)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk menghasilkan output SEMUA DATA pada tabel users dalam database PostgresSql dalam bentuk array.
        # bernilai null atau 0 jika data tidak ada.
        # ------------------------------------------------------------------------------------------------------------------------------------
        return $this->db->query("SELECT * FROM users LIMIT 20 OFFSET ".$offset.";")->result_array();
    }

    function inputUserM($data)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk INPUT DATA pada tabel users dalam database PostgresSql.
        # hasil bernilai null jika atau 0 saat data yang di simpan berhasil.
        # ------------------------------------------------------------------------------------------------------------------------------------
        $hasil = 'VALUES (';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("INSERT INTO users (nama,username,password,email) ".$hasil.";")->result_array();
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
        $hasil .= ")";
        return $this->db->query("UPDATE users ".$hasil." WHERE idus=".$id.";")->result_array();
    }

    function deleteUserM($id)
    {
        # ------------------------------------------------------------------------------------------------------------------------------------
        # fungsi yang digunakan untuk DELETE DATA pada tabel users dalam database PostgresSql.
        # hasil bernilai null jika atau 0 saat data yang di delete berhasil.
        # ------------------------------------------------------------------------------------------------------------------------------------
        return $this->db->query("DELETE FROM users WHERE idus=".$id.";")->result_array();
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

    function saveDeviceM($data){
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

    function checkDeviceM($id){
        return $this->db->query("SELECT * FROM device WHERE nama='".$id."';")->result_array();
    }

    function editDeviceM($id,$data){
        $hasil = 'SET ';
        $length = count($data); # menghitung jumlah panjang dari array variabel data
        $num = 1; # set awal dari sebuah variabel penghitung jumlah iterasi (alasan menggunakan angka set awal 1 bukan 0 karena ingin dimudahkan saat membaca)
        foreach($data as $key => $value){
            $num++;
            $hasil .= $key."='".$value."'";
            if($num<=$length)$hasil .= ",";
        }
        $hasil .= ")";
        return $this->db->query("UPDATE device ".$hasil." WHERE nama='".$id."';");
        #return $this->db->query("INSERT INTO device(nama,check_connect) ".$hasil.";");
        #return $this->db->query("insert into device(nama,check_connect) values;");
    }
}
?>