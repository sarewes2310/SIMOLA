<?php
$js = '
function parserData(data){
	hasil = "";
	for(var i in data){
		hasil = hasil+(i+"="+data[i]);
		hasil = hasil+"&";
	}
	return new URLSearchParams(hasil)
}

function saveProfilM(){
    const hasil = {
        "nama" : document.getElementById("nama").value,
        "email" : document.getElementById("email").value,
        "username" : document.getElementById("username").value,
        "password" : document.getElementById("password").value,
        "idus" : document.getElementById("idus").value,
    };
    fetch(base_url+"DataUser/saveEditProfil",{
		method : "POST",
		body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
	}).then(response => {
		return response.json();
	}).then(hasil => {
        //$("div#sub-content").html(hasil);
        //document.getElementById("device_id").value = hasil.device_id;
        if(hasil.status == 1) document.getElementById("hasil").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil mematikan device<\/div>";
        else document.getElementById("hasil").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Berhasil mematikan device<\/div>";
        console.log("OFF DEVICE",hasil);
	});
    return false;
}';
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
        margin: 0px calc(100% / 3.5);
    }
</style>
<script type="text/javascript">
'.$js.'
</script>
<form onsubmit="return saveProfilM();" action="#">
    <div id="hasil"></div>
    <div class="form-group row">
	    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
	    <div class="col-sm-10">
	    	<input type="text" class="form-control" id="nama" placeholder="Nama" value="'.$data['nama'].'">
	    </div>
	</div>
    <div class="form-group row">
		<label for="username" class="col-sm-2 col-form-label">Username</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="username" placeholder="Username" value="'.$data['username'].'">
	    </div>
    </div>
    <div class="form-group row">
	    <label for="email" class="col-sm-2 col-form-label">Email</label>
	    <div class="col-sm-10">
	    	<input type="email" class="form-control" id="email" placeholder="Email" value="'.$data['email'].'">
	    </div>
    </div>
    <div class="form-group row">
	    <label for="password" class="col-sm-2 col-form-label">Password</label>
	    <div class="col-sm-10">
	    	<input type="password" class="form-control" id="password" placeholder="Password"  value="'.$data['password'].'">
	    </div>
    </div>
    <div id="boxfingerprint">
        <img src="'.base_url().'assets/logo/fingerprints.png">
        <button id="editfingerprint" type="button" class="btn btn-primary" style="width:100%">Edit Fingerprint</button>
    </div>
	<div class="form-group row" style="display:none">
	    <div class="col-sm-10">
	    	<input type="text" class="form-control" id="idus" placeholder="idus"  value="'.$data['idus'].'">
	    </div>
    </div>
	<div><button id="buttonSubmit" type="submit" class="btn btn-success" style="width:100%">SUBMIT</button></div>
</form>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>