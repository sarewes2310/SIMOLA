<?php
echo json_encode('
<style>
    p{
        text-align: center;
        font-size: 0.9em;
    }
    img{
        width: calc(100%);
        margin: 10px 0px;
    }
    #getdropbox{
        width:100%;
    }
    body{
        background: #f2f3f2;
    }
</style>
<p>Opsss!! akun anda belum terdaftar pada aplikasi ini</p>
<table class="table">
<tbody>
    <td>Notifications</td>
    <td><button id="rp" onclick="return requestPermission()" type="button" class="btn btn-primary">Login DropBox</button></td>
    <td><button id="dp" onclick="return deleteToken()" type="button" class="btn btn-danger">Login DropBox</button></td>
</tbody>
</table>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>