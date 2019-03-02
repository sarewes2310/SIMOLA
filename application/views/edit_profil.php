<?php
echo json_encode('
<form action="https://lembarkerjasiswa.herokuapp.com/index.php/Login/submitGuru" method="post" accept-charset="utf-8" id="guruLogin">
    <div class="form-group row">
	    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
	    <div class="col-sm-10">
	    	<input type="text" class="form-control" id="nama" placeholder="Nama">
	    </div>
	</div>
    <div class="form-group row">
		<label for="username" class="col-sm-2 col-form-label">Username</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="username" placeholder="Username">
	    </div>
    </div>
    <div class="form-group row">
	    <label for="email" class="col-sm-2 col-form-label">Email</label>
	    <div class="col-sm-10">
	    	<input type="email" class="form-control" id="email" placeholder="Email">
	    </div>
	</div>
	<div class="form-group row">
	    <label for="password" class="col-sm-2 col-form-label">Password</label>
	    <div class="col-sm-10">
	    	<input type="password" class="form-control" id="password" placeholder="Password">
	    </div>
	</div>
	<div><button id="buttonSubmit" type="submit" class="btn btn-primary">Login</button></div>
</form>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>