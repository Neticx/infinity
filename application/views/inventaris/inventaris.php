<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>Daftar Inventaris Aset Bimbel Infinity</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							<li><a class="close-link"><i class="fa fa-close"></i></a></li>
						</ul>
						<div class="clearfix">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>Isi</th>
										<th style="width: 110px;">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($inventaris)): ?>
									<?php $i = 1; ?>
									<?php foreach($inventaris as $row): ?>
									<tr>
										<form role="form" method="POST" action="<?php echo base_url('inventaris/action_edit/?cabangID='.$cabangID); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
										<input type="hidden" name="id_inventaris" value="<?php echo $row['id_inventaris']; ?>">
										<td><h2><?php echo $i; ?></h2></td>
										<td>
											<div class="row">
												<div class="form-group col-md-6">
													<label>Nama</label>
													<input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" />
												</div>
												<div class="form-group col-md-6">
													<label>Jenis Barang</label>
													<input type="text" name="jenis" class="form-control" value="<?php echo $row['jenis_barang']; ?>" />
												</div>
												<div class="form-group col-md-6">
													<label>Warna</label>
													<input type="text" name="warna" class="form-control" value="<?php echo $row['warna']; ?>" />
												</div>
												<div class="form-group col-md-6">
													<label>Jumlah</label>
													<input type="number" name="jumlah" class="form-control" value="<?php echo $row['jumlah']; ?>" />
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Merk</label>
														<input type="text" name="merk" class="form-control" value="<?php echo $row['merk']; ?>" />
													</div>
													<div class="form-group">
														<label>Keterangan</label>
														<textarea name="keterangan" class="form-control"><?php echo $row['keterangan']; ?></textarea>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Gambar</label>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="fileupload-new thumbnail" style="width: 50%; height: 200px;">
																<?php if(!empty($row['gambar'])): ?>
								                            	<img src="<?php echo base_url('assets/img/inventaris/'.$row['gambar']); ?>" alt="">
								                            	<?php endif; ?>
															</div>
															<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100%; max-height: 100%; line-height: 30px;"></div>
															<div>
																<span class="btn btn-white btn-file">
																	<span class="btn btn-default fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
																	<span class="btn btn-primary fileupload-exists"><i class="fa fa-undo"></i> Ubah</span>
																	<input type="file" name="gambar" class="default" accept="image/*" multiple="multiple"/>
																</span>
															</div>
														</div>
														<p class="help-block" style="padding: 0px 10px 0px 10px;">Max. 1.5 MB | File format *.PNG *.JPG *.JPEG</p>
													</div>
												</div>
											</div>
										</td>
										<td><button type="submit" class="btn btn-success">Edit</button> <button type="button" class="btn btn-danger" onclick="doHapus(<?php echo $row['id_inventaris']; ?>,'<?php echo $row['nama'].' '.$row['warna'].' '.$row['jenis_barang'].' '.$row['merk']; ?>')">Hapus</button></td>
										</form>
									</tr>
									<?php $i++; ?>
									<?php endforeach; ?>
									<?php else: ?>
									<tr>
										<td colspan="9"><h2>Data Masih Kosong</h2></td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="x_content">
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script type="text/javascript">
			function doHapus(id, nama){
				swal({
					title: "Apakah anda yakin?",
					text: "Anda akan menghapus <strong>"+nama+"</strong>",
					type: "warning",
					html: true,
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ya, hapus!",
					closeOnConfirm: false
				},
				function(){
					window.location.href = "<?php echo base_url('inventaris/delete/?cabangID='.$cabangID.'&InventarisID='); ?>" + id;
				});
			}
		</script>