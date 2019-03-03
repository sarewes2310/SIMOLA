<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="https://simola.herokuapp.com/assets/css/sigin.css" rel="stylesheet">
    <!--<link rel="manifest" href="assets/manifest.json">-->
    <script src="<?php echo base_url()?>assets/js/variabel_utama.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo base_url()?>assets/js/login.js" type="text/javascript" charset="utf-8"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="text-center">
  <div class="container">
    <div class="row">
      <div class="col-sm col-ml col-lg">
        <div class="isi">
            <img src="https://simola.herokuapp.com/assets/logo/SIM_1.png">
        </div>
        <div class="isi">
          <form>
            <div class="form-row">
              <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                <input type="text" class="form-control" id="username_login" placeholder="Username" required>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                <input type="password" class="form-control" id="password_login" placeholder="Password" required>
              </div>
            </div>
            <button class="btn btn-primary" type="submit" style="width:100%">LOGIN</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
var form = document.querySelector('form');
form.addEventListener('submit', function(e){
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
</script>
</body>
</html>