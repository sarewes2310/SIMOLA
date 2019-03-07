var base_url = "https://simola.herokuapp.com/index.php/";
function load(){
    // ------------------------------------------------------------------------------------------------------
    // Fungsi yang di gunakan untuk memanggil load page dashboard awal
    // Output yang dihasilkan berupa page dengan menu pilihan dashboard
    // ------------------------------------------------------------------------------------------------------
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
					$("div#sub-content").html(hasil);
				});
				break;
			case "tambahuser" :
				cekNavbar = false;
				fetch(base_url+'User/getViewUser',{
					method : 'GET'
				}).then(response => {
					return response.json();
				}).then(hasil => {
					$("div#sub-content").html(hasil);
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
                fetch(base_url+'User/getViewEditProfil',{
                    method : 'GET'
                }).then(response => {
                    return response.json();
                }).then(hasil => {
                    $("div#sub-content").html(hasil);
                });
				break;
		}
		$('#sidebar').removeClass('active');
	});
});