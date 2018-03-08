<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Form Edit Data Cabang</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('cabang/action_edit'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<input type="hidden" name="id_cabang" value="<?php echo $dataCabang['id_cabang']; ?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Cabang</label>
									<input class="form-control" type="text" name="nama" placeholder="Nama Cabang" value="<?php echo $dataCabang['nama']; ?>" required="">
								</div>
								<div class="row">
									<div class="form-group col-xs-6">
										<label>Latitude</label>
										<input type="text" class="form-control" name="lat" placeholder="Latitude" required="" value="<?php echo $dataCabang['lat']; ?>">
									</div>
									<div class="form-group col-xs-6">
										<label>Longtitude</label>
										<input type="text" class="form-control" name="lng" placeholder="Longtitude" required="" value="<?php echo $dataCabang['lng']; ?>">
									</div>
								</div>
								<div class="form-group">
									<label>No. Telp</label>
									<input class="form-control" type="text" name="no_telp" placeholder="No Telp" required="" value="<?php echo $dataCabang['no_telp']; ?>">
								</div>
								<div class="form-group">
									<label>No. Fax</label>
									<input class="form-control" type="text" name="fax" placeholder="No Fax" required="" value="<?php echo $dataCabang['no_fax']; ?>">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" name="email" placeholder="Email" required="" value="<?php echo $dataCabang['email']; ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Provinsi</label>
									<select name="prov" id="prov" onchange="onSelectProv()" class="form-control" required="">
										<option value="0">--- Pilih Provinsi ---</option>
										<?php foreach($provinsi as $prov): ?>
										<?php $sele = ($prov['id_provinsi'] == $dataCabang['id_provinsi'])?'selected':''; ?>
										<option value="<?php echo $prov['id_provinsi']; ?>" <?php echo $sele; ?>><?php echo $prov['name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label>Kabupaten</label>
									<select name="kab" id="kab" onchange="onSelectKab()" class="form-control" required="">
										<option value="0">--- Pilih Kabupaten ---</option>
										<?php foreach($kabupaten as $kab): ?>
										<?php $sele = ($kab['id_kabupaten'] == $dataCabang['id_kabupaten'])?'selected':''; ?>
										<option value="<?php echo $kab['id_kabupaten']; ?>" <?php echo $sele; ?>><?php echo $kab['name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label>Kecamatan</label>
									<select name="kec" id="kec" class="form-control" required="">
										<option value="0">--- Pilih Kecamatan ---</option>
										<?php foreach($kecamatan as $kec): ?>
										<?php $sele = ($kec['id_kecamatan'] == $dataCabang['id_kecamatan'])?'selected':''; ?>
										<option value="<?php echo $kec['id_kecamatan']; ?>" <?php echo $sele; ?>><?php echo $kec['name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<textarea name="alamat" class="form-control" placeholder="Alamat" required="" value="<?php echo set_value('alamat'); ?>"><?php echo $dataCabang['alamat']; ?></textarea>
								</div>
								<div class="form-group">
									<label>Kode POS</label>
									<input type="number" class="form-control" name="pos" placeholder="Kode POS" required="" value="<?php echo $dataCabang['kode_pos']; ?>">
								</div>
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
		function onSelectProv(){
			var provID = $("#prov").val();
			$.ajax({
				url: '<?php echo base_url('cabang/getKab/?id='); ?>' + provID,
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$("#kab").empty();
					$("#kec").empty();
					$("#kab").append(data);
				}
			});
		}

		function onSelectKab(){
			var KabID = $("#kab").val();
			$.ajax({
				url: '<?php echo base_url('cabang/getKec/?id='); ?>' + KabID,
				type: 'GET',
				dataType: 'html',
				success: function (data) {
					$("#kec").empty();
					$("#kec").append(data);
				}
			});
		}
	</script>