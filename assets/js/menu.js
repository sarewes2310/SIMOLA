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
		$("div#sub-content").html(hasil);
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
				cekNavbar = false;
				const hasil = null;
				if ('indexedDB' in window) {
					readAllData('login')
					  .then(function(data) {
						//#console.log(data);
						hasil = {
							'idus' : data[0].id
						};
					  });
				}
                fetch(base_url+'User/getViewEditProfil',{
					method : 'post',
					body : parserData1(hasil),
					headers: {
						"Content-Type": "application/x-www-form-urlencoded",
					}
				}).then(response => {
                    return response.json();
                }).then(hasil => {
                    document.getElementById("sub-content").innerHTML = hasil;
                });
				break;
		}
		$('#sidebar').removeClass('active');
	});
});

function parserData1(data){ // fungsi yang sama dengan parserData()
	hasil = '';
	for(var i in data){
		hasil = hasil+(i+'='+data[i]);
		hasil = hasil+'&';
	}
	return new URLSearchParams(hasil)
}