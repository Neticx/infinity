<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row">
    <div class="col-md-8 col-sm-8 col-xs-8">
      <div class="x_panel">
        <div class="x_title">
          <h2>Form Pendaftaran Siswa</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('siswa/action_edit/?NIS='.$nis); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <fieldset>
              <legend>Cabang</legend>
              <div class="form-group col-md-8">
                <label>Cabang</label>
                <input class="form-control" type="text" value="<?php echo $cabang["nama"]; ?>" required="" readonly="">
                <input type="hidden" name="id_cabang" value="<?php echo $cabang["id_cabang"]; ?>">
                <input type="hidden" name="nis" value="<?php echo $dataSiswa["nis"]; ?>">
              </div>
            </fieldset>
            <fieldset>
              <legend>Identitas Pribadi</legend>
              <div class="form-group col-md-8">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" placeholder="Nama Siswa" value="<?php echo $dataSiswa['nama']; ?>" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="<?php echo $dataSiswa['email']; ?>" placeholder="Email" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp" value="<?php echo $dataSiswa['no_hp']; ?>" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Tempat Lahir</label>
                <input class="form-control" type="text" name="tempat_lahir" value="<?php echo $dataSiswa['tmpt_lahir']; ?>" placeholder="Tempat Lahir" required="">
              </div>
              <div class="form-group col-md-4 has-feedback">
                <label>Tanggal Lahir</label>
                <input type="text" class="form-control has-feedback-left" id="tanggal_lahir" name="tanggal_lahir" placeholder="DD-MM-YYYY" value="<?php echo $tgl_lahir; ?>" required="">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
              </div>
              <div class="form-group col-md-6">
                <label>Jenis Kelamin</label>
                <div class="radio">
                  <label class="radio-line" style="padding-right: 20px;"><input type="radio" name="jk" value="m" <?php echo(($dataSiswa['jk'] == 'm')?"checked":"") ?>>Laki-laki</label>
                  <label class="radio-line"><input type="radio" name="jk" value="f" <?php echo(($dataSiswa['jk'] == 'f')?"checked":"") ?>>Perempuan</label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Alamat" rows="8" required=""><?php echo $dataSiswa['alamat']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select name="prov" id="prov" onchange="onSelectProv()" class="form-control" required="">
                      <option value="0">--- Pilih Provinsi ---</option>
                      <?php foreach($provinsi as $prov): ?>
                      <?php $sele = ($prov['id_provinsi'] == $dataLokasi['id_provinsi'])?"selected":""; ?>
                      <option value="<?php echo $prov['id_provinsi']; ?>" <?php echo $sele; ?>><?php echo $prov['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kabupaten</label>
                    <select name="kab" id="kab" onchange="onSelectKab()" class="form-control" required="">
                      <option value="0">--- Pilih Kabupaten ---</option>
                      <?php foreach($kabupaten as $kab): ?>
                      <?php $sele = ($kab['id_kabupaten'] == $dataLokasi['id_kabupaten'])?"selected":""; ?>
                      <option value="<?php echo $kab['id_kabupaten']; ?>" <?php echo $sele; ?>><?php echo $kab['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec_siswa" id="kec" class="form-control" required="">
                      <option value="0">--- Pilih Kecamatan ---</option>
                      <?php foreach($kecamatan as $kec): ?>
                      <?php $sele = ($kec['id_kecamatan'] == $dataLokasi['id_kecamatan'])?"selected":""; ?>
                      <option value="<?php echo $kec['id_kecamatan']; ?>" <?php echo $sele; ?>><?php echo $kec['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-8">
                <label>Asal Sekolah</label>
                <input class="form-control" type="text" name="asal_sekolah" value="<?php echo $dataSiswa['asal_sekolah']; ?>" placeholder="Asal Sekolah" required="">
              </div>
              <div class="form-group col-md-3">
                <label>Tahun Kelulusan</label>
                <input class="form-control" type="number" maxlength="4" name="tahun_kelulusan" value="<?php echo $dataSiswa['tahun_lulus']; ?>" placeholder="YYYY" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Jurusan</label>
                <input class="form-control" type="text" name="jurusan" value="<?php echo $dataSiswa['jurusan']; ?>" placeholder="Jurusan" required="">
              </div>
            </fieldset>
            <br /><br />
            <fieldset>
              <legend>Contact & Data Wali</legend>
              <div class="form-group col-md-8">
                <label>Nama Wali</label>
                <input class="form-control" type="text" name="nama_wali" value="<?php echo $dataSiswa['nama_wali']; ?>" placeholder="Nama Wali" required="">
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat_wali" class="form-control" placeholder="Alamat" rows="8" required=""><?php echo $dataSiswa['alamat_wali']; ?></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Provinsi</label>
                    <select name="prov" id="prov2" onchange="onSelectProv2()" class="form-control" required="">
                      <option value="0">--- Pilih Provinsi ---</option>
                      <?php foreach($provinsi as $prov): ?>
                      <?php $sele = ($prov['id_provinsi'] == $dataLokasi2['id_provinsi'])?"selected":""; ?>
                      <option value="<?php echo $prov['id_provinsi']; ?>" <?php echo $sele; ?>><?php echo $prov['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kabupaten</label>
                    <select name="kab" id="kab2" onchange="onSelectKab2()" class="form-control" required="">
                      <option value="0">--- Pilih Kabupaten ---</option>
                      <?php foreach($kabupaten2 as $kab): ?>
                      <?php $sele = ($kab['id_kabupaten'] == $dataLokasi2['id_kabupaten'])?"selected":""; ?>
                      <option value="<?php echo $kab['id_kabupaten']; ?>" <?php echo $sele; ?>><?php echo $kab['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec_wali" id="kec2" class="form-control" required="">
                      <option value="0">--- Pilih Kecamatan ---</option>
                      <?php foreach($kecamatan2 as $kec): ?>
                      <?php $sele = ($kec['id_kecamatan'] == $dataLokasi2['id_kecamatan'])?"selected":""; ?>
                      <option value="<?php echo $kec['id_kecamatan']; ?>" <?php echo $sele; ?>><?php echo $kec['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-8">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp_wali" value="<?php echo $dataSiswa['no_hp_wali']; ?>" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-8">
                <label>Email</label>
                <input class="form-control" type="email" name="email_wali" value="<?php echo $dataSiswa['email_wali']; ?>" placeholder="Alamat Email">
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
                  <?php $sele = ($dataSiswa['id_program'] == $prog['id_program'])?'selected':''; ?>
                  <option value="<?php echo $prog['id_program']; ?>" <?php echo $sele; ?>><?php echo $prog['nama_program']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-8">
                <label>Harga Program</label>
                <input class="form-control" type="number" id="harga_program" name="harga_program" value="" placeholder="Harga Program" readonly="">
              </div>
              <div class="form-group col-md-8">
                <label>Biaya Pendaftaran</label>
                <input class="form-control" type="number" id="biaya_daftar" name="biaya_daftar" value="" placeholder="Biaya Pendaftaran" readonly="">
              </div>
            </fieldset>
            <div class="actionBar">
              <button class="btn btn-success" type="submit">UBAH</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4">
      <div class="x_panel">
        <div class="x_title">
          <h2>List Menu</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <p>
            <?php if(empty($pembayaran)): ?>
            <a href="<?php echo base_url('pengajuan/pembayaran_khusus/?cabangID='.$cabang['id_cabang'].'&NIS='.$dataSiswa['nis']); ?>"><button class="btn btn-block btn-success"><i class="fa fa-fire"></i> Request Pembayaran Khusus</button></a>
            <?php endif; ?>
            <a href="<?php echo base_url('siswa/pengingat_pembayaran_siswa/?cabangID='.$cabang['id_cabang']); ?>"><button class="btn btn-block btn-info"><i class="fa fa-print"></i> Pengingat Pembayaran</button></a>
            <a href="<?php echo base_url('cetak/form_pendaftaran/?cabangID='.$cabang['id_cabang'].'&NIS='.$dataSiswa['nis']); ?>" target="_blank"><button class="btn btn-block btn-warning"><i class="fa fa-print"></i> Cetak Formulir Pendaftaran</button></a>
          </p>
        </div>
      </div>

      <?php if(!empty($pembayaran)): ?>
      <div class="x_panel">
        <div class="x_title">
          <h2>Pembayaran Khusus</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <p>Status : <?php echo ($pembayaran['disetujui'] == '0')?'<span class="label label-danger">Belum Disetujui</span>':'<span class="label label-success">Disetujui</span>'; ?></p>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Pembayaran</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Cicilan 1</td>
                <td><?php echo formatRP($pembayaran['cicilan1']); ?></td>
              </tr>
              <tr>
                <td>Cicilan 2</td>
                <td><?php echo formatRP($pembayaran['cicilan2']); ?></td>
              </tr>
              <tr>
                <td>Cicilan 3</td>
                <td><?php echo formatRP($pembayaran['cicilan3']); ?></td>
              </tr>
              <tr>
                <td>Cicilan 4</td>
                <td><?php echo formatRP($pembayaran['cicilan4']); ?></td>
              </tr>
            </tbody>
          </table>
          <p>
            <a href="<?php echo base_url('pengajuan/edit_pembayaran_khusus/?cabangID='.$cabang['id_cabang'].'&reqID='.$pembayaran['id_req_pembayaran'].'&fromDetail=yes'); ?>"><button class="btn btn-block btn-success"><i class="fa fa-fire"></i> Ubah Request Pembayaran Khusus</button></a>
          </p>
        </div>
      </div>
      <?php endif; ?>
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

    getDetailProgram();
  </script>