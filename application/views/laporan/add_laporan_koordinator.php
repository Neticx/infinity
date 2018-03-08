<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Add Laporan Koordinator Pengajar</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('laporan/action_add_laporan_koordinator/?cabangID='.$cabangID); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
					<div class="form-group col-md-12">
						<label>Cabang</label>
						<input type="text" class="form-control" readonly="" value="<?php echo $namaCabang; ?>" placeholder="">
					</div>
		        	<div class="form-group col-md-12">
						<label>Nama Pengajar</label>
						<select class="form-control" name="pengajar">
							<?php foreach($pengajar as $row): ?>
							<option value="<?php echo $row['id_pengajar']; ?>"><?php echo $row['nama'].' ['.$row['bidang'].']'; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group col-md-12 has-feedback">
		                <label>Tanggal</label>
		                <input type="text" class="form-control has-feedback-left" id="tanggal" name="tanggal" placeholder="YYYY-MM-DD" required="">
		                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span><br>
		        	</div>
					<div class="form-group col-md-12">
						<label>Jumlah Kelas</label>
						<input type="text" class="form-control" name="jml_kelas" value="0" placeholder="">
					</div>
					<div class="form-group col-md-12">
						<label>Jumlah Sesi</label>
						<input type="text" class="form-control" name="jml_sesi" value="0" placeholder="">
					</div>
					<fieldset class="col-md-12">
						<div class="form-group col-md-6">
							<label>Sesi TPA</label>
							<input type="text" class="form-control" name="sesi_tpa" value="0" placeholder="">
						</div>
						<div class="form-group col-md-6">
							<label>Sesi TBI</label>
							<input type="text" class="form-control" name="sesi_tbi" value="0" placeholder="">
						</div>
					</fieldset>
					<fieldset class="col-md-12">
						<legend>Jumlah Siswa</legend>
						<div class="form-group col-md-6">
							<label>Total</label>
							<input type="text" class="form-control" name="total" value="0" placeholder="">
						</div>
						<div class="form-group col-md-6">
							<label>Masuk</label>
							<input type="text" class="form-control" name="masuk" value="0" placeholder="">
						</div>
					</fieldset>
					<div class="form-group col-md-12">
						<label>Catatan</label>
						<textarea class="form-control" name="catatan" rows="8" placeholder="Catatan"></textarea>
					</div>
					<div class="actionBar col-md-12">
						<button class="btn btn-success" type="submit">SIMPAN</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('#tanggal').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				locale: {
					format: 'YYYY-MM-DD'
				},
			}, function(start, end, label) {
				console.log(start.toISOString(), end.toISOString(), label);
			});
		});
	</script>