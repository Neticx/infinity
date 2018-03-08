<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Notulensi Rapat <?php echo $cabang['nama']; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  	<form role="form" method="POST" action="<?php echo base_url('notulensi/action_add/?cabangID='.$cabang['id_cabang']); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
						<div class="row">
							<div class="form-group col-md-12">
								<label>Agenda</label>
								<input type="text" class="form-control" name="agenda" placeholder="Agenda" required="">
							</div>
							<div class="form-group col-md-4 has-feedback">
								<label>Tanggal</label>
								<input type="text" class="form-control has-feedback-left" id="tanggal_rapat" name="tanggal" placeholder="DD-MM-YYYY" required="">
                				<span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
							</div>
							<div class="form-group col-md-8">
								<label>Tempat</label>
								<input type="text" class="form-control" name="tempat" placeholder="Tempat" required="">
							</div>
							<div class="form-group col-md-12">
								<label>Isi</label>
								<textarea class="summernote" id="contents" title="Contents" name="isi"></textarea>
							</div>
						</div>
						<div class="actionBar">
			              <button class="btn btn-success" type="submit">SIMPAN</button>
			            </div>
					</form>
				  </div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script type="text/javascript">
		$(function(){
	      $('#tanggal_rapat').daterangepicker({
	        singleDatePicker: true,
	        showDropdowns: true,
	        locale: {
	            format: 'DD-MM-YYYY'
	          },
	      }, function(start, end, label) {
	        console.log(start.toISOString(), end.toISOString(), label);
	      });
	    });
		</script>