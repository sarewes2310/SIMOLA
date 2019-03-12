var base_url = "https://simola.herokuapp.com/index.php/";
function load(){
    // ------------------------------------------------------------------------------------------------------
    // Fungsi yang di gunakan untuk memanggil load page dashboard awal
    // Output yang dihasilkan berupa page dengan menu pilihan dashboard
    // ------------------------------------------------------------------------------------------------------
	document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
	fetch(base_url+'user/getViewDashboard',{
		method : 'GET',
		mode : 'cors'
	}).then(response => {
		return response.json();
	}).then(hasil => {
		document.getElementById("sub-content").innerHTML = hasil;
	});
}

$(document).ready(() => {
	load();
	$("ul.list-unstyled.components > li").click(function() {
		//alert("COEG");
		$.each($("ul.list-unstyled.components > li"),(index, el) => { // Menghapus semua komponen active pada li
			$("ul.list-unstyled.components > li").removeClass('active');
			$("div#navKegiatan").html('');
			//console.log(index);
		});
		$(this).addClass("active");
		console.log($(this).attr('id'));
		var isi;
		switch($(this).attr('id')){
			case "dashboard" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
        // ------------------------------------------------------------------------------------------------------
        // Fungsi yang di gunakan untuk memilih menu pilihan dashboard
        // Output yang dihasilkan berupa page dengan menu pilihan dashboard
        // ------------------------------------------------------------------------------------------------------
				cekNavbar = false;
				fetch(base_url+'User/getViewDashboard',{
					method : 'GET',
					mode : 'cors'
				}).then(response => {
					return response.json();
				}).then(hasil => {
					document.getElementById("sub-content").innerHTML = hasil;
				});
				break;
			case "tambahuser" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				fetch(base_url+'User/getViewUser',{
					method : 'GET'
				}).then(response => {
					return response.json();
				}).then(hasil => {
					document.getElementById("sub-content").innerHTML = hasil;
				});
				break;
			case "dropbox" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				//window.location.href = base_url + "user/getDropboxLink";
				//console.log("DROPBOX RUNN");
				fetch(base_url+'User/getViewDropbox',{
					method : 'GET'
				}).then(response => {
					return response.json();
				}).then(hasil => {
					//$("div#sub-content").html(hasil);
					document.getElementById("sub-content").innerHTML = hasil;
				});
				break;
			case "edit_profil" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				var hasil = null;
				if ('indexedDB' in window) {
					readAllData('login')
					  .then(function(data) {
						//console.log(data);
						//hasil = {
						//	'idus' : data[0].id
						//};
						for (var i = 0; i < data.length; i++) {
							//console.log(data[i]);
							hasil = {
								'idus' : data[i].id
							}
						}
						fetch(base_url+'User/getViewEditProfil',{
								method : 'post',
								body : parserData(hasil),
								headers: {
									"Content-Type": "application/x-www-form-urlencoded",
								}
							}).then(response => {
								return response.json();
							}).then(hasil => {
								document.getElementById("sub-content").innerHTML = hasil;
							});
					});
				}else{
					
				}
				console.log("HASIL",hasil);
				break;
			case "notifications" :
				requestPermission();
				/*document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				fetch(base_url+'User/getViewUser',{
					method : 'GET'
				}).then(response => {
					return response.json();
				}).then(hasil => {
					document.getElementById("sub-content").innerHTML = hasil;
				});*/
				break;
			case "logout" :
				//document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				fetch(base_url+'User/logout',{
					method : 'GET'
				}).then(response => {
					return response.json();
				}).then(hasil => {
					//document.getElementById("sub-content").innerHTML = hasil;
					console.log(hasil);
					if ('indexedDB' in window) {
						clearAllData('login')
						.then(function () {
							window.location = hasil.link;
						});
					}
				});
				break;
		}
		$('#sidebar').removeClass('active');
	});
});

function simpanProfil(){
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
				if(hasil.status == 1) document.getElementById("hasil").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil mengedit data profil<\/div>";
				else document.getElementById("hasil").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal mengedit data profil<\/div>";
				console.log("OFF DEVICE",hasil);
	});
	return false;
}

