<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Siswa</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
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
					<div class="actionBar col-md-12 ">
						<button class="btn btn-success" type="submit" onclick="lihatTagihan()">Lihat Tagihan</button>
					</div>
				  </div>
				</div>
			</div><!--/.row-->

			<div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Detail Tagihan</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<div id="dataTagihan"></div>
                  	<br />
                  	<div id="bayarTagihan" style="display: none;">
                  		<table class="table table-stripped">
                  			<thead>
                  				<tr>
                  					<th>Nominal Pembayaran</th>
                  					<th>Aksi</th>
                  				</tr>
                  			</thead>
                  			<tbody>
                  				<tr>
                  					<td><input type="number" id="nominalPembayaran" class="form-control"></td>
                  					<td><button class="btn btn-primary" onclick="doBayar()">Bayar</button></td>
                  				</tr>
                  			</tbody>
                  		</table>
                  	</div>
                  </div>
                </div>
            </div>
		</div>	<!--/.main-->
		<script type='text/javascript'>
			var nis = '';

			function lihatTagihan(){
				nis = $('#nis').val();

				if(nis == ''){
					swal({
						title: "OOPS.....",
						text: "Silahkan Cari Siswa Terlebih dahulu!",
						type: "error",
						timer: 2000,
						showConfirmButton: true
						});
				}
				else{
					$.ajax({
						url: '<?php echo base_url('pembayaran/do_cek_tagihan/?nis='); ?>'+nis,
						type: 'GET',
						dataType: 'html',
						success: function (data) {
							$('#dataTagihan').empty();
							var html = '<blockquote>';
							html += '<h1>'+$('#nama_siswa').val()+'</h1>';
							html += '<p><strong>NIS : '+$('#nis').val()+'</strong></p>';
							html += '<p><strong>Program : '+$('#program').val()+'</strong></p>';
							html += '</blockquote>';
							$('#dataTagihan').append(html);
							$('#dataTagihan').append(data);
							$('#bayarTagihan').show(1000);
						}
			        });
				}
			}

			function convertToRupiah(angka){
				var rupiah = '';		
				var angkarev = angka.toString().split('').reverse().join('');
				for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
				return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
			}

			function doBayar()
			{
				let inputanPembayaran = $('#nominalPembayaran').val();

				if(inputanPembayaran == ''){
					swal({
						title: "OOPS.....",
						text: "Silahkan Isikan Nominal dengan Benar!",
						type: "error",
						timer: 2000,
						showConfirmButton: true
						});
				}
				else{
					swal({
						title: "Apakah anda yakin?",
						text: "Anda menginputkan pembayaran <strong>"+convertToRupiah(inputanPembayaran)+"</strong>",
						type: "warning",
						html: true,
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "Iya",
						cancelButtonText: "Tidak",
						closeOnConfirm: false,
						showLoaderOnConfirm: true,
					},
					function(){
						$.post("<?php echo base_url('pembayaran/send_pembayaran'); ?>",
						{
				          NIS: nis,
				          nominal: inputanPembayaran,
				        },
				        function (data) {
				        	if(data.success){
								swal("Berhasil!", "Berhasil melakukan pembayaran.", "success");
								$('#nominalPembayaran').val('');
								lihatTagihan();
							}
							else{
								swal("Gagal!", "Gagal melakukan pembayaran.", "error");
							}
				        });
					});
				}
			}

	        $(function(){
	            $('.autocomplete').autocomplete({
	                serviceUrl: '<?php echo base_url('search/siswa/?cabangID='.$cabangID.'&keyword='); ?>',
	                onSelect: function (suggestion) {
	                    $('#nis').val(suggestion.nis);
	                    $('#alamat').val(suggestion.alamat);
	                    $('#program').val(suggestion.program);
	                }
	            });
	        });
    	</script>