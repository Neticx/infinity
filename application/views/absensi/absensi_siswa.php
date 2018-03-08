<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-4">
			<div class="x_panel">
				<div class="x_title">
					<h2>Generate Absensi Siswa</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<select class="form-control" id="jenis">
							<option value="masuk">Absensi Masuk</option>
							<option value="pulang">Absensi Pulang</option>
						</select>
					</div>
					<button class="btn btn-primary btn-block" onclick="generateQR()">SUBMIT</button>
				</div>
			</div>
		</div>

		<div class="col-md-8 col-sm-8 col-xs-8">
			<div class="x_panel">
				<div class="x_title">
					<h2>Absensi Siswa</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div id="content_absen"><center><h2>Belum di Generate</h2><hr /></center></div>
					<table class="table table-fixed">
						<thead>
							<tr>
								<th class="col-xs-3">No</th>
								<th class="col-xs-6">Nama</th>
								<th class="col-xs-3">Waktu</th>
							</tr>
						</thead>
						<tbody id="daftar_absen">
							<tr><td class="col-xs-12"><center><h2>Belum Ada Data</h2></center></td></tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript'>
		var urlAbsen = null;
		function generateQR(){
			var jenis = $('#jenis').val();
			if(jenis == 'masuk'){
				$.ajax({
					url: '<?php echo base_url('absensi/gen_absensi_masuk/?cabangID='.$cabangID.'&tipe=siswa'); ?>',
					type: 'GET',
					dataType: 'json',
					success: function (hasil) {
						urlAbsen = hasil.url;
						$('#content_absen').empty();
						$('#content_absen').append(hasil.data);
					}
		        });
			}
			else{
				$.ajax({
					url: '<?php echo base_url('absensi/gen_absensi_pulang/?cabangID='.$cabangID.'&tipe=siswa'); ?>',
					type: 'GET',
					dataType: 'json',
					success: function (hasil) {
						urlAbsen = hasil.url;
						$('#content_absen').empty();
						$('#content_absen').append(hasil.data);
					}
		        });
			}
		}

		function retrieveAbsen(){
			if(urlAbsen != null){
				$.ajax({
					url: '<?php echo base_url('absensi/'); ?>'+urlAbsen,
					type: 'GET',
					dataType: 'html',
					success: function (data) {
						$('#daftar_absen').empty();
						$('#daftar_absen').append(data);
					}
		        });
			}
		}

		$(document).ready(function () {
			setInterval(function () {
		        retrieveAbsen();
		    }, 10000);
		});
    </script>