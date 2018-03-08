<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Request Pembayaran Khusus</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<p>Form pengajuan pembayaran khusus siswa InfinitySTAN cabang <?php echo $cabang['nama']; ?></p>
					<form role="form" method="POST" action="<?php echo base_url('pengajuan/action_edit_pembayaran_khusus/?cabangID='.$cabangID.(($extra==true)?'&fromDetail=yes':'')); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<input type="hidden" name="id_pembayaran" value="<?php echo $pembayaran['id_req_pembayaran']; ?>">
						<div class="form-group">
							<label>Nama Siswa</label>
							<input type="text" class="form-control" placeholder="Nama Siswa" value="<?php echo $pembayaran['nama']; ?>" readonly="" >
						</div>
						<div class="form-group">
							<label>NIS</label>
							<input type="text" name="nis" class="form-control" value="<?php echo $pembayaran['nis']; ?>" readonly="">
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea type="text" class="form-control" readonly=""><?php echo $pembayaran['alamat'] .", ".$pembayaran['nama_kec'].", ".$pembayaran['nama_kab'].", ".$pembayaran['nama_prov']; ?></textarea>
						</div>
						<div class="form-group">
							<label>Program</label>
							<input type="text" class="form-control" value="<?php echo $pembayaran['nama_program']; ?>" readonly="" >
						</div>
						<fieldset>
							<legend>Pengajuan Rencana Cicilan</legend>
							<div class="row">
								<div class="form-group col-md-3">
									<label>Cicilan 1</label>
									<input type="number" name="cicilan1" class="form-control" value="<?php echo $pembayaran['cicilan1']; ?>" required="" >
								</div>
								<div class="form-group col-md-3">
									<label>Cicilan 2</label>
									<input type="number" name="cicilan2" class="form-control" value="<?php echo $pembayaran['cicilan2']; ?>" required="" >
								</div>
								<div class="form-group col-md-3">
									<label>Cicilan 3</label>
									<input type="number" name="cicilan3" class="form-control" value="<?php echo $pembayaran['cicilan3']; ?>" required="" >
								</div>
								<div class="form-group col-md-3">
									<label>Cicilan 4</label>
									<input type="number" name="cicilan4" class="form-control" value="<?php echo $pembayaran['cicilan4']; ?>" required="" >
								</div>
							</div>
						</fieldset>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">Ajukan</button>
						</div>
					</form>
				  </div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->