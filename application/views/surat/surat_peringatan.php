<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Surat Peringatan</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form role="form" method="POST" action="<?php echo base_url('surat/action_add_sp/'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
          <div class="form-group">
            <label>Jenis</label>
            <select name="jenis" class="form-control">
              <option value="1">Surat Peringatan 1</option>
              <option value="2">Surat Peringatan 2</option>
            </select>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama" placeholder="">
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" placeholder="">
          </div>
          <fieldset>
            <legend>Alasan Pemberian Surat Peringatan</legend>
            <div id="alasanPemberianSP">
            </div>
            <hr />
            <textarea class="form-control" id="alasanAdd" placeholder="Tulis Disini.."></textarea>
            <button type="button" class="btn btn-block btn-primary" onclick="doAddAlasan()">Tambah Alasan</button>
          </fieldset>
          <div class="actionBar">
            <button class="btn btn-success" type="submit">Ajukan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var idAlasanElement = 1000;

  function doAddAlasan(){
    var alasan = $('#alasanAdd').val();
    var html = '<div class="input-group" id="alasan-'+idAlasanElement+'">';
    html += '<textarea class="form-control" name="alasan[]" readonly="">'+alasan+'</textarea>';
    html += '<span class="input-group-btn">';
    html += '<button type="button" class="btn btn-danger" onclick="doHapus('+idAlasanElement+');">X</button>';
    html += '</span>';
    html += '</div>';
    $('#alasanPemberianSP').append(html);
    $('#alasanAdd').val('');
    idAlasanElement++;
  }

  function doHapus(id){
    $('#alasan-'+id).remove();
  }
</script>