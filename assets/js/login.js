
var form = document.querySelector('form');
form.addEventListener('submit', function(e){
    const hasil = {
        'username' : document.getElementById('username_login').value,
        'password' : document.getElementById('password_login').value
    };
    //console.log(hasil);
    fetch(base_url+'DataUser/submitUserLogin',
    {
        method : 'post',
        body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
    }).then(function(res){
        //console.log(res);
        return res.json(); 
    }).then(function(response){
        //console.log(response);
        if(response.status == 0){
            var post = {
                id:response.idus,
                nama:response.nama
            }
            console.log(post);
            writeData('login', post)
            .then(function(response){
                console.log(response);
            })
            .catch(function(err){
                console.log(err);
            });
            window.location = base_url + 'User/dashboard';
        }else{
            const card = document.getElementById('status');
            card.innerHTML = "";
        }
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
