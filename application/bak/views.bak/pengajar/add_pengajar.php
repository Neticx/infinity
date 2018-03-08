<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-8">
      <div class="x_panel">
        <div class="x_title">
          <h2>Tambah Data Pengajar</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('pengajar/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <fieldset>
              <legend>Cabang</legend>
              <div class="form-group col-md-8">
                <label>Cabang</label>
                <input class="form-control" type="text" value="<?php echo $cabang["nama"]; ?>" required="" readonly="">
                <input type="hidden" name="id_cabang" value="<?php echo $cabang["id_cabang"]; ?>">
              </div>
            </fieldset>
            <fieldset>
              <legend>Identitas Pribadi</legend>
              <div class="form-group col-md-6">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" placeholder="Nama Pengajar" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Jenis Kelamin</label>
                <div class="radio">
                  <label class="radio-line" style="padding-right: 20px;"><input type="radio" name="jk" value="m" checked="">Laki-laki</label>
                  <label class="radio-line"><input type="radio" name="jk" value="f">Perempuan</label>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label>Tempat Lahir</label>
                <input class="form-control" type="text" name="tmpt_lahir" placeholder="Tempat Lahir" required="">
              </div>
              <div class="form-group col-md-6 has-feedback">
                <label>Tanggal Lahir</label>
                <input type="text" class="form-control has-feedback-left" id="tanggal_lahir" name="tanggal_lahir" placeholder="DD-MM-YYYY" required="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="form-group col-md-6">
                <label>Email</label>
                <input class="form-control" type="email" name="email" placeholder="Email" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp" placeholder="Nomor Handphone" required="">
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Alamat" rows="8" required=""></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select id="prov" onchange="onSelectProv()" class="form-control" required="">
                      <option value="0">--- Pilih Provinsi ---</option>
                      <?php foreach($provinsi as $prov): ?>
                      <option value="<?php echo $prov['id_provinsi']; ?>"><?php echo $prov['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kabupaten</label>
                    <select name="kab" id="kab" onchange="onSelectKab()" class="form-control" required=""></select>
                  </div>
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec" id="kec" class="form-control" required=""></select>
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset>
              <legend>Data Pengajar</legend>
              <div class="form-group col-md-6">
                <label>Kode Pengajar</label>
                <input class="form-control" type="text" name="kode_pengajar" placeholder="Kode Pengajar" required="">
              </div>
              <div class="form-group col-md-6">
                <label>No Rek BNI</label>
                <input class="form-control" type="text" name="no_rek" placeholder="No Rek BNI" required="">
              </div>
              <div class="form-group col-md-6 has-feedback">
                <label>Tanggal Masuk</label>
                <input type="text" class="form-control has-feedback-left" id="tanggal_masuk" name="tanggal_masuk" placeholder="DD-MM-YYYY" required="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="form-group col-md-6">
                <label>Bidang</label>
                <select name="bidang" class="form-control">
                  <option value="tpa">TPA</option>
                  <option value="tbi">TBI</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Grade</label>
                <select name="grade" class="form-control">
                  <option value="b">B</option>
                  <option value="a">A</option>
                  <option value="a+">A+</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="freelance">Freelance</option>
                  <option value="tetap">Tetap</option>
                </select>
              </div>
            </fieldset>
            <div class="actionBar">
              <button class="btn btn-success" type="submit">SIMPAN</button>
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
      $('#tanggal_masuk').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD-MM-YYYY'
          },
      }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
      });
    });

    function onSelectProv(){
      var provID = $("#prov").val();
      $.ajax({
        url: '<?php echo base_url('cabang/getKab/?id='); ?>' + provID,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
          $("#kab").empty();
          $("#kec").empty();
          $("#kab").append(data);
        }
      });
    }

    function onSelectKab(){
      var KabID = $("#kab").val();
      $.ajax({
        url: '<?php echo base_url('cabang/getKec/?id='); ?>' + KabID,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
          $("#kec").empty();
          $("#kec").append(data);
        }
      });
    }
  </script>