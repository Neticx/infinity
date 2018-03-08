<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Form Data User</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('user/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="nama" class="form-control" placeholder="Nama" required="" value="<?php echo set_value('nama'); ?>">
						</div>
						<div class="form-group">
							<label>No Pegawai</label>
							<input type="text" name="no_pegawai" class="form-control" placeholder="Nomor Pegawai" required="" value="<?php echo set_value('no_pegawai'); ?>">
						</div>
						<div class="form-group">
							<label>Divisi</label>
							<input type="text" name="divisi" class="form-control" placeholder="Divisi" required="" value="<?php echo set_value('divisi'); ?>">
						</div>
						<div class="form-group col-md-6">
							<label>Mulai Tanggal</label>
							<input type="text" name="mulai" id="mulai" class="form-control" placeholder="DD-MM-YYYY" required="" value="<?php echo set_value('mulai'); ?>">
						</div>
						<div class="form-group col-md-6">
							<label>S.D Tanggal</label>
							<input type="text" name="sampai" id="sampai" class="form-control" placeholder="DD-MM-YYYY" required="" value="<?php echo set_value('sampai'); ?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Email" required="" value="<?php echo set_value('email'); ?>">
						</div>
						<div class="form-group">
							<label>No Telp</label>
							<input type="text" name="no_telp" class="form-control" placeholder="No Telepon" required="" value="<?php echo set_value('no_telp'); ?>">
						</div>
						<div class="form-group">
							<label>Status</label>
							<select name="status" class="form-control">
								<option value="tetap">Pegawai Tetap</option>
								<option value="panggilan">Pegawai Panggilan</option>
								<option value="pengganti">Pegawai Pengganti</option>
								<option value="sementara">Pegawai Sementara</option>
							</select>
						</div>
						<div class="form-group">
							<label>Otoritas</label>
							<select name="access" class="form-control">
								<?php foreach($roles as $role): ?>
								<option value="<?php echo $role['id_access']; ?>"><?php echo $role['nama']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Cabang</label>
							<select name="cabang" class="form-control">
								<?php foreach($cabang as $cab): ?>
								<option value="<?php echo $cab['id_cabang']; ?>"><?php echo $cab['nama']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea class="form-control" name="alamat" placeholder="Alamat" required=""><?php echo set_value('alamat'); ?></textarea>
						</div>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
	      $('#mulai').daterangepicker({
	        singleDatePicker: true,
	        showDropdowns: true,
	        locale: {
	            format: 'DD-MM-YYYY'
	          },
	      }, function(start, end, label) {
	        console.log(start.toISOString(), end.toISOString(), label);
	      });
	      $('#sampai').daterangepicker({
	        singleDatePicker: true,
	        showDropdowns: true,
	        locale: {
	            format: 'DD-MM-YYYY'
	          },
	      }, function(start, end, label) {
	        console.log(start.toISOString(), end.toISOString(), label);
	      });
	    });
	</script>