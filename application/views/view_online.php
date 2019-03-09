<?php
$dataT = '';
foreach($data as $key => $value){
    $dataT .= '
        <tr>
            <td style="width:80%">'.$value['nama'].'</td>
    ';
    if($value['check_connect'] == 1){
        $dataT .= '<td><button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#inputModal" onclick="return peringatan('.$value['device_id'].')">ON</button></td>';
    }else{
        $dataT .= '<td><button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#inputModal" onclick="return peringatan('.$value['device_id'].')">OFF</button></td>';
    }
    $dataT .= '
        </tr>
    ';
}
$alertP = '<div class="alert alert-primary" role="alert">Device berhasil dimatikan</div>';
$js = '
function peringatan(id)
{
    document.getElementById("hasil").innerHTML = "";
    const hasil = {
        "device_id" : id
    };
    fetch(base_url+"DataUser/getDevice",{
		method : "POST",
		body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
	}).then(response => {
		return response.json();
	}).then(hasil => {
        //$("div#sub-content").html(hasil);
        document.getElementById("device_id").value = hasil.device_id;
        console.log(hasil);
	});
    return false;
}

function parserData(data){
	hasil = "";
	for(var i in data){
		hasil = hasil+(i+"="+data[i]);
		hasil = hasil+"&";
	}
	return new URLSearchParams(hasil);
}

function offDevice(){
    const hasil = {
        "device_id" : document.getElementById("device_id").value
    };
    fetch(base_url+"DataUser/offDevice",{
		method : "POST",
		body : parserData(hasil),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        }
	}).then(response => {
		return response.json();
	}).then(hasil => {
        //$("div#sub-content").html(hasil);
        //document.getElementById("device_id").value = hasil.device_id;
        if(hasil.status == 1) document.getElementById("hasil").innerHTML = "<div class=\"alert alert-primary\" role=\"alert\"> Berhasil mematikan device<\/div>";
        else document.getElementById("hasil").innerHTML = "<div class=\"alert alert-danger\" role=\"alert\"> Berhasil mematikan device<\/div>";
        console.log("OFF DEVICE",hasil);
	});
    return false;
}
';
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
</style>
<script type="text/javascript">
'.$js.'
</script>
<table class="table">
  <tbody>
    '.$dataT.'
  </tbody>
</table>

<!-- Modal OFF Device-->
<form onsubmit="return offDevice();" action="#">
    <div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="inputModalLabel">Peringatan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div>Apakah anda yakin ingin mematikan device ini ?</div>
            <div class="form-group row" style="display:none">
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="device_id" placeholder="device_id">
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