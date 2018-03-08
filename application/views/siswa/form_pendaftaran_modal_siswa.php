            <fieldset>
              <center><legend>Cabang</legend></center>
              <div class="form-group col-md-12">
                <label>Cabang</label>
                <input type="text" class="form-control autocomplete" placeholder="Search Cabang" required="">
                <input type="hidden" id="id_cabang" name="id_cabang">
              </div>
            </fieldset>
            <fieldset>
              <center><legend>Identitas Pribadi</legend></center>
              <div class="form-group col-md-12">
                <label>Nama</label>
                <input class="form-control" type="text" name="nama" placeholder="Nama Siswa" required="">
              </div>
              <div class="form-group col-md-12">
                <label>Email</label>
                <input class="form-control" type="email" name="email" placeholder="Email" required="">
              </div>
              <div class="form-group col-md-12">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Tempat Lahir</label>
                <input class="form-control" type="text" name="tempat_lahir" placeholder="Tempat Lahir" required="">
              </div>
              <div class="form-group col-md-6 has-feedback">
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
              <div class="form-group col-md-6">
                <label>Asal Sekolah</label>
                <input class="form-control" type="text" name="asal_sekolah" placeholder="Asal Sekolah" required="">
              </div>
              <div class="form-group col-md-3">
                <label>Tahun Kelulusan</label>
                <input class="form-control" type="number" maxlength="4" name="tahun_kelulusan" placeholder="YYYY" required="">
              </div>
              <div class="form-group col-md-3">
                <label>Jurusan</label>
                <input class="form-control" type="text" name="jurusan" placeholder="Jurusan" required="">
              </div>
            </fieldset>
            <br /><br />
            <fieldset>
               <center><legend>Contact & Data Wali</legend></center>
               <div class="form-group col-md-12">
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
              <div class="form-group col-md-6">
                <label>Nomor Handphone</label>
                <input class="form-control" type="text" name="no_hp_wali" placeholder="Nomor Handphone" required="">
              </div>
              <div class="form-group col-md-6">
                <label>Email</label>
                <input class="form-control" type="email" name="email_wali" placeholder="Alamat Email">
              </div>
            </fieldset>
            <br /><br />
            <fieldset>
            <center><legend>Program Yang Dipilih</legend></center>
              <div class="form-group col-md-12">
                <label>Program yang di pilih</label>
                <select class="form-control" name="program_bimbel" id="program_bimbel" onchange="getDetailProgram()" required="">
                  <option value="">--- Pilih Program ---</option>
                  <?php foreach($program as $prog): ?>
                  <option value="<?php echo $prog['id_program']; ?>"><?php echo $prog['nama_program']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-12">
                <label>Harga Program</label>
                <input class="form-control" type="number" id="harga_program" placeholder="Harga Program" readonly="">
              </div>
              <div class="form-group col-md-12">
                <label>Biaya Pendaftaran</label>
                <input class="form-control" type="number" id="biaya_daftar" placeholder="Biaya Pendaftaran" readonly="">
              </div>
            </fieldset>
          