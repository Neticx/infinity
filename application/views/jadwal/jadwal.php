<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>	
	<div class="row">
		<?php $hariJadwal = array(1 => 'SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU'); ?>
		<?php foreach($hariJadwal as $key => $val): ?>
		<div class="col-md-4 col-sm-4 col-xs-4">
			<div class="x_panel">
				<div class="x_title">
					<h2><?php echo $val; ?></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Jadwal</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1; ?>
							<?php foreach($jadwal[$key] as $row): ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td>
									<p>
										<h3><?php echo $row['nama']; ?></h3>
										<?php echo ($row['bidang']=='tpa')?'Tes Potensi Akademik':'Tes Bahasa Inggris'; ?>
										<?php echo $row['sesi'].' ['.$row['mulai'].'-'.$row['selesai'].']'; ?><br />
										<?php echo $row['nama_ruang']; ?>
									</p>
								</td>
								<td><button class="btn btn-danger btn-xs" onclick="doHapus(<?php echo $row['id_jadwal']; ?>)">Hapus</button></td>
							</tr>
							<?php $i++; ?>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div class="actionBar">
		              <button class="btn btn-primary" type="submit" onclick="showModal(<?php echo $key; ?>)">ADD</button>
		            </div>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

	<div class="modal fade" id="modalJadwal" tabindex="-1" role="dialog" aria-labelledby="modalJadwalLabel">
		<div class="modal-dialog" role="document">
			<form role="form" method="POST" action="<?php echo base_url('jadwal/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalJadwalLabel">Add Jadwal</h4>
				</div>
				<div class="modal-body">
						<input type="hidden"  name="id_cabang" value="<?php echo $cabangID; ?>">
						<input type="hidden"  name="id_kelas" value="<?php echo $kelasID; ?>">
						<input type="hidden" id="hari"  name="hari" value="">
						<div class="form-group">
							<label>Pelajaran</label>
							<select id="pelajaran" onchange="changePelajaran()" class="form-control">
								<option>--- Pilih Pelajaran ---</option>
								<option value="tpa">Tes Potensi Akademik</option>
								<option value="tbi">Tes Bahasa Inggris</option>
							</select>
						</div>
						<div class="form-group">
							<label>Pengajar</label>
							<select id="pengajar" name="pengajar" class="form-control"></select>
						</div>
						<div class="form-group">
							<label>Ruang</label>
							<select name="ruang" class="form-control">
								<?php foreach($ruangan as $ruang): ?>
								<option value="<?php echo $ruang['id_ruang']; ?>"><?php echo $ruang['nama_ruang']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="form-group">
							<label>Sesi</label>
							<select name="sesi" class="form-control">
								<?php foreach($sesi as $row): ?>
								<option value="<?php echo $row['id_sesi_jadwal']; ?>"><?php echo $row['sesi'].' '.$row['mulai'].'-'.$row['selesai']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function showModal(id){
			$("#modalJadwal").modal('show');
			$('#hari').val(id);
		}

		function changePelajaran(){
			var pelajaran = $('#pelajaran').val();
			$('#pengajar').empty();
			$.ajax({
				url: '<?php echo base_url('jadwal/list_pengajar/?bidang='); ?>'+pelajaran,
				type: 'GET',
				dataType: 'html',
			success: function (data) {
				$('#pengajar').append(data);
			}
			});
		}

		function doHapus(id, nama){
			swal({
				title: "Apakah anda yakin?",
				text: "Anda akan menghapus data",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Ya, hapus!",
				closeOnConfirm: false
			},
			function(){
				window.location.href = "<?php echo base_url('jadwal/action_delete/?cabangID='.$cabangID.'&kelasID='.$kelasID.'&jadwalID='); ?>" + id;
			});
		}
	</script>