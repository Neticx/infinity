<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Edit Virtual Account <?php echo $cabang['nama']; ?></h2>
					<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
					<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<p>Ubah Pengajuan Nomor Virtual Account Siswa Bimbel Infinity <?php echo $cabang['nama']; ?></p>
					<hr />
					<form role="form" method="POST" action="<?php echo base_url('pengajuan/action_edit_va/?cabangID='.$cabang['id_cabang'].'&reqID='.$id_va); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<table class="table table-striped">
							<thead>
								<tr>
									<td>NIS</td>
									<td>Nama</td>
									<td>Program</td>
									<td>Nomor Virtual Account</td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($sub_req_va as $row): ?>
								<tr>
									<input type="hidden" name="id_sub_req[]" value="<?php echo $row['id_sub_req_va']; ?>">
									<td>
										<input type="text" class="form-control" value="<?php echo $row['nis']; ?>" readonly="">
									</td>
									<td>
										<input type="text" class="form-control" value="<?php echo $row['nama']; ?>" readonly="">
									</td>
									<td>
										<input type="text" class="form-control" value="<?php echo $row['nama_program']; ?>" readonly="">
									</td>
									<td>
										<input type="text" name="va[]" class="form-control" value="<?php echo $row['virtual_account']; ?>" required="">
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<div class="actionBar">
							<button class="btn btn-success" type="submit">UBAH</button>
						</div>
					</form>
				</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->