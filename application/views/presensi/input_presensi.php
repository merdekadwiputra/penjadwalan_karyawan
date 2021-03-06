<?php if (isset($_SESSION['pesan'])) { ?>
  <div class="alert alert-block alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert">
      <i class="ace-icon fa fa-times"></i>
    </button>
    <?php echo $this->session->flashdata('pesan'); ?>
  </div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <h3 class="header smaller lighter blue"><?php echo $judul; ?></h3>
        
        <?php 
        if(isset($_SESSION['last_date'])) {
            $tahun = date('Y', strtotime($_SESSION['last_date']));
            $bulan = date('m', strtotime($_SESSION['last_date']));
        } else {
            $tahun = date('Y');
            $bulan = date('m');    
        } 
        ?>

        <form class="form-horizontal" role="form" method="post" action="#">
            <div class="col-md-12">                        
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right" for="bulan"> Bulan </label>

                    <div class="col-sm-3">
                        <select class="form-control" id="bulan" name="bulan">
                            <option value="01"<?php if($bulan=="01") echo " selected"; ?>>Januari</option>
                            <option value="02"<?php if($bulan=="02") echo " selected"; ?>>Februari</option>
                            <option value="03"<?php if($bulan=="03") echo " selected"; ?>>Maret</option>
                            <option value="04"<?php if($bulan=="04") echo " selected"; ?>>April</option>
                            <option value="05"<?php if($bulan=="05") echo " selected"; ?>>Mei</option>
                            <option value="06"<?php if($bulan=="06") echo " selected"; ?>>Juni</option>
                            <option value="07"<?php if($bulan=="07") echo " selected"; ?>>Juli</option>
                            <option value="08"<?php if($bulan=="08") echo " selected"; ?>>Agustus</option>
                            <option value="09"<?php if($bulan=="09") echo " selected"; ?>>September</option>
                            <option value="10"<?php if($bulan=="10") echo " selected"; ?>>Oktober</option>
                            <option value="11"<?php if($bulan=="11") echo " selected"; ?>>November</option>
                            <option value="12"<?php if($bulan=="12") echo " selected"; ?>>Desember</option>
                        </select>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right" for="tahun"> Tahun </label>

                    <div class="col-sm-3">
                        <input type="number" id="tahun" name="tahun" class="col-xs-10 col-sm-5 form-control" value="<?php echo $tahun; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label no-padding-right" for="groupTanggal"> Tanggal </label>

                    <div class="col-sm-11" id="groupTanggal">
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="technicianTable">
    </div>
</div>

<script type="text/javascript">
    function numberOfDays(month, year) {
        return new Date(year, month, 0).getDate();
    }

    function showDaysButton(total) {
        var tahun = $('#tahun').val();
        var bulan = $('#bulan').val();
        $('#groupTanggal').html("");
        var groupTanggal = $('#groupTanggal').html();
        for(var i = 1; i<=total; i++) {
            var tanggal = tahun + '-' + bulan + '-' + i;
            var typeClass = 'btn-primary';
            if(checkIsi(tanggal))
                typeClass = 'btn-success';
            else 
                typeClass = 'btn-primary';
            var btnHtml = "<button class='btn " + typeClass + "' type='button' onclick='showTechnician(" + i + ")'>" + i + "</button>";
            groupTanggal = groupTanggal + btnHtml;
        }
        $('#groupTanggal').html(groupTanggal);
    }

    function checkIsi(tanggal) {
        var hasil = false;
        var url = '<?php echo base_url(); ?>' + 'presensi/cek_isi/' + tanggal;
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.open("GET", url, false);
        xmlHttp.send();
        var resp = xmlHttp.responseText;
        if(resp == "ada") 
            hasil = true;
        return hasil;
    }

    function showTechnician(tgl) {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var hasil = tgl+'-'+bulan+'-'+tahun;
        $.ajax({
            url: '<?php echo base_url(); ?>' + 'presensi/jadwal_teknisi',
            data: {'tanggal': hasil},
            dataType: 'html',
            type: 'post',
            success: function(result) {
                $('#technicianTable').html(result);
            },
            error: function(xhr, status, error) {
                $('#technicianTable').html(error);
            }
        });
    }

    $(document).ready(function() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var jumlahHari = numberOfDays(bulan, tahun);
        showDaysButton(jumlahHari);

        $('#bulan').change(function() {
            bulan = $(this).val();
            tahun = $('#tahun').val();
            jumlahHari = numberOfDays(bulan, tahun);
            showDaysButton(jumlahHari);
        });

        $('#tahun').change(function() {
            bulan = $('#bulan').val();
            tahun = $(this).val();
            jumlahHari = numberOfDays(bulan, tahun);
            showDaysButton(jumlahHari);
        });
    });
</script>