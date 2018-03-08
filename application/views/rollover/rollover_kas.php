<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-4">
    <div class="x_panel">
      <div class="x_title">
        <h2>Form Pengajuan</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form role="form" method="POST" action="<?php echo base_url('rollover_kas/action_add/?cabangID='.$cabangID); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
          <div class="form-group">
            <label>Nominal</label>
            <input type="number" class="form-control" name="nominal" placeholder="Nominal" placeholder="" required="">
          </div>
          <div class="actionBar">
            <button class="btn btn-success" type="submit">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-8 col-xs-8">
    <div class="x_panel">
      <div class="x_title">
        <h2>Rollover Kas Kecil</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="table"
                data-toggle="table"
                data-url="<?php echo base_url('rollover_kas/list_data/?cabangID='.$cabangID); ?>"
                data-show-refresh="true"
                data-show-toggle="true"
                data-show-columns="true"
                data-search="false"
                data-select-item-name="toolbar1"
                data-side-pagination="server"
                data-pagination="true"
                data-page-list="[10, 20, 50, 100, 200]">
          <thead>
            <tr>
                <th data-field="no" data-sortable="true">#</th>
                <th data-field="tanggal" data-sortable="true">Tanggal</th>
                <th data-field="nominal" data-sortable="true">Nominal</th>
                <th data-field="aksi" data-sortable="true">Aksi</th>
            </tr>
            </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function doHapus(id, tanggal){
    swal({
      title: "Apakah anda yakin?",
      text: "Anda akan menghapus <strong>"+tanggal+"</strong>",
      type: "warning",
      html: true,
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, hapus!",
      closeOnConfirm: false
    },
    function(){
      window.location.href = "<?php echo base_url('rollover_kas/delete/?cabangID='.$cabangID.'&rolloverID='); ?>" + id;
    });
  }
</script>