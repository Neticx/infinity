<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Kirim Followup</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('tamu/action_add'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Judul</label>
									<input type="text" class="form-control" name="judul" placeholder="Judul Followup">
								</div>
								<div class="form-group">
									<label>Pesan</label>
									<textarea class="summernote" id="contents" title="Contents" name="isi"></textarea>
								</div>
							</div>
						</div>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">Kirim</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>