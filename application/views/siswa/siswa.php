<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-3">
                <!-- Add Siswa -->
                <div class="x_panel">
                    <div class="x_title">
                    <h2><i class="fa fa-user"></i> Pendaftaran Siswa</h2>
                    <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <center><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Tambah Siswa</button></center>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                        <form role="form" method="POST" action="<?php echo base_url('siswa/action_daftar'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h2 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Pendaftaran Siswa</h2>
                            </div>
                            <div class="modal-body">
                                  <?php include('form_pendaftaran_modal_siswa.php') ?>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
              </div>
              <!-- End Add Siswa -->
                <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-university"></i> Data Berdasarkan Cabang</h2>
                            
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
                <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-file-excel-o"></i> Import Siswa</h2>
                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form role="form" method="POST" action="<?php echo base_url('siswa/action_import'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
                                <div class="form-group">
                                    <label>Import Excel</label>
                                    <input type="file" name="userfile" />
                                    <p style="margin-top: 10px; color: red;">** Format file harus xls EXCEL 97/2003</p>
                                </div>
                                <a href="<?php echo base_url('assets/form_siswa.xls'); ?>"><button type="button" class="btn btn-block btn-success">Download Form</button></a>
                                <button type="submit" class="btn btn-block btn-primary">Import Data</button>
                            </form>
                        </div>
                    </div>
			</div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data Seluruh Siswa</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
						<table id="table"
				            data-toggle="table"
				            data-url="<?php echo base_url('siswa/list_data_siswa'); ?>"
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
						        <th data-field="nis" data-sortable="true">NIS</th>
						        <th data-field="nama" data-sortable="true">Nama</th>
						        <th data-field="no_va" data-sortable="true">Nomor Virtual Account</th>
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