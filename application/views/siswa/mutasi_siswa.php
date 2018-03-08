<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-8">
      <div class="x_panel">
        <div class="x_title">
          <h2>Form Mutasi Siswa</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('siswa/action_daftar_mutasi'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <fieldset>
              <legend>Cabang</legend>
              <div class="form-group col-md-8">
                <label>Cabang</label>
                <input class="form-control" type="text" value="<?php echo $cabang["nama"]; ?>" required="" readonly="">
                <input type="hidden" name="id_cabang" value="<?php echo $cabang["id_cabang"]; ?>">
              </div>
            </fieldset>
            <fieldset>
              <legend>Cari Siswa yang Akan Dimutasi</legend>
              <div class="form-group col-md-8">
                <label>Nama Siswa</label>
                <input type="text" class="form-control autocomplete" id="nama_siswa" placeholder="Nama Siswa" >
              </div>
              <div class="form-group col-md-8">
                <label>NIS</label>
                <input type="text" name="nis_mutasi" class="form-control" id="nis" readonly="">
              </div>
              <div class="form-group col-md-8">
                <label>Alamat</label>
                <textarea type="text" class="form-control" id="alamat" readonly=""></textarea>
              </div>
              <div class="form-group col-md-8">
                <label>Program</label>
                <input type="text" class="form-control" id="program" readonly="" >
              </div>
            </fieldset>
            <hr />
            <fieldset>
              <legend>Identitas Pribadi Pengganti</legend>
              <div class="form-group col-md-8">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" placeholder="Nama Siswa" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Email</label>
                <input class="form-control" type="email" name="email" placeholder="Email" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Tempat Lahir</label>
                <input class="form-control" type="text" name="tempat_lahir" placeholder="Tempat Lahir" required="">
              </div>
              <div class="form-group col-md-4 has-feedback">
                <label>Tanggal Lahir</label>
                <input type="text" class="form-control has-feedback-left" id="tanggal_lahir" name="tanggal_lahir" placeholder="DD-MM-YYYY" required="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="form-group col-md-6">
                <label>Jenis Kelamin</label>
                <div class="radio">
                  <label class="radio-line" style="padding-right: 20px;"><input type="radio" name="jk" value="m" checked="">Laki-laki</label>
                  <label class="radio-line"><input type="radio" name="jk" value="f">Perempuan</label>
                </div>
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
                    <select name="prov" id="prov" onchange="onSelectProv()" class="form-control" required="">
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
                    <select name="kec_siswa" id="kec" class="form-control" required=""></select>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-8">
                <label>Asal Sekolah</label>
                <input class="form-control" type="text" name="asal_sekolah" placeholder="Asal Sekolah" required="">
              </div>
              <div class="form-group col-md-3">
                <label>Tahun Kelulusan</label>
                <input class="form-control" type="number" maxlength="4" name="tahun_kelulusan" placeholder="YYYY" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Jurusan</label>
                <input class="form-control" type="text" name="jurusan" placeholder="Jurusan" required="">
              </div>
            </fieldset>
            <br /><br />
            <fieldset>
              <legend>Contact & Data Wali</legend>
              <div class="form-group col-md-8">
                <label>Nama Wali</label>
                <input class="form-control" type="text" name="nama_wali" placeholder="Nama Wali" required="">
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat_wali" class="form-control" placeholder="Alamat" rows="8" required=""></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select name="prov" id="prov2" onchange="onSelectProv2()" class="form-control" required="">
                      <option value="0">--- Pilih Provinsi ---</option>
                      <?php foreach($provinsi as $prov): ?>
                      <option value="<?php echo $prov['id_provinsi']; ?>"><?php echo $prov['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kabupaten</label>
                    <select name="kab" id="kab2" onchange="onSelectKab2()" class="form-control" required=""></select>
                  </div>
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec_wali" id="kec2" class="form-control" required=""></select>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-8">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp_wali" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Email</label>
                <input class="form-control" type="email" name="email_wali" placeholder="Alamat Email">
              </div>
            </fieldset>
            <br /><br />
            <fieldset>
              <legend>Program Yang Dipilih</legend>
              <div class="form-group col-md-8">
                <label>Program yang di pilih</label>
                <select class="form-control" name="program_bimbel" id="program_bimbel" onchange="getDetailProgram()" required="">
                  <option value="">--- Pilih Program ---</option>
                  <?php foreach($program as $prog): ?>
                  <option value="<?php echo $prog['id_program']; ?>"><?php echo $prog['nama_program']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-8">
                <label>Harga Program</label>
                <input class="form-control" type="number" id="harga_program" placeholder="Harga Program" readonly="">
              </div>
              <div class="form-group col-md-8">
                <label>Biaya Pendaftaran</label>
                <input class="form-control" type="number" id="biaya_daftar" placeholder="Biaya Pendaftaran" readonly="">
              </div>
            </fieldset>
            <div class="actionBar">
              <button class="btn btn-success" type="submit">DAFTAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function(){
      $('.autocomplete').autocomplete({
          serviceUrl: '<?php echo base_url('search/siswa/?cabangID='.$cabangID.'&keyword='); ?>',
          onSelect: function (suggestion) {
              $('#nis').val(suggestion.nis);
              $('#alamat').val(suggestion.alamat);
              $('#program').val(suggestion.program);
          }
      });

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

    function getDetailProgram(){
      var id = $("#program_bimbel").val();
      $.ajax({
        url: '<?php echo base_url('siswa/getProgram/?id='); ?>' + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $("#harga_program").val(data.harga);
          $("#biaya_daftar").val(data.pendaftaran);
          console.log(data);
        }
      });
    }

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

    function onSelectProv2(){
      var provID = $("#prov2").val();
      $.ajax({
        url: '<?php echo base_url('cabang/getKab/?id='); ?>' + provID,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
          $("#kab2").empty();
          $("#kec2").empty();
          $("#kab2").append(data);
        }
      });
    }

    function onSelectKab2(){
      var KabID = $("#kab2").val();
      $.ajax({
        url: '<?php echo base_url('cabang/getKec/?id='); ?>' + KabID,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
          $("#kec2").empty();
          $("#kec2").append(data);
        }
      });
    }
  </script>