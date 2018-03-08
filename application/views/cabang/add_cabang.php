<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Form Data Cabang</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('cabang/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Nama Cabang</label>
									<input class="form-control" type="text" name="nama" placeholder="Nama Cabang" value="<?php echo set_value('nama'); ?>" required="">
								</div>
								<div class="row">
									<div class="form-group col-xs-6">
										<label>Latitude</label>
										<input type="text" class="form-control" name="lat" placeholder="Latitude" required="" value="<?php echo set_value('lat'); ?>">
									</div>
									<div class="form-group col-xs-6">
										<label>Longtitude</label>
										<input type="text" class="form-control" name="lng" placeholder="Longtitude" required="" value="<?php echo set_value('lng'); ?>">
									</div>
								</div>
								<div class="form-group">
									<label>No. Telp</label>
									<input class="form-control" type="text" name="no_telp" placeholder="No Telp" required="" value="<?php echo set_value('no_telp'); ?>">
								</div>
								<div class="form-group">
									<label>No. Fax</label>
									<input class="form-control" type="text" name="fax" placeholder="No Fax" required="" value="<?php echo set_value('fax'); ?>">
								</div>
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="email" name="email" placeholder="Email" required="" value="<?php echo set_value('email'); ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Provinsi</label>
									<select name="prov" id="prov" onchange="onSelectProv()" class="form-control" required="">
										<option value="0">--- Pilih Provinsi ---</option>
										<?php foreach($provinsi as $prov): ?>
										<option value="<?php echo $prov['id_provinsi']; ?>"><?php echo $prov['name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group">
									<label>Kabupaten</label>
									<select name="kab" id="kab" onchange="onSelectKab()" class="form-control" required=""></select>
								</div>
								<div class="form-group">
									<label>Kecamatan</label>
									<select name="kec" id="kec" class="form-control" required=""></select>
								</div>
								<div class="form-group">
									<label>Alamat</label>
									<textarea name="alamat" class="form-control" placeholder="Alamat" required="" value="<?php echo set_value('alamat'); ?>"></textarea>
								</div>
								<div class="form-group">
									<label>Kode POS</label>
									<input type="number" class="form-control" name="pos" placeholder="Kode POS" required="" value="<?php echo set_value('pos'); ?>">
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