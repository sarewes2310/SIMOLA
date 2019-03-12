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
<img src="'.base_url().'assets/logo/dropbox-logo_2.jpg">
<button id="getdropbox" onclick="return clickDropbox()" type="button" class="btn btn-danger" href="'.base_url().'index.php/user/getDropboxLink">Logout DropBox</button>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>