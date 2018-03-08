<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Lihat Nilai</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label>Bidang</label>
						<select onchange="changedOpsi()" id="bidangLihat" class="form-control">
							<option value="">--- Pilih Bidang ---</option>
							<option value="tpa">Tes Potensi Akademik</option>
							<option value="tbi">Tes Bahasa Inggris</option>
						</select>
					</div>
					<div class="form-group">
						<label>Kelas</label>
						<select onchange="changedOpsi()" id="kelasLihat" class="form-control">
							<option value="">--- Pilih Kelas ---</option>
							<?php foreach($kelas as $kel): ?>
							<option value="<?php echo $kel['id_kelas']; ?>"><?php echo $kel['nama_kelas']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Jenis Ujian</label>
						<select id="jenisLihat" class="form-control">
							<option value="">--- Pilih Jenis Ujian ---</option>
						</select>
					</div>
					<hr />
					<button class="btn btn-block btn-primary" onclick="goToLihat()">Lihat Nilai</button>
				</div>
			</div>
		</div>

		<div class="col-md-6 col-sm-6 col-xs-6">
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
					<div class="form-group">
						<label>Bidang</label>
						<select id="bidangInput" class="form-control">
							<option value="">--- Pilih Bidang ---</option>
							<option value="tpa">Tes Potensi Akademik</option>
							<option value="tbi">Tes Bahasa Inggris</option>
						</select>
					</div>
					<div class="form-group">
						<label>Kelas</label>
						<select id="kelasInput" class="form-control">
							<option value="">--- Pilih Kelas ---</option>
							<?php foreach($kelas as $kel): ?>
							<option value="<?php echo $kel['id_kelas']; ?>"><?php echo $kel['nama_kelas']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<hr />
					<button class="btn btn-block btn-primary" onclick="goToInput()">Input Nilai</button>
				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript'>
		function changedOpsi(){
			var bidang = $('#bidangLihat').val();
			var kelas = $('#kelasLihat').val();
			if(bidang != '' && kelas != ''){
				$('#jenisLihat').empty();
				$.ajax({
					url: '<?php echo base_url('nilai/jenis_ujian/?cabangID='.$cabangID.'&bidang='); ?>'+bidang+'&kelasID='+kelas,
					type: 'GET',
					dataType: 'html',
					success: function (data) {
						$('#jenisLihat').append(data);
					}
				});
			}
		}
		function goToLihat(){
			var bidang = $('#bidangLihat').val();
			var kelas = $('#kelasLihat').val();
			var jenis = $('#jenisLihat').val();
			if(bidang == '' || kelas == '' || jenis == ''){
				swal({
					title: "OOPS.....",
					text: "Data tidak boleh kosong!!!",
					type: "error",
					timer: 2000,
					showConfirmButton: true
					});
			}
			else{
				window.location.href = "<?php echo base_url('nilai/?cabangID='.$cabangID); ?>"+"&bidang="+bidang+"&kelasID="+kelas+"&jenis="+jenis;
			}
		}

		function goToInput(){
			var bidang = $('#bidangInput').val();
			var kelas = $('#kelasInput').val();
			if(bidang == '' || kelas == ''){
				swal({
					title: "OOPS.....",
					text: "Data tidak boleh kosong!!!",
					type: "error",
					timer: 2000,
					showConfirmButton: true
					});
			}
			else{
				window.location.href = "<?php echo base_url('nilai/input_nilai/?cabangID='.$cabangID.'&bidang='); ?>"+bidang+"&kelasID="+kelas;
			}
		}
    </script>