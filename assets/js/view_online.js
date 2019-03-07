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