function peringatan(id)
{
    //document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
    const hasil = {
        'device_id' : id
    };
    fetch(base_url+'DataUser/getDevice',{
		method : 'POST',
		body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
	}).then(response => {
		return response.json();
	}).then(hasil => {
        //$("div#sub-content").html(hasil);
        //document.getElementById("device_id").value = hasil.;
        console.log(hasil);
        document.getElementById("hasil").innerHTML = "";
	});
    return false;
}

function parserData(data){
	hasil = '';
	for(var i in data){
		hasil = hasil+(i+'='+data[i]);
		hasil = hasil+'&';
	}
	return new URLSearchParams(hasil)
}
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
}