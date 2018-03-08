<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Bidang & Program</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<label>Bidang</label>
						<select class="form-control" id="bidang">
							<option value="">--- Pilih Bidang ---</option>
							<option value="tpa">Tes Potensi Akademik</option>
							<option value="tbi">Tes Bahasa Inggris</option>
						</select>
					</div>
					<div class="form-group">
						<label>Program</label>
						<select class="form-control" id="program">
							<option value="">--- Pilih Program ---</option>
							<?php foreach($program as $row): ?>
							<option value="<?php echo $row['id_program']; ?>"><?php echo $row['nama_program']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<button class="btn btn-primary btn-block" onclick="goToPage()">SUBMIT</button>
				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript'>
		function goToPage(){
			var bidang = $('#bidang').val();
			var program = $('#program').val();
			if(bidang == '' && program == ''){
				swal({
					title: "OOPS.....",
					text: "Data tidak boleh kosong!!!",
					type: "error",
					timer: 2000,
					showConfirmButton: true
					});
			}
			else{
				window.location.href = "<?php echo base_url($halaman); ?>"+bidang+"&programID="+program;
			}
		}
    </script>