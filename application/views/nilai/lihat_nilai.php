<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Lihat Nilai Siswa</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('nilai/action_update'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
					<input type="hidden" name="id_cabang" value="<?php echo $cabangID; ?>">
					<input type="hidden" name="bidang" value="<?php echo $bidang; ?>">
					<input type="hidden" name="kelas" value="<?php echo $kelasID; ?>">
					<div class="form-group">
						<label>Jenis Ujian</label>
						<input type="text" name="jenis" class="form-control" value="<?php echo $jenis; ?>" required="" placeholder="Jenis Ujian">
					</div>
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>No</th>
								<th>NIS</th>
								<th>Nama</th>
								<th>Nilai</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($listNilai as $nilai): ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td>
									<input type="hidden" name="id_nilai[]" value="<?php echo $nilai['id_nilai']; ?>">
									<input type="text" class="form-control" value="<?php echo $nilai['nis']; ?>" readonly="">
								</td>
								<td><input type="text" class="form-control" value="<?php echo $nilai['nama']; ?>" readonly=""></td>
								<td><input type="number" class="form-control" name="nilai[]" value="<?php echo $nilai['nilai']; ?>" required=""></td>
							</tr>
							<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div class="actionBar">
						<button class="btn btn-danger" onclick="doHapus()" type="button">DELETE ALL</button>
						<button class="btn btn-success" type="submit">UPDATE</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function doHapus(){
			swal({
				title: "Apakah anda yakin?",
				text: "Anda akan menghapus daftar nilai ini",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus!",
				closeOnConfirm: false
			},
			function(){
				window.location.href = "<?php echo base_url('nilai/action_delete/?cabangID='.$cabangID.'&kelasID='.$kelasID.'&bidang='.$bidang.'&jenis='.base64_encode($jenis)); ?>";
			});
		}
	</script>