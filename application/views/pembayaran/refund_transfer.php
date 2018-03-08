<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Refund</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<form role="form" method="POST" action="<?php echo base_url('pembayaran/action_refund_transfer/?cabangID='.$cabangID); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
					<div class="form-group">
						<label>Nama Siswa</label>
						<input type="text" class="form-control autocomplete" id="nama_siswa" placeholder="Nama Siswa" >
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label>NIS</label>
							<input type="text" name="nis" class="form-control" id="nis" readonly="">
						</div>
						<div class="form-group col-md-6">
							<label>Program</label>
							<input type="text" class="form-control" id="program" readonly="" >
						</div>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea type="text" class="form-control" id="alamat" readonly=""></textarea>
					</div>
					<fieldset>
						<legend>Pembayaran</legend>
						<div class="row">
							<div class="form-group col-md-4">
								<label>Biaya Pendaftaran</label>
								<input type="number" name="biaya_pendaftaran" id="biaya_pendaftaran" class="form-control" readonly="">
							</div>
							<div class="form-group col-md-4">
								<label>Harga Program</label>
								<input type="number" name="harga_program" id="harga_program" class="form-control" readonly="">
							</div>
							<div class="form-group col-md-4">
								<label>Diskon</label>
								<input type="number" name="diskon" id="diskon" class="form-control" readonly="">
							</div>
							<div class="form-group col-md-4">
								<label>Total Harga</label>
								<input type="number" name="total_harga" id="total_harga" class="form-control" readonly="">
							</div>
							<div class="form-group col-md-4">
								<label>Total Pembayaran</label>
								<input type="number" name="total_pembayaran" id="total_pembayaran" class="form-control" readonly="">
							</div>
							<div class="form-group col-md-4">
								<label>Sisa Pembayaran</label>
								<input type="number" name="sisa_pembayaran" id="sisa_pembayaran" class="form-control" readonly="">
							</div>
							<div class="form-group col-md-12">
								<label>Jenis Refund</label>
								<select class="form-control" id="jenis_refund" name="jenis_refund">
									<option value="kelebihan">Kelebihan</option>
									<option value="cancel">Cancel</option>
								</select>
							</div>
							<div class="form-group col-md-12">
								<label>Alasan Refund</label>
								<textarea name="alasan" class="form-control" rows="5" required=""></textarea>
							</div>
						</div>
					</fieldset>
					<div class="actionBar">
						<button type="submit" id="tombolSubmit" style="display: none;">submit</button>
						<button class="btn btn-success" type="button" onclick="lakukanRefund()">Lakukan Refund</button>
					</div>
					</form>
				  </div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script type='text/javascript'>
			function lakukanRefund(){
				let sisa = $('#sisa_pembayaran').val();
				let pilihan = $('#jenis_refund').val();

				if(pilihan == 'kelebihan'){
					if(sisa == 0){
						swal({
							title: "OOPS.....",
							text: "Tidak ada sisa pembayaran!",
							type: "error",
							timer: 2000,
							showConfirmButton: true
							});
					}
					else{
						$('#tombolSubmit').click();
					}
				}
				else{
					$('#tombolSubmit').click();					
				}
			}

	        $(function(){
	            $('.autocomplete').autocomplete({
	                serviceUrl: '<?php echo base_url('search/siswa_refund/?cabangID='.$cabangID.'&keyword='); ?>',
	                onSelect: function (suggestion) {
	                    $('#nis').val(suggestion.nis);
	                    $('#alamat').val(suggestion.alamat);
	                    $('#program').val(suggestion.program);
	                	$('#biaya_pendaftaran').val(suggestion.biaya_pendaftaran);
						$('#harga_program').val(suggestion.harga_program);
						$('#diskon').val(suggestion.diskon);
						$('#total_harga').val(suggestion.total_harga);
						$('#total_pembayaran').val(suggestion.total_pembayaran);
						$('#sisa_pembayaran').val(suggestion.sisa_pembayaran);
	                }
	            });
	        });
    	</script>