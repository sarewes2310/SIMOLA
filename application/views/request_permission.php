<?php
echo json_encode('
<style>
    p{
        text-align: center;
        font-size: 0.9em;
    }
    img{
        width: calc(100%);
        margin: 10px 0px;
    }
    #dp{
        width:100%;
    }
    #rp{
        width:100%;
    }
    body{
        background: #f2f3f2;
    }
    #sub-content{
        padding:0px;
    }
</style>
<table class="table">
<tbody>
    <tr>
        <td>Notifications</td>
        <td>
            <button id="rp" onclick="return requestPermission()" type="button" class="btn btn-primary">Add</button>
            <button id="dp" onclick="return deleteToken()" type="button" class="btn btn-danger">Remove</button>
        </td>
    </tr>
    <tr><div id="hasil"></div></tr>
</tbody>
</table>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>