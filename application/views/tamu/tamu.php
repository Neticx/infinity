<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>  
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Buku Tamu</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
						<table id="table"
				            data-toggle="table"
				            data-url="<?php echo base_url('tamu/list_data'); ?>"
				            data-show-refresh="true"
				            data-show-toggle="true"
				            data-show-columns="true"
				            data-search="true"
				            data-select-item-name="toolbar1"
				            data-side-pagination="server"
				            data-pagination="true"
				            data-page-list="[10, 20, 50, 100, 200]">
							<thead>
						    <tr>
						        <th data-field="no" data-sortable="true">#</th>
						        <th data-field="nama_siswa" data-sortable="true">Nama</th>
						        <th data-field="email" data-sortable="true">Email</th>
						        <th data-field="no_hp" data-sortable="true">Nomor Hp</th>
						        <th data-field="tahu_infinity" data-sortable="true">Tahu Infinity</th>
						        <th data-field="aksi" data-sortable="true">Aksi</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script type="text/javascript">
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
					window.location.href = "<?php echo base_url('siswa/delete/?NIS='); ?>" + id;
				});
			}
        </script>
          <script type="text/javascript">
            $(function(){
            $('#tanggal_lahir').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY'
                },
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            });

            function getDetailProgram(){
            var id = $("#program_bimbel").val();
            $.ajax({
                url: '<?php echo base_url('siswa/getProgram/?id='); ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                $("#harga_program").val(data.harga);
                $("#biaya_daftar").val(data.pendaftaran);
                console.log(data);
                }
            });
            }

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

            function onSelectProv2(){
            var provID = $("#prov2").val();
            $.ajax({
                url: '<?php echo base_url('cabang/getKab/?id='); ?>' + provID,
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                $("#kab2").empty();
                $("#kec2").empty();
                $("#kab2").append(data);
                }
            });
            }

            function onSelectKab2(){
            var KabID = $("#kab2").val();
            $.ajax({
                url: '<?php echo base_url('cabang/getKec/?id='); ?>' + KabID,
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                $("#kec2").empty();
                $("#kec2").append(data);
                }
            });
            }
        </script>