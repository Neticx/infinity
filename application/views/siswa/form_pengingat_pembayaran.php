<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Pengingat Pembayaran Siswa</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<p>Form pengajuan pembayaran khusus siswa InfinitySTAN cabang <?php echo $cabang['nama']; ?></p>
					<form role="form" method="GET" action="<?php echo base_url('cetak/pengingat_pembayaran_siswa/'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<input type="hidden" name="cabangID" value="<?php echo $cabangID; ?>">
						<div class="form-group">
							<label>Nama Siswa</label>
							<input type="text" class="form-control autocomplete" id="nama_siswa" placeholder="Nama Siswa" >
						</div>
						<div class="form-group">
							<label>NIS</label>
							<input type="text" name="nis" class="form-control" id="nis" readonly="">
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea type="text" class="form-control" id="alamat" readonly=""></textarea>
						</div>
						<div class="form-group">
							<label>Program</label>
							<input type="text" class="form-control" id="program" readonly="" >
						</div>
						<div class="form-group col-md-12 has-feedback">
			                <label>Paling Lambat</label>
			                <input type="text" class="form-control has-feedback-left" id="paling_lambat" name="paling_lambat" placeholder="DD-MM-YYYY" required="">
			                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span><br>
			            </div>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">Cetak</button>
						</div>
					</form>
				  </div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script type='text/javascript'>
	        $(function(){
	            $('.autocomplete').autocomplete({
	                serviceUrl: '<?php echo base_url('search/siswa/?cabangID='.$cabangID.'&keyword='); ?>',
	                onSelect: function (suggestion) {
	                    $('#nis').val(suggestion.nis);
	                    $('#alamat').val(suggestion.alamat);
	                    $('#program').val(suggestion.program);
	                }
	            });
	            $('#paling_lambat').daterangepicker({
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