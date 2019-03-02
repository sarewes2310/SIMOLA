<?php
echo json_encode('
<style>
    #boxfingerprint{
        border: 3px solid #a9a9a938;
        border-style: dashed;
        background: #a9a9a938;
        padding: 9px;
        border-radius: 8px;
        margin: 10px 0px;
    }
    img{
        width: calc(100% / 2.5);
        vertical-align: baseline;
        margin: 0px calc(100% / 4);
    }
</style>
<form action="#" id="editprofil">
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
    <div id="boxfingerprint">
        <img src="'.base_url().'assets/logo/fingerprints.png">
        <button id="buttonSubmit" type="submit" class="btn btn-primary" style="width:100%">Edit Fingerprint</button>
    </div>
	<div class="form-group row" style="display:none">
	    <div class="col-sm-10">
	    	<input type="text" class="form-control" id="fingerprint" placeholder="fingerprint">
	    </div>
    </div>
	<div><button id="buttonSubmit" type="submit" class="btn btn-success" style="width:100%">SUBMIT</button></div>
</form>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>