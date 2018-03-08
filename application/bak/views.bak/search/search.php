<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Cari Cabang</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						<li><a class="close-link"><i class="fa fa-close"></i></a></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="input-group">
						<input type="text" class="form-control autocomplete" placeholder="Search Cabang" >
						<input type="hidden" id="id_cabang" value="">
						<span class="input-group-btn">
							<button type="button" class="btn btn-primary" onclick="stateGo();">Go!</button>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type='text/javascript'>
        $(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: '<?php echo base_url('search/cabang'); ?>',
                onSelect: function (suggestion) {
                    $('#id_cabang').val(suggestion.id_cabang);
                }
            });
        });

        function stateGo(){
        	var cabangID = $('#id_cabang').val();
        	if(cabangID != ""){
        		window.location.href = "<?php echo base_url($halaman); ?>" + cabangID;
        	}
        	else{
        		swal({
					title: "OOPS.....",
					text: "Nama Cabang tidak boleh kosong!!!",
					type: "error",
					timer: 2000,
					showConfirmButton: true
					});
        	}
        }
    </script>