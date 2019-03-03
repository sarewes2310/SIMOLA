var form = document.querySelector('form');

function submitLogin(){
    
}
form.addEventListener('submit', function(e){
    e.preventDefault();
    const hasil = {
        'username' : document.getElementById('username_login').value,
        'password' : document.getElementById('password_login').value
    };
    console.log(hasil);
    fetch(base_url+'datauser/submitUserLogin',
    {
        method : 'post',
        body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    }).then(function(res){
       return res.json(); 
    });
});

function parserData(data){
	hasil = '';
	for(var i in data){
		hasil = hasil+(i+'='+data[i]);
		hasil = hasil+'&';
	}
	return new URLSearchParams(hasil)
}