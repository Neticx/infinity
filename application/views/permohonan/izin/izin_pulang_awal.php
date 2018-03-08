<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Izin Pulang Awal</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form role="form" method="POST" action="<?php echo base_url('cetak/surat_pemberian_izin/?jenis=pulang_awal'); ?>" >
            <div class="form-group col-md-12">
              <label>Nama</label>
              <input class="form-control" type="text" name="nama" placeholder="Nama" required="">
            </div>
            <div class="form-group col-md-12">
              <label>Jabatan</label>
              <input class="form-control" type="text" name="jabatan" placeholder="Jabatan" required="">
            </div>
            <div class="form-group col-md-12">
              <label>Jenis Permohonan</label>
              <input class="form-control" type="text" name="jenis_permohonan" placeholder="Jenis Permohonan" required="">
            </div>
            <div class="form-group col-md-6">
              <label>Hari</label>
              <input class="form-control" type="text" name="hari" placeholder="Hari" required="">
            </div>
            <div class="form-group col-md-6 has-feedback">
              <label>Tanggal</label>
              <input type="text" class="form-control has-feedback-left" id="tanggal" name="tanggal" placeholder="DD-MM-YYYY" required="">
              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span><br>
            </div>
            <div class="form-group col-md-12">
              <label>Alasan</label>
              <textarea id="message" required="required" class="form-control" name="alasan" data-parsley-trigger="keyup" placeholder="Alasan" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                          data-parsley-validation-threshold="10"></textarea>
            </div>
            <center><button class="btn btn-success" type="submit">CETAK</button></center>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function(){
    $('#tanggal').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
          format: 'DD-MM-YYYY'
        },
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
</script>