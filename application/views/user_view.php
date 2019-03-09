<?php
$dataT = '';

foreach($data as $key => $value){
    $stat = "";
    if($value['idau'] == 4){
        $stat = "Admin";
    }else{
        $stat = "User";
    }
    $dataT .= '
        <tr>
            <td style="width:80%">
                '.$value['nama'].'
            </td>
            <td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#editModal" onclick="return peringatan('.$value['idus'].')">Edit</button></td>
            <td><button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal" onclick="return peringatan('.$value['idus'].')">Delete</button></td>        
        </tr>
    ';
}
echo json_encode('
<style>
.float{
	position:fixed;
	width:55px;
	height:55px;
	bottom:20px;
	right:20px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:20px;
}
#sub-content{
    padding: 0px;
}
.boxfingerprint{
    border: 3px solid #a9a9a938;
    border-style: dashed;
    background: #a9a9a938;
    padding: 9px;
    border-radius: 8px;
    margin: 10px 0px;
}
img{
    width: calc(100% / 2.5);
    vertical-align: baseline;
    margin: 0px calc(100% / 3.5);
}
body{
    font-size: 0.9 rem;
}
th{
    text-align:center;
}
</style>
<script src="'.base_url().'assets/js/"></script>
<table class="table">
  <thead>
    <tr>
        <th>Nama</th>
        <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    '.$dataT.'
  </tbody>
</table>
<a class="float" id="tambahUserModal" data-toggle="modal" data-target="#inputModal">
    <i class="fa fa-plus my-float"></i>
</a>

<!-- Modal Tambah User-->
<form>
    <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="inputModalLabel">Tambah User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="inputnama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputnama" placeholder="Nama">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputusername" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputusername" placeholder="Username">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputemail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputemail" placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputpassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputpassword" placeholder="Password">
                </div>
            </div>
            <div class="boxfingerprint">
                <img src="'.base_url().'assets/logo/fingerprints.png">
                <button id="addfingerprint" type="button" class="btn btn-primary" style="width:100%" onclick="return saveFP()">Add Fingerprint</button>
            </div>
            <div class="form-group row" style="display:none">
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputfingerprint" placeholder="fingerprint">
                </div>
            </div>
            <!--<div><button id="buttonSubmit" type="submit" class="btn btn-success" style="width:100%">SUBMIT</button></div>-->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</form>

<!-- Modal Edit User-->
<form>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="editnama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="editnama" placeholder="Nama">
                </div>
            </div>
            <div class="form-group row">
                <label for="editusername" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="editusername" placeholder="Username">
                </div>
            </div>
            <div class="form-group row">
                <label for="editemail" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="editemail" placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label for="editpassword" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="editpassword" placeholder="Password">
                </div>
            </div>
            <div class="boxfingerprint">
                <img src="'.base_url().'assets/logo/fingerprints.png">
                <button id="addfingerprint" type="button" class="btn btn-primary" style="width:100%">Add Fingerprint</button>
            </div>
            <div class="form-group row" style="display:none">
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="editfingerprint" placeholder="fingerprint">
                </div>
            </div>
            <!--<div><button id="buttonSubmit" type="submit" class="btn btn-success" style="width:100%">SUBMIT</button></div>-->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
</form>

<form onsubmit="#" action="#">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Peringatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div>Apakah anda yakin ingin mematikan device ini ?</div>
            <div class="form-group row" style="display:none">
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="idus" placeholder="idus">
                </div>
            </div>
            <div id="hasil"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
            <button type="submit" class="btn btn-danger">YES</button>
        </div>
        </div>
    </div>
    </div>
</form>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>