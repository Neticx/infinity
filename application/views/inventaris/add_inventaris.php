<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Inventaris</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form role="form" method="POST" action="<?php echo base_url('inventaris/action_add/?cabangID='.$cabangID); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="form-group col-md-12">
              <label>Nama</label>
              <input class="form-control" type="text" name="nama" placeholder="Nama">
            </div>
            <div class="form-group col-md-6">
              <label>Jenis</label>
              <input class="form-control" type="text" name="jenis" placeholder="Jenis">
            </div>
            <div class="form-group col-md-6">
              <label>Warna</label>
              <input class="form-control" type="text" name="warna" placeholder="Warna">
            </div>
            <div class="form-group col-md-6">
              <label>Jumlah</label>
              <input class="form-control" type="number" name="jumlah" placeholder="Jumlah">
            </div>
            <div class="form-group col-md-6">
              <label>Merk</label>
              <input class="form-control" type="text" name="merk" placeholder="Merk">
            </div>
            <div class="form-group col-md-12">
              <label>Gambar</label>
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 50%; height: 200px;"></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 100%; line-height: 30px;"></div>
                <div>
                  <span class="btn btn-white btn-file">
                    <span class="btn btn-default fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                    <span class="btn btn-primary fileupload-exists"><i class="fa fa-undo"></i> Ubah</span>
                    <input type="file" name="gambar" class="default" accept="image/*" multiple="multiple"/>
                  </span>
                </div>
              </div>
              <p class="help-block" style="padding: 0px 10px 0px 10px;">Max. 1.5 MB | File format *.PNG *.JPG *.JPEG</p>
            </div>
            <div class="form-group col-md-12">
              <label>Keterangan</label>
              <textarea class="form-control" rows="5" name="keterangan"></textarea>
            </div>
            <div class="actionBar col-md-12">
              <button class="btn btn-success" type="submit">SIMPAN</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>