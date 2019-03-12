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
<img src="'.base_url().'assets/logo/dropbox-logo_2.jpg">
<button id="getdropbox" onclick="return clickDropbox()" type="button" class="btn btn-primary" href="'.base_url().'index.php/user/getDropboxLink">Login DropBox</button>
<!--<form action="https://lembarkerjasiswa.herokuapp.com/index.php/Login/submitGuru" method="post" accept-charset="utf-8" id="guruLogin">
	<div class="form-group row">
		<label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="username" placeholder="Username">
	    </div>
	</div>
	<div class="form-group row">
	    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
	    <div class="col-sm-10">
	    	<input type="password" class="form-control" id="password" placeholder="Password">
	    </div>
	</div>
	<div><button id="buttonSubmit" type="submit" class="btn btn-primary">Login</button></div>
</form>-->
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>