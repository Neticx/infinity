<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-8">
      <div class="x_panel">
        <div class="x_title">
          <h2>Form Buku Tamu</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('tamu/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="row">
              <div class="form-group col-md-8">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" placeholder="Nama Siswa" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Jenis Kelamin</label>
                <div class="radio">
                  <label class="radio-line" style="padding-right: 20px;"><input type="radio" name="jk" checked="">Laki-laki</label>
                  <label class="radio-line"><input type="radio" name="jk">Perempuan</label>
                </div>
              </div>
              <div class="form-group col-md-8">
                <label>Alamat Email</label>
                <input class="form-control" type="email" name="email" placeholder="Alamat Email" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Nama Wali</label>
                <input class="form-control" type="text" name="nama_wali" placeholder="Nama Wali" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Nomor Handphone Wali</label>
                <input class="form-control" type="text" name="no_hp_wali" placeholder="Nomor Handphone Wali" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Asal Sekolah</label>
                <input class="form-control" type="text" name="asal_sekolah" placeholder="Asal Sekolah" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" placeholder="Alamat" rows="5" required=""></textarea>
              </div>
              <div class="form-group col-md-8">
                <label>Tahu Infinity dari?</label>
                <textarea name="tahu_infinity" class="form-control" placeholder="Jawaban" rows="5" required=""></textarea>
              </div>
            </div>
            <div class="actionBar">
              <button class="btn btn-success" type="submit">SUBMIT</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function(){
      $('#tanggal_lahir').daterangepicker({
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