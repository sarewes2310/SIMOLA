<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>SIMOLA</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<!-- Our Custom CSS -->
    <link rel="stylesheet" href="https://simola.herokuapp.com/assets/css/style.css">

    <!-- Font Awesome JS-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()?>assets/js/variabel_utama.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/idb.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/utility.js"></script>
    <link rel="manifest" href="<?php echo base_url()?>/manifest.json">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Welcome 
                    <?php 
                        if(empty($this->session->nama)){
                            echo '
                                <div id="namaW"></div>
                                <script>
                                    if ("indexedDB" in window) {
                                        readAllData("login")
                                        .then(function(data) {
                                            console.log(data);
                                            for(var i = 0; i < data.length; i++){
                                                document.getElementById("namaW").innerHTML = data[i]
                                            }
                                        });
                                    }
                                </script>
                            ';
                        }
                        else echo $this->session->nama;
                    ?>
                </h3>
            </div>
            <ul class="list-unstyled components">
                <li class="active" id="dashboard">
                    <a href="#dashboard" data-toggle="collapse" aria-expanded="false">Dashboard</a>
                </li>
                <li id="tambahuser">
                    <a href="#">User</a>
                </li>
                <li id="dropbox">
                    <a href="#">DropBox</a>
                </li>
                <li id="edit_profil">
                    <a href="#">Edit Profil</a>
                </li>
                <li id="notifications">
                    <a href="#">Notifications</a>
                </li>
                <li id="logout">
                    <a href="#">Log Out</a>
                </li>	
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <div id="navKegiatan">
                    	
                    </div>
                </div>
            </nav>
			<div id="sub-content">		

			</div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.js" integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA=" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/firebasejs/5.7.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.7.1/firebase-messaging.js"></script>
    <script>
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
    </script>
    <script>
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
            fetch('https://simolasocket-nodejs.herokuapp.com/addPushUser?us='+currentToken,{
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

    </script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/menu.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>