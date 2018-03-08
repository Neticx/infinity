<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Permintaan Ke Keuangan</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form role="form" method="POST" action="<?php echo base_url('surat/action_add_ke_keuangan/?cabangID='.$cabangID); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
          <div class="form-group">
            <label>Kegiatan</label>
            <textarea class="form-control" name="kegiatan" required="" rows="5" placeholder="Kegiatan"></textarea>
          </div>
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" class="form-control" name="nominal" placeholder="Nominal" placeholder="">
          </div>
          <div class="actionBar">
            <button class="btn btn-success" type="submit">Ajukan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>