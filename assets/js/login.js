
function submitLogin(){
    
}

var form = document.querySelector('form');
form.addEventListener('submit', function(e){
    const hasil = {
        'username' : document.getElementById('username_login').value,
        'password' : document.getElementById('password_login').value
    };
    console.log(hasil);
    fetch(base_url+'DataUser/submitUserLogin',
    {
        method : 'post',
        body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    }).then(function(res){
       return res.json(); 
    }).then(function(response){
        console.log(response);
    });
    return e.preventDefault();
});

function parserData(data){
	hasil = '';
	for(var i in data){
		hasil = hasil+(i+'='+data[i]);
		hasil = hasil+'&';
	}
	return new URLSearchParams(hasil)
}
