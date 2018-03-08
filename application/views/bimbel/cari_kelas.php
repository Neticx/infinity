<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Cari Kelas</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="form-group">
						<select class="form-control" id="kelas">
							<?php foreach($kelas as $kel): ?>
							<option value="<?php echo $kel['id_kelas']; ?>"><?php echo $kel['nama_kelas']; ?></option>
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
			var id = $('#kelas').val();
			window.location.href = "<?php echo base_url($halaman) ?>"+id;
		}
    </script>