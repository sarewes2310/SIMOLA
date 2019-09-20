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
<div class="container">
    <div class="row" style="padding:12px">
    <form method="post" action="'.base_url('index.php/DataUser/download_print_pdf_laporan').'">
    <!--<form method="post" action="http://127.0.0.1:81/index.php/DataUser/download_print_pdf_laporan">-->
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Tanggal Awal</button>
                </div>
                <input type="date" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" name="tgl_awal">
            </div>
            <div class="input-group mb-3 col-12">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" type="button">Tanggal Akhir</button>
                </div>
                <input type="date" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1" name="tgl_akhir">
            </div>
            <div class="col-12">
                <button type="submit" style="width:100%" class="btn btn-primary">Download</button>
            </div>
        </form>
    </div>
</div>
',JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_APOS);
?>