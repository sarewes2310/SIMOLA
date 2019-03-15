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
				//console.log(hasil);	
				if(hasil.status)window.location = base_url;
			});
		});
	}
}

function addDropbox(){
	window.location = "https://www.dropbox.com/oauth2/authorize?client_id=52u9mwxlcxgv1j2&response_type=code&redirect_uri=https://simola.herokuapp.com/index.php/user/getDropBoxAT/";
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
			if(hasil.status == 1) document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Lakukan langkah sesuai pada lcd device<\/div>";
			else document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Device mati<\/div>";
	});
  return false;
}

function addFingerprint(){
	const hasil = {
			"username" : document.getElementById('inputusername').value
	};
	fetch(base_url+"DataUser/addFingerPrint",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
				//$("div#sub-content").html(hasil);
			if(hasil.status == 1) document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Lakukan langkah sesuai pada lcd device<\/div>";
			else document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Device mati<\/div>";
	});
  return false;
}

function removeFingerprint(){
	const hasil = {
			"username" : document.getElementById('inputusername').value
	};
	fetch(base_url+"DataUser/removeFingerPrint",{
	method : "POST",
	body : parserData(hasil),
			headers: {
					"Content-Type": "application/x-www-form-urlencoded",
			}
	}).then(response => {
		return response.json();
	}).then(hasil => {
				//$("div#sub-content").html(hasil);
			if(hasil.status == 1) document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Lakukan langkah sesuai pada lcd device<\/div>";
			else document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Device mati<\/div>";
	});
  return false;
}

// Initialize Firebase
// TODO: Replace with your project's customized code snippet
var config = {
	apiKey: "AIzaSyC3F3aH83p83dcbe65KAQal0X5CClM19xI",
	authDomain: "simola-5725f.firebaseapp.com",
	databaseURL: "https://simola-5725f.firebaseio.com",
	projectId: "simola-5725f",
	storageBucket: "simola-5725f.appspot.com",
	messagingSenderId: "741998138956",
};
firebase.initializeApp(config);

const messaging = firebase.messaging();
messaging.usePublicVapidKey('BDg0UDe89EtfjheFqJkwYDuzPx5FjYMtTTMQQ7d9MlTAOOVddVoBUIRt1QAMWxxUBnCBBa2Y4oENLNeQjFf-r1k');
messaging.onTokenRefresh(function() {
		messaging.getToken().then(function(refreshedToken) {
				console.log('Token refreshed.',refreshedToken);
				// Indicate that the new Instance ID token has not yet been sent to the
				// app server.
				setTokenSentToServer(false);
				// Send Instance ID token to app server.
				sendTokenToServer(refreshedToken);
				// [START_EXCLUDE]
				// Display new Instance ID token and clear UI of all previous messages.
				//resetUI();
				// [END_EXCLUDE]
		}).catch(function(err) {
				console.log('Unable to retrieve refreshed token ', err);
				showToken('Unable to retrieve refreshed token ', err);
		});
});

messaging.onMessage(function(payload) {
		console.log('Message received. ', payload);
		// [START_EXCLUDE]
		// Update the UI to include the received message.
		// appendMessage(payload);
		// [END_EXCLUDE]
});

function setTokenSentToServer(sent) {
		window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}

function sendTokenToServer(currentToken) {
		if (!isTokenSentToServer()) {
				console.log('Sending token to server...');
				// TODO(developer): Send the current token to your server.
				setTokenSentToServer(true);
		} else {
				console.log('Token already sent to server so won\'t send it again ' +
				'unless it changes');
		}
}

function isTokenSentToServer() {
		return window.localStorage.getItem('sentToServer') === '1';
}

function updateUIForPushEnabled(currentToken) {
		fetch('https://simolasocket-nodejs.herokuapp.com/addPushUser?idus='++'&pushtoken='+currentToken,{
				method : 'GET',
				mode: 'cors',
		}).then(response => {
				return response.json();
		}).then(hasil => {

		});
}

function requestPermission() {
		console.log('Requesting permission...');
		// [START request_permission]
		messaging.requestPermission().then(function() {
				console.log('Notification permission granted.');
				// TODO(developer): Retrieve an Instance ID token for use with FCM.
				// [START_EXCLUDE]
				// In many cases once an app has been granted notification permission, it
				// should update its UI reflecting this.
				resetUI();
				// [END_EXCLUDE]
		}).catch(function(err) {
				console.log('Unable to get permission to notify.', err);
		});
		// [END request_permission]
}

function resetUI() {
		// [START get_token]
		// Get Instance ID token. Initially this makes a network call, once retrieved
		// subsequent calls to getToken will return from cache.
		messaging.getToken().then(function(currentToken) {
				if (currentToken) {
						sendTokenToServer(currentToken);
						updateUIForPushEnabled(currentToken);
						console.log(currentToken);
				} else {
						// Show permission request.
						console.log('No Instance ID token available. Request permission to generate one.');
						// Show permission UI.
						//updateUIForPushPermissionRequired();
						setTokenSentToServer(false);
				}
		}).catch(function(err) {
				console.log('An error occurred while retrieving token. ', err);
				//showToken('Error retrieving Instance ID token. ', err);
				//setTokenSentToServer(false);
		});
		// [END get_token]
}
resetUI()