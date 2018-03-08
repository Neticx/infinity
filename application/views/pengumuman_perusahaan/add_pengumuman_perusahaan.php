<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Tambahkan Pengumuman Perusahaan</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('pengumuman_perusahaan/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Judul</label>
									<input type="text" class="form-control" name="judul" placeholder="Judul Pengumuman">
								</div>
								<div class="form-group">
									<label>Isi Pengumuman</label>
									<textarea class="summernote" id="contents" title="Contents" name="isi"></textarea>
								</div>
								<div class="form-group">
									<label>Lampiran File</label>
									<input type="file" name="lampiran" placeholder="">
								</div>
							</div>
						</div>
						<hr />
						<div class="row">
							<fieldset class="col-md-12">
								<legend>Pegawai Yang Dituju</legend>
								<div id="daftarPegawaiDituju">
								</div>
							</fieldset>
							<div class="form-group col-md-12">
								<label>Add Pegawai Yang Dituju</label>
								<input type="text" class="form-control autocomplete" placeholder="Cari Pegawai">
							</div>
						</div>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">SIMPAN</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var jumlahElemen = 10000;

		$(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: '<?php echo base_url('search/pegawai'); ?>',
                onSelect: function (suggestion) {
                	addTujuan(suggestion);
                }
            });
        });

        function addTujuan(data){
        	var html = '<div class="col-md-6" id="tujuan-'+jumlahElemen+'">';
			html += '<div class="input-group">';
			html += '<input type="hidden" name="tujuan[]" value="'+data.id_user+'">';
			html += '<input type="text" class="form-control" value="'+data.nama+'" readonly="">';
			html += '<span class="input-group-btn">';
			html += '<button type="button" class="btn btn-danger" onclick="deleteTujuan('+jumlahElemen+')">X</button>';
			html += '</span>';
			html += '</div>';
			html += '</div>';
            $('#daftarPegawaiDituju').append(html);
            $('.autocomplete').val('');
            jumlahElemen++;
        }

        function deleteTujuan(id){
        	$('#tujuan-'+id).remove();
        }

	</script>