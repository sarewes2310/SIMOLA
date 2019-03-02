<?php
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
</style>
<script>
    const inputModal = d
</script>
<table class="table">
  <tbody>
    <tr>
      <td>Username</td>
    </tr>
    <tr>
      <td>Jacob</td>
    </tr>
    <tr>
      <td>Larry</td>
    </tr>
    <tr>
      <td>Username</td>
    </tr>
    <tr>
      <td>Jacob</td>
    </tr>
    <tr>
      <td>Larry</td>
    </tr>
    <tr>
      <td>Username</td>
    </tr>
    <tr>
      <td>Jacob</td>
    </tr>
    <tr>
      <td>Larry</td>
    </tr>
  </tbody>
</table>
<a class="float" id="tambahUserModal" data-toggle="modal" data-target="#inputModal">
    <i class="fa fa-plus my-float"></i>
</a>
<!-- Modal -->
<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>