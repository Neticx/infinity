<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Edit Berita</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<form role="form" method="POST" action="<?php echo base_url('news/action_edit/?NewsID='.$news['id_berita']); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Judul</label>
									<input type="text" class="form-control" name="judul" placeholder="Judul Berita" value="<?php echo $news['judul']; ?>">
								</div>
								<div class="form-group">
									<label>Gambar</label>
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="fileupload-new thumbnail" style="width: 50%; height: 200px;">
											<?php if(!empty($news['foto'])): ?>
			                            	<img src="<?php echo base_url('assets/img/news/'.$news['foto']); ?>" alt="">
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
								<div class="form-group">
									<label>Isi Berita</label>
									<textarea class="summernote" id="contents" title="Contents" name="isi"><?php echo $news['text']; ?></textarea>
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