<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Input Nilai</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('nilai/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
					<input type="hidden" name="id_cabang" value="<?php echo $cabangID; ?>">
					<input type="hidden" name="bidang" value="<?php echo $bidang; ?>">
					<input type="hidden" name="kelas" value="<?php echo $kelasID; ?>">
					<div class="form-group">
						<label>Jenis Ujian</label>
						<input type="text" name="jenis" class="form-control" required="" placeholder="Jenis Ujian">
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
							<?php foreach($daftarSiswa as $siswa): ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><input type="text" class="form-control" name="nis[]" value="<?php echo $siswa['nis']; ?>" readonly=""></td>
								<td><input type="text" class="form-control" value="<?php echo $siswa['nama']; ?>" readonly=""></td>
								<td><input type="number" class="form-control" name="nilai[]" required=""></td>
							</tr>
							<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div class="actionBar">
						<button class="btn btn-success" type="submit">SIMPAN</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>