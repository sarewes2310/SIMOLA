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
<form>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" type="button">Tanggal Awal</button>
        </div>
        <input type="date" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" name="tgl_awal">
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" type="button">Tanggal Akhir</button>
        </div>
        <input type="date" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" name="tgl_akhir">
    </div>
</form>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>