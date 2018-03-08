<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List Materi <?php echo $program['nama_program']; ?> bidang <?php echo ($bidang=='tpa')?'Tes Potensi Akademik':'Tes Bahasa Inggris' ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<button class="btn btn-primary" onclick="addMateri()">+ Tambah Materi</button>
					<table id="table"
			            data-toggle="table"
			            data-url="<?php echo base_url('materi/list_data/?cabangID='.$cabangID.'&bidang='.$bidang.'&programID='.$programID); ?>"
			            data-show-refresh="true"
			            data-show-toggle="true"
			            data-show-columns="true"
			            data-search="true"
			            data-select-item-name="toolbar1"
			            data-side-pagination="server"
			            data-pagination="true"
			            data-page-list="[10, 20, 50, 100, 200]">
						<thead>
					    <tr>
					        <th data-field="no" data-sortable="true">#</th>
					        <th data-field="judul" data-sortable="true">Judul</th>
					        <th data-field="aksi" data-sortable="true">Aksi</th>
					    </tr>
					    </thead>
					</table>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->

		<div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="modalLihatMateri">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalLihatMateri">Add Materi</h4>
				</div>
				<div class="modal-body">
					<div style="text-align: justify;" id="isiMateri"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
			</div>
		</div>

		<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="modalAddMateri">
			<div class="modal-dialog" role="document">
			<form role="form" method="POST" action="<?php echo base_url('materi/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalAddMateri">Add Materi</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id_cabang" value="<?php echo $cabangID; ?>">
					<input type="hidden" name="id_program" value="<?php echo $programID; ?>">
					<input type="hidden" name="bidang" value="<?php echo $bidang; ?>">

					<div class="form-group">
						<label>Judul</label>
						<input type="text" class="form-control" name="judul" placeholder="Judul Materi">
					</div>
					<div class="form-group">
						<label>Isi Materi</label>
						<textarea class="summernote" id="contents" title="Contents" name="isi"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
			</form>
			</div>
		</div>

		<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditMateri">
			<div class="modal-dialog" role="document">
			<form role="form" method="POST" action="<?php echo base_url('materi/action_edit'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalEditMateri">Edit Materi</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id_materi" id="materiIDEdit" >
					<div class="form-group">
						<label>Judul</label>
						<input type="text" class="form-control" id="judulEdit" name="judul" placeholder="Judul Materi">
					</div>
					<div class="form-group">
						<label>Isi Materi</label>
						<textarea class="summernote" id="contentsEdit" title="Contents" name="isi"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
			</form>
			</div>
		</div>

		<script type="text/javascript">
			function addMateri(){
				$("#modalAdd").modal('show');
			}

			function editMateri(id){
				$('#materiIDEdit').val('');
				$('#judulEdit').val('');
				$('#contentsEdit').val('');

				$.ajax({
					url: '<?php echo base_url('materi/get_data/?materiID='); ?>'+id,
					type: 'GET',
					dataType: 'json',
					success: function (data) {
						$('#materiIDEdit').val(data.id_materi);
						$('#judulEdit').val(data.judul);
						$('#contentsEdit').summernote('code', data.isi);
						$("#modalEdit").modal('show');
					}
				});
			}

			function lihatMateri(id){
				$('#modalLihatMateri').empty();
				$('#isiMateri').empty();

				$.ajax({
					url: '<?php echo base_url('materi/get_data/?materiID='); ?>'+id,
					type: 'GET',
					dataType: 'json',
					success: function (data) {
						$('#modalLihatMateri').append(data.judul);
						$('#isiMateri').append(data.isi);
						$("#modalLihat").modal('show');
					}
				});
				
			}

			function doHapus(id, judul){
				swal({
					title: "Apakah anda yakin?",
					text: "Anda akan menghapus <strong>"+judul+"</strong>",
					type: "warning",
					html: true,
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ya, hapus!",
					closeOnConfirm: false
				},
				function(){
					window.location.href = "<?php echo base_url('materi/delete/?materiID='); ?>" + id;
				});
			}
		</script>