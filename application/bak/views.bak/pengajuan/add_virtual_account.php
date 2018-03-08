<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Add Virtual Account <?php echo $cabang['nama']; ?></h2>
					<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<p>Ajukan Nomor Virtual Account Siswa Bimbel Infinity <?php echo $cabang['nama']; ?></p>
					<div class="form-group">
						<label>Nama Siswa</label>
						<input type="text" class="form-control autocomplete" id="nama_siswa" placeholder="Nama Siswa" >
					</div>
					<hr />
					<form role="form" method="POST" action="<?php echo base_url('pengajuan/add_va/?cabangID='.$cabang['id_cabang']); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<table class="table table-striped">
							<thead>
								<tr>
									<td>NIS</td>
									<td>Nama</td>
									<td>Program</td>
									<td>Nomor Virtual Account</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody id="listDataVA"></tbody>
						</table>
						<div class="actionBar">
							<button class="btn btn-warning" type="button" onclick="doReset()">RESET</button>
							<button class="btn btn-success" type="submit">AJUKAN</button>
						</div>
					</form>
				</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	<script type='text/javascript'>
		var nomor = 1;

        $(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: '<?php echo base_url('search/siswa/?cabangID='.$cabang['id_cabang'].'&keyword='); ?>',
                onSelect: function (suggestion) {
                	var html;
                	html = "<tr id=\"listVA-"+nomor+"\">";
					html += "<td>";
					html += "<input type=\"text\" class=\"form-control\" name=\"nis[]\" value=\""+suggestion.nis+"\" readonly=\"\">";
					html += "</td>";
					html += "<td>";
					html += "<input type=\"text\" name=\"nama[]\" class=\"form-control\" value=\""+suggestion.value+"\" readonly=\"\">";
					html += "</td>";
					html += "<td><input type=\"text\" name=\"program[]\" class=\"form-control\" value=\""+suggestion.program+"\" readonly=\"\"></td>";
					html += "<td><input type=\"text\" name=\"va[]\" class=\"form-control\" required=\"\"></td>";
					html += "<td><button type=\"button\" class=\"btn btn-danger\" onclick=\"doDelete("+nomor+")\">hapus</button></td>";
					html += "</tr>";
					$('#listDataVA').append(html);
					nomor++;
                	$('#nama_siswa').val('');
                }
            });
        });

        function doDelete(id){
        	swal({
				title: "Apakah anda yakin?",
				text: "Menghapus data pengajuan Virtual Account ini",
				type: "warning",
				html: true,
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus!",
				closeOnConfirm: false
			},
			function(){
				$('#listVA-'+id).remove();
				swal("Berhasil!", "List Data pengajuan berhasil di hapus.", "success");
			});
        }

        function doReset(){
        	swal({
				title: "Apakah anda yakin?",
				text: "Mereset semua pengajuan Virtual Account",
				type: "warning",
				html: true,
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus!",
				closeOnConfirm: false
			},
			function(){
				$('#listDataVA').empty();
				swal("Berhasil!", "List Data pengajuan berhasil di reset.", "success");
			});
        }
	</script>