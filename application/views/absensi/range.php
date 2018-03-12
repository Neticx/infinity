<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Bulan</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label>Bulan</label>
						<select class="form-control" id="bulan">
							<option value="01">Januari</option>
							<option value="02">Februari</option>
							<option value="03">Maret</option>
							<option value="04">April</option>
							<option value="05">Mei</option>
							<option value="06">Juni</option>
							<option value="07">Juli</option>
							<option value="08">Agustus</option>
							<option value="09">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">Desember</option>
						</select>
					</div>
					<div class="form-group">
						<label>Tahun</label>
						<select class="form-control" id="tahun">
							<?php for($i=2018; $i <= date('Y'); $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
						</select>
					</div>
					<button class="btn btn-primary btn-block" onclick="goToPage('bulan')">SUBMIT</button>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Range</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group col-md-12 has-feedback">
						<label>Range Mulai</label>
						<input type="text" class="form-control has-feedback-left" id="tanggal-mulai" placeholder="DD-MM-YYYY" required="">
						<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span><br>
					</div>
					<div class="form-group col-md-12 has-feedback">
						<label>Range Selesai</label>
						<input type="text" class="form-control has-feedback-left" id="tanggal-selesai" placeholder="DD-MM-YYYY" required="">
						<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span><br>
					</div>
					<button class="btn btn-primary btn-block" onclick="goToPage('range')">SUBMIT</button>
				</div>
			</div>
		</div>
	</div>
	<?= $halaman; ?>
	<script type='text/javascript'>
		function goToPage(jenis){
			if(jenis=='bulan'){
				var bulan = $('#bulan').val();
				var tahun = $('#tahun').val();
				window.location.href = "<?php echo base_url($halaman) ?>&jenis="+jenis+"&bulan="+bulan+"&tahun="+tahun;
			}
			else{
				var mulai = $('#tanggal-mulai').val();
				var selesai = $('#tanggal-selesai').val();
				window.location.href = "<?php echo base_url($halaman) ?>&jenis="+jenis+"&start="+mulai+"&end="+selesai;
			}
		}

		$(function(){
			$('#tanggal-mulai').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				locale: {
					format: 'DD-MM-YYYY'
				},
			}, function(start, end, label) {
				console.log(start.toISOString(), end.toISOString(), label);
			});

			$('#tanggal-selesai').daterangepicker({
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