function parserData(data){
	hasil = "";
	for(var i in data){
		hasil = hasil+(i+"="+data[i]);
		hasil = hasil+"&";
	}
	return new URLSearchParams(hasil);
}

function peringatan(id)
{
	document.getElementById("hasil").innerHTML = "";
	const hasil = {
			"device_id" : id
	};
	fetch(base_url+"DataUser/getDevice",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
        //$("div#sub-content").html(hasil);
        document.getElementById("device_id").value = hasil.device_id;
        console.log(hasil);
	});
  return false;
}

function offDevice(){
	const hasil = {
			"device_id" : document.getElementById("device_id").value
	};
	fetch(base_url+"DataUser/offDevice",{
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
        else document.getElementById("hasil").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal mematikan device<\/div>";
        console.log("OFF DEVICE",hasil);
	});
  return false;
}

function deleteUser(id){
	document.getElementById("hasilDelete").innerHTML = "";
	document.getElementById("idus_delete").value = id;
}

function deleteUserM(){
	document.getElementById("hasilDelete").innerHTML = "";
	const hasil = {
			"idus" : document.getElementById("idus_delete").value
	};
	fetch(base_url+"DataUser/deleteUser",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
		if(hasil.status == 1) document.getElementById("hasilDelete").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil menghapus user<\/div>";
		else document.getElementById("hasilDelete").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal menghapus user<\/div>";
		console.log("OFF DEVICE",hasil);
	});
  return false;
}

function editUser(id){
	document.getElementById("hasilEdit").innerHTML = "";
	const hasil = {
			"idus" : id
	};
	fetch(base_url+"DataUser/getDataEditUser",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
				console.log(hasil);
				//$("div#sub-content").html(hasil);
				document.getElementById('editnama').value = hasil[0].nama;
				document.getElementById('editusername').value = hasil[0].username;
				document.getElementById('editpassword').value = hasil[0].password;
				document.getElementById('editemail').value = hasil[0].email;
				document.getElementById('editidus').value = hasil[0].idus;
				document.getElementById('editstatus').value = hasil[0].idau;
	});
  return false;
}

function editUserM(){
	document.getElementById("hasilEdit").innerHTML = "";
	//alert(document.getElementById('editstatus').value);
	const hasil = {
			"idus" : document.getElementById('editidus').value,
			"nama" : document.getElementById('editnama').value,
			"username" : document.getElementById('editusername').value,
			"password" : document.getElementById('editpassword').value,
			"email" : document.getElementById('editemail').value,
			"idau" : document.getElementById('editstatus').value
	};
	fetch(base_url+"DataUser/saveEditUser",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
				//$("div#sub-content").html(hasil);
			if(hasil.status == 1) document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil mengedit user<\/div>";
			else document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal mengedit user<\/div>";
	});
  return false;
}

function insertUserM(){
	document.getElementById("hasilEdit").innerHTML = "";
	//alert(document.getElementById('editstatus').value);
	const hasil = {
			"nama" : document.getElementById('inputnama').value,
			"username" : document.getElementById('inputusername').value,
			"password" : document.getElementById('inputpassword').value,
			"email" : document.getElementById('inputemail').value,
			"idau" : document.getElementById('inputstatus').value
	};
	fetch(base_url+"DataUser/inputUser",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
				//$("div#sub-content").html(hasil);
			if(hasil.status == 1) document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil mengedit user<\/div>";
			else document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal mengedit user<\/div>";
	});
  return false;
}

function removeDropbox(){
	if ('indexedDB' in window) {
		readAllData('login')
		.then(function(hasil) {
			//console.log(hasil);
			fetch(base_url+'DataUser/removeATDevice',{
				method : "POST",
				body : parserData(hasil[0]),
				headers: {
						"Content-Type": "application/x-www-form-urlencoded",
				}
			}).then(response => {
				return response.json();
			}).then(hasil => {
				//document.getElementById("sub-content").innerHTML = hasil;
				console.log(hasil);
			});
		});
	}
}

function editFingerprint(){
	const hasil = {
			"username" : document.getElementById('inputusername').value
	};
	fetch(base_url+"DataUser/editFingerPrint",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
				//$("div#sub-content").html(hasil);
			if(hasil.status == 1) document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil mengedit user<\/div>";
			else document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal mengedit user<\/div>";
	});
  return false;
}