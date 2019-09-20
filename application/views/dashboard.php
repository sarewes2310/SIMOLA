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
    <link rel="manifest" href="<?php echo base_url()?>manifest.json">
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
                    <a href="#dashboard">Dashboard</a>
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
                <li id="laporan">
                    <a href="#">Laporan</a>
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
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/ajax_file_download.js"></script>
    <!-- Font Awesome JS-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()?>assets/js/variabel_utama.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/idb.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/js/utility.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.7.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.7.1/firebase-messaging.js"></script>
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