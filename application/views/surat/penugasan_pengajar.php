<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Form Penugasan Pengajar</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<form role="form" method="POST" action="<?php echo base_url('surat/add_penugasan_pengajar'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
					<input type="hidden" name="id_cabang" value="<?php echo $cabangID; ?>">
					<div class="form-group">
						<label>Penugasan Ke Cabang</label>
						<input type="text" class="form-control autocomplete" placeholder="Search Cabang" required="" >
						<input type="hidden" id="id_cabang_tujuan" name="id_cabang_tujuan" value="">
					</div>
					<div class="form-group">
						<label>Pengajar yang Ditugaskan</label>
						<select class="form-control" name="pengajar">
							<option value="">--- Pilih Pengajar ---</option>
							<?php foreach($pengajar as $row): ?>
							<option value="<?php echo $row['id_pengajar']; ?>"><?php echo $row['nama'] ?> - <?php echo ($row['bidang'] == 'tpa')?'Tes Potensi Akademik':'Tes Bahasa Inggris'; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<label>Kelas Tujuan Ajar</label>
						<select class="form-control" id="daftarKelas" name="kelas">
							<option value="">--- Pilih Kelas ---</option>
						</select>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label>Waktu Mulai</label>
							<input type="text" name="mulai" class="form-control" placeholder="Ex: 14:00" required="">
						</div>
						<div class="form-group col-md-6">
							<label>Waktu Selesai</label>
							<input type="text" name="selesai" class="form-control" placeholder="Ex: SELESAI" required="">
						</div>
					</div>
					<div class="form-group">
						<label>Materi</label>
						<textarea class="form-control" name="materi" rows="5" required=""></textarea>
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
	$(function(){
        $('.autocomplete').autocomplete({
            serviceUrl: '<?php echo base_url('search/cabang'); ?>',
            onSelect: function (suggestion) {
                $('#id_cabang_tujuan').val(suggestion.id_cabang);
                $.ajax({
					url: '<?php echo base_url('surat/get_kelas/?cabangID='); ?>'+suggestion.id_cabang,
					type: 'GET',
					dataType: 'html',
				success: function (data) {
					$('#daftarKelas').empty();
					$('#daftarKelas').append(data);
				}
				});
            }
        });
    });
</script>