<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<div class="x_panel">
				<div class="x_title">
					<h2>Profil <?php echo $dataUser['nama']; ?></h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('profil/action_edit'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="nama" class="form-control" placeholder="Nama" required="" value="<?php echo $dataUser['nama']; ?>">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Email" required="" value="<?php echo $dataUser['email']; ?>" readonly="">
						</div>
						<div class="form-group">
							<label>No Telp</label>
							<input type="text" name="no_telp" class="form-control" placeholder="No Telepon" required="" value="<?php echo $dataUser['no_telp']; ?>">
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea class="form-control" name="alamat" placeholder="Alamat" required=""><?php echo $dataUser['alamat']; ?></textarea>
						</div>
						<hr />
						<center><h3>Change Password</h3></center>
						<hr />
						<div class="form-group">
							<label>Old Password</label>
							<input type="password" name="oldpassword" class="form-control" placeholder="Old Password" value="">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password" value="">
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" name="confpassword" class="form-control" placeholder="Confirm Password" value="">
						</div>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>