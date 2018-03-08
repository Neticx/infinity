<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-8">
      <div class="x_panel">
        <div class="x_title">
          <h2>Form Edit Buku Tamu</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('tamu/action_edit'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="id_tamu" value="<?php echo $tamu['id_tamu']; ?>">
            <input type="hidden" name="id_cabang" value="<?php echo $cabangID; ?>">
            <div class="row">
              <div class="form-group col-md-8">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" value="<?php echo $tamu['nama_siswa']; ?>" placeholder="Nama Siswa" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Jenis Kelamin</label>
                <div class="radio">
                  <?php if($tamu['jk'] == 'm'): ?>
                    <label class="radio-line" style="padding-right: 20px;"><input type="radio" name="jk" value="m" checked="">Laki-laki</label>
                    <label class="radio-line"><input type="radio" name="jk" value="f">Perempuan</label>
                  <?php else: ?>
                    <label class="radio-line" style="padding-right: 20px;"><input type="radio" name="jk" value="m">Laki-laki</label>
                    <label class="radio-line"><input type="radio" name="jk" value="f" checked="">Perempuan</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="form-group col-md-8">
                <label>Alamat Email</label>
                <input class="form-control" type="email" name="email" value="<?php echo $tamu['email']; ?>" placeholder="Alamat Email" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp" value="<?php echo $tamu['no_hp']; ?>" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Nama Wali</label>
                <input class="form-control" type="text" name="nama_wali" value="<?php echo $tamu['nama_wali']; ?>" placeholder="Nama Wali" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Nomor Handphone Wali</label>
                <input class="form-control" type="text" name="no_hp_wali" value="<?php echo $tamu['no_hp_wali']; ?>" placeholder="Nomor Handphone Wali" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Asal Sekolah</label>
                <input class="form-control" type="text" name="asal_sekolah" value="<?php echo $tamu['asal_sekolah']; ?>" placeholder="Asal Sekolah" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Jurusan</label>
                <input class="form-control" type="text" name="jurusan" value="<?php echo $tamu['jurusan']; ?>" placeholder="Jurusan" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" placeholder="Alamat" rows="5" required=""><?php echo $tamu['alamat']; ?></textarea>
              </div>
              <div class="form-group col-md-8">
                <label>Tahu Infinity dari?</label>
                <textarea name="tahu_infinity" class="form-control" placeholder="Jawaban" rows="5" required=""><?php echo $tamu['tahu_infinity']; ?></textarea>
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