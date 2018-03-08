<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Daftar Ruang</h2>
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
                    <th>No</th>
                    <th>Nama Ruang</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($ruang as $ru): ?>
                  	<tr>
                  		<form action="<?php echo base_url('bimbel/action_edit_ruang/?cabangID='.$cabangID); ?>" method="post" accept="utf-8">
                  			<input type="hidden" name="id_ruang" value="<?php echo $ru['id_ruang']; ?>">
                  			<td><?php echo $i; ?></td>
                  			<td><input type="text" name="ruang" placeholder="Nama Ruang" required="" value="<?php echo $ru['nama_ruang']; ?>" class="form-control"></td>
	                  		<td>
	                  			<button type="submit" class="btn btn-primary">Edit</button> 
	                  			<button type="button" class="btn btn-danger" onclick="doHapus(<?php echo $ru['id_ruang']; ?>,'<?php echo $ru['nama_ruang']; ?>')">Hapus</button>
	                  		</td>
	                  	</form>
                  	</tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
                  <tr>
                  	<form action="<?php echo base_url('bimbel/action_add_ruang/?cabangID='.$cabangID); ?>" method="post" accept="utf-8">
                  		<td colspan="2"><input type="text" name="ruang" placeholder="Nama Ruang" required="" class="form-control"></td>
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
				window.location.href = "<?php echo base_url('bimbel/action_delete_ruang/?cabangID='.$cabangID.'&ruangID='); ?>" + id;
			});
		}
	</script>