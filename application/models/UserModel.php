<?php
class UserModel extends CI_Model{
    function getListAuth(){
        return $this->db->query("SELECT * FROM users;")->result_array();
    }
}
?>