<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Daftar Sesi Jadwal</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Sesi Ke-</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($sesi as $row): ?>
                  <tr>
                    <form action="<?php echo base_url('bimbel/action_edit_sesi/?cabangID='.$cabangID); ?>" method="post" accept="utf-8">
                      <input type="hidden" name="id_sesi" value="<?php echo $row['id_sesi_jadwal']; ?>">
                      <td><input type="text" name="sesi" placeholder="ex: Sesi 1" required="" class="form-control" value="<?php echo $row['sesi']; ?>"></td>
                      <td><input type="time" name="mulai" placeholder="ex: 12:00" required="" class="form-control" value="<?php echo $row['mulai']; ?>"></td>
                      <td><input type="time" name="selesai" placeholder="ex: 14:00" required="" class="form-control" value="<?php echo $row['selesai']; ?>"></td>
                      <td>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="button" onclick="doHapus(<?php echo $row['id_sesi_jadwal'].",'".$row['sesi']."'"; ?>)" class="btn btn-danger">Delete</button>
                      </td>
                    </form>
                  </tr>
                  <?php endforeach; ?>
                  <tr>
                  	<form action="<?php echo base_url('bimbel/action_add_sesi/?cabangID='.$cabangID); ?>" method="post" accept="utf-8">
                      <td><input type="text" name="sesi" placeholder="ex: Sesi 1" required="" class="form-control"></td>
                      <td><input type="time" name="mulai" placeholder="ex: 12:00" required="" class="form-control"></td>
                  		<td><input type="time" name="selesai" placeholder="ex: 14:00" required="" class="form-control"></td>
                  		<td><button type="submit" class="btn btn-primary">Tambah</button></td>
                  	</form>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
    <script type="text/javascript">
		function doHapus(id, nama){
			swal({
				title: "Apakah anda yakin?",
				text: "Anda akan menghapus <strong>"+nama+"</strong>",
				type: "warning",
				html: true,
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus!",
				closeOnConfirm: false
			},
			function(){
				window.location.href = "<?php echo base_url('bimbel/action_delete_sesi/?cabangID='.$cabangID.'&sesiID='); ?>" + id;
			});
		}
	</script>