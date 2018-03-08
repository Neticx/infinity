<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Siswa Kelas</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('bimbel/action_add_siswa_kelas'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
					<input type="hidden" name="id_kelas" value="<?php echo $kelasID; ?>">
					<input type="hidden" name="id_cabang" value="<?php echo $cabangID; ?>">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>NIS</th>
								<th>Nama</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="daftarSiswa">
							<?php $i = 1; ?>
							<?php foreach($siswaKelas as $siswa): ?>
								<tr id="siswa-<?php echo $i; ?>">
								<td><input type="text" readonly="" value="<?php echo $siswa['nis']; ?>" name="nis[]" class="form-control"></td>
								<td><input type="text" readonly="" value="<?php echo $siswa['nama']; ?>" class="form-control"></td>
								<td><button class="btn btn-danger" type="button" onclick="deleteSiswa(<?php echo $i.",'".$siswa['nama']."'"; ?>)"><i class="fa fa-trash"></i></button></td>
								</tr>
							<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"><button type="submit" class="btn btn-primary pull-right">SUBMIT</button></td>
							</tr>
						</tfoot>
					</table>
					</form>
					<hr />
					<div class="form-group">
						<input type="text" class="form-control autocomplete" placeholder="Cari Siswa NIS atau Nama Siswa" >
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var i = <?php echo $i; ?>;
		$(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: '<?php echo base_url('search/siswa/?cabangID='.$cabangID.'&keyword='); ?>',
                onSelect: function (suggestion) {
                    var dataHtml = '<tr id="siswa-'+i+'">';
					dataHtml += '<td><input type="text" readonly="" value="'+suggestion.nis+'" name="nis[]" class="form-control"></td>';
					dataHtml += '<td><input type="text" readonly="" value="'+suggestion.value+'" class="form-control"></td>';
					dataHtml += '<td><button class="btn btn-danger" type="button" onclick="deleteSiswa('+i+',\''+suggestion.value+'\')"><i class="fa fa-trash"></i></button></td>';
					dataHtml += '</tr>';
					$('#daftarSiswa').append(dataHtml);
					$('.autocomplete').val('');
                	i++;
                }
            });
        });

        function deleteSiswa(id, nama){
        	swal({
				title: "Apakah anda yakin?",
				text: "Anda akan menghapus <strong>"+nama+"</strong>",
				type: "warning",
				html: true,
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus!",
				closeOnConfirm: false
			},
			function(){
        		$('#siswa-'+id).remove();
        		swal("Berhasil!", "Berhasil menghapus "+nama, "success");
			});
        }
	</script>