var z_index = 0;
var base_url = "https://simola.herokuapp.com/index.php/";
function load(){
    // ------------------------------------------------------------------------------------------------------
    // Fungsi yang di gunakan untuk memanggil load page dashboard awal
    // Output yang dihasilkan berupa page dengan menu pilihan dashboard
    // ------------------------------------------------------------------------------------------------------
	document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
	if ('indexedDB' in window) {
		readAllData('login')
		.then(function(data) {
			for (var i = 0; i < data.length; i++) {
				//console.log(data[i]);
				hasil = {
					'idus' : data[i].id
				}
			}
			fetch(base_url+'User/getViewDashboard',{
				body : parserData(hasil),
				method : 'POST',
				headers: {
					"Content-Type": "application/x-www-form-urlencoded",
				}
			}).then(response => {
				return response.json();
			}).then(hasil => {
				document.getElementById("sub-content").innerHTML = hasil;
			});
		});
	}
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
				if ('indexedDB' in window) {
					readAllData('login')
					.then(function(data) {
						for (var i = 0; i < data.length; i++) {
							//console.log(data[i]);
							hasil = {
								'idus' : data[i].id
							}
						}
						fetch(base_url+'User/getViewDashboard',{
							body : parserData(hasil),
							method : 'POST',
							cache : 'no-cache',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded",
							}
						}).then(response => {
							return response.json();
						}).then(hasil => {
							document.getElementById("sub-content").innerHTML = hasil;
						});
					});
				}
				break;
			case "tambahuser" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				if ('indexedDB' in window) {
					readAllData('login')
					.then(function(data) {
						for (var i = 0; i < data.length; i++) {
							//console.log(data[i]);
							hasil = {
								'idus' : data[i].id
							}
						}
						fetch(base_url+'User/getViewUser',{
							body : parserData(hasil),
							method : 'POST',
							cache : 'no-cache',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded",
							}
						}).then(response => {
							return response.json();
						}).then(hasil => {
							document.getElementById("sub-content").innerHTML = hasil;
							scroll_user();
						});
					});
				}
				break;
			case "dropbox" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				//window.location.href = base_url + "user/getDropboxLink";
				//console.log("DROPBOX RUNN");
				if ('indexedDB' in window) {
					readAllData('login')
					.then(function(data) {
						for (var i = 0; i < data.length; i++) {
							//console.log(data[i]);
							hasil = {
								'idus' : data[i].id
							}
						}
						fetch(base_url+'User/getViewDropbox',{
							body : parserData(hasil),
							method : 'POST',
							cache : 'no-cache',
							headers: {
								"Content-Type": "application/x-www-form-urlencoded",
							}
						}).then(response => {
							return response.json();
						}).then(hasil => {
							//$("div#sub-content").html(hasil);
							document.getElementById("sub-content").innerHTML = hasil;
						});
					});
				}
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
								cache : 'no-cache',
								headers: {
									"Content-Type": "application/x-www-form-urlencoded",
								}
							}).then(response => {
								return response.json();
							}).then(hasil => {
								document.getElementById("sub-content").innerHTML = hasil;
							});
					});
				}
				console.log("HASIL",hasil);
				break;
			case "notifications" :
				//requestPermission();
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				fetch(base_url+'User/getViewNotification',{
					method : 'GET',
					cache : 'no-cache',
				}).then(response => {
					return response.json();
				}).then(hasil => {
					document.getElementById("sub-content").innerHTML = hasil;
					readAllData('sync-posts')
					.then(function(hasil) {
						if(hasil.length == 0){
							document.getElementById("dp").style.display="none";
						}else{
							document.getElementById("rp").style.display="none";
						}
					});
				});
				break;
			case "logout" :
				document.getElementById('sub-content').innerHTML = '<div class="text-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div></div>';
				cekNavbar = false;
				//deleteToken();
				fetch(base_url+'User/logout',{
					method : 'GET',
					cache : 'no-cache',
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

function deleteUser(id,nama){
	document.getElementById("hasilDelete").innerHTML = "";
	document.getElementById("idus_delete").value = id;
	document.getElementById("usernamedelete").value = nama;
}

function deleteUserM()
{
	document.getElementById("hasilDelete").innerHTML = "";
	const hasil = {
			"idus" : document.getElementById("idus_delete").value
	};
	console.log(hasil);
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

function insertUserM()
{
	document.getElementById("hasilAdd").innerHTML = "";
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
			if(hasil.status == 1) document.getElementById("hasilAdd").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil menambah user<\/div>";
			else document.getElementById("hasilAdd").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Gagal menambah user<\/div>";
	});
  return false;
}

function removeDropbox()
{
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

function addDropbox()
{
	window.location = "https://www.dropbox.com/oauth2/authorize?client_id=52u9mwxlcxgv1j2&response_type=code&redirect_uri=https://simola.herokuapp.com/index.php/user/getDropBoxAT/";
}

function editFingerprint()
{
	if(document.getElementById('editusername').value != ""){
		const hasil = {
				"username" : document.getElementById('editusername').value
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
	}else{
		document.getElementById("hasilEdit").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Username harus di isi<\/div>";
	}
  return false;
}

function addFingerprint()
{
	if(document.getElementById('inputusername').value != ""){
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
				if(hasil.status == 1) document.getElementById("hasilAdd").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Lakukan langkah sesuai pada lcd device<\/div>";
				else document.getElementById("hasilAdd").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Device mati<\/div>";
		});
	}else{
		document.getElementById("hasilAdd").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Username harus di isi<\/div>";
	}
  return false;
}

function removeFingerprint()
{
	const hasil = {
			"username" : document.getElementById('usernamedelete').value
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
			if(hasil.status == 1) document.getElementById("hasilDelete").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Lakukan langkah sesuai pada lcd device<\/div>";
			else document.getElementById("hasilDelete").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\">Device mati<\/div>";
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
				//showToken('Unable to retrieve refreshed token ', err);
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

function updateUIForPushEnabled(currentToken,value) {
	if ('indexedDB' in window) {
		readAllData('login')
			.then(function(data) {
			//console.log(data);
			//hasil = {
			//	'idus' : data[0].id
			//};
			var idus = null;
			for (var i = 0; i < data.length; i++) {
				idus = data[i].id;
			}
			if(value == "add"){
				fetch('https://simolasocket-nodejs.herokuapp.com/addPushUser?idus='+idus+'&pushtoken='+currentToken,{
						method : 'GET',
						mode: 'cors',
				}).then(response => {
						return response.json();
				}).then(hasil => {
						var post = {
							id:1,
							token:currentToken
						}
						writeData('sync-posts', post)
						.then(function(response){
								console.log(response);
								document.getElementById("hasil").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\">Berhasil menambah permission<\/div>";
								document.getElementById("dp").style.display="block";
								document.getElementById("rp").style.display="none";
						})
						.catch(function(err){
								console.log(err);
						});
				});
			}else{
				readAllData('sync-posts')
				.then(function(data) {
					for (var i = 0; i < data.length; i++) {
						//console.log(data[i]);
						fetch('https://simolasocket-nodejs.herokuapp.com/removePushUser?pushtoken='+data[i].token,{
								method : 'GET',
								mode: 'cors',
						}).then(response => {
								return response.json();
						}).then(hasil => {
								clearAllData('sync-posts')
								.then(function () {
									//window.location = hasil.link;
									document.getElementById("hasil").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Berhasil menghapus permission<\/div>";
									document.getElementById("dp").style.display="none";
									document.getElementById("rp").style.display="block";
								});
						});
					}
				});
			}
		});
	}else{
		
	}
}

function deleteToken() {
	// Delete Instance ID token.
	// [START delete_token]
	messaging.getToken().then(function(currentToken) {
		messaging.deleteToken(currentToken).then(function() {
			console.log('Token deleted.');
			setTokenSentToServer(false);
			// [START_EXCLUDE]
			// Once token is deleted update UI.
			resetUI("remove");
			// [END_EXCLUDE]
		}).catch(function(err) {
			console.log('Unable to delete token. ', err);
		});
		// [END delete_token]
	}).catch(function(err) {
		console.log('Error retrieving Instance ID token. ', err);
		//showToken('Error retrieving Instance ID token. ', err);
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
				resetUI("add");
				// [END_EXCLUDE]
		}).catch(function(err) {
				console.log('Unable to get permission to notify.', err);
		});
		// [END request_permission]
}

function resetUI(value) {
		// [START get_token]
		// Get Instance ID token. Initially this makes a network call, once retrieved
		// subsequent calls to getToken will return from cache.
		messaging.getToken().then(function(currentToken) {
				if (currentToken) {
						sendTokenToServer(currentToken);
						updateUIForPushEnabled(currentToken,value);
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
				setTokenSentToServer(false);
		});
		// [END get_token]
}

function scroll_user(){
	window.onscroll = function() {
		var d = document.documentElement;
		var offset = d.scrollTop + window.innerHeight;
		var height = d.offsetHeight;
	
		//console.log('offset = ' + offset);
		//console.log('height = ' + height);
	
		if (offset >= (height-1)) {
			console.log('At the bottom');
			z_index+=12;
			if ('indexedDB' in window) {
				readAllData('login')
				.then(function(data) {
					for (var i = 0; i < data.length; i++) {
						//console.log(data[i]);
						hasil = {
							'idus'	: data[i].id,
							'offset': z_index 
						}
					}
					fetch(base_url+'DataUser/viewUser',{
						body : parserData(hasil),
						method : 'POST',
						cache : 'no-cache',
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						}
					}).then(response => {
						return response.json();
					}).then(hasil => {
						console.log("HASIL SCROLL",hasil);
						for(child in hasil){
							//var x = document.createElement("TD");
							//var t = document.createTextNode(hasil.nama);
							console.log("child:",child);
							var str = '<tr><td style="width:80%">'+child.nama+'</td><td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#editModal" onclick="return editUser('+child.nama+')">Edit</button></td><td><button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal" onclick="return deleteUser('+child.idus+',\''+child.nama+'\')">Delete</button></td></tr>';
							document.getElementById("sub-content").insertAdjacentHTML( 'beforeend', str );
						}
						//document.getElementById("sub-content").innerHTML = has;
					});
				});
			}
		}
	};
}