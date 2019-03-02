<?php
echo json_encode('
<style>
.float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:22px;
}
</style>
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
<a href="#" class="float">
    <i class="fa fa-plus my-float"></i>
</a>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>