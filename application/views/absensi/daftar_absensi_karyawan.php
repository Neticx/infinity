<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendors/datatables/css/dataTables.bootstrap.min.css'); ?>">
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Absensi Karyawan
                    </h2>
					<ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <h5><u><b> <?=$nama_cabang['nama'];?></b></u></h5>
                  <small><i>Periode
                  <?= isset($_GET['start']) ? $_GET['start'] : ''; ?> 
                    	<?= isset($_GET['start']) && ($_GET['end']) ? "s/d" : '';?>
                    	<?= isset($_GET['end']) ? $_GET['end'] : '';?>
                    	<?php
                    	if(isset($_GET['bulan'])) {
	                    	switch ($_GET['bulan']) {
	                    		case '01':
	                    			echo 'Januari'; 
	                    			break;
	                    		case '02':
	                    			echo 'Februari'; 
	                    			break;
	                    		case '03':
	                    			echo 'Maret'; 
	                    			break;
	                    		case '04':
	                    			echo 'April'; 
	                    			break;
	                    		case '05':
	                    			echo 'Mei'; 
	                    			break;
	                    		case '06':
	                    			echo 'Juni'; 
	                    			break;
	                    		case '07':
	                    			echo 'Juli'; 
	                    			break;
	                    		case '08':
	                    			echo 'Agustus'; 
	                    			break;
	                    		case '09':
	                    			echo 'September'; 
	                    			break;
	                    		case '10':
	                    			echo 'Oktober'; 
	                    			break;
	                    		case '11':
	                    			echo 'November'; 
	                    			break;
	                    		case '12':
	                    			echo 'Desember'; 
	                    			break;
	                    		default:
	                    			echo '';
	                    			break;
	                    	}
		                   }
                    	?>
                    	<?= isset($_GET['tahun']) ? $_GET['tahun'] : '';?></i></small>
                    	<hr>
                  <div class="x_content">
						<table id="datatable" class="table table-bordered">
							<thead>
							    <tr>
							        <td>No</td>
							        <td>ID pengajar</td>
							        <td>NAMA</td>
							        <td>KETERANGAN</td>
							    </tr>
						    </thead>
						    <tbody>
						    <?php $no = 1; foreach($data_absensi as $absensi) : ?>
							    <tr>						    	
							        <td><?= $no++ ."."; ?></td>
							        <td><?= $absensi['id_user']; ?></td>
							        <td><?= $absensi['nama']; ?></td>
							        <td>
							        	<?php if($absensi['ket'] == 'M') : ?>
								        	<?php echo "Masuk"; ?> 
									        <?php elseif($absensi['ket'] == 'I') : ?>
								        	<?php echo "Izin"; ?>
								        	<?php elseif($absensi['ket'] == 'S') : ?>
								        	<?php echo "Sakit"; ?>
									        <?php elseif($absensi['ket'] == 'A') : ?>
								        	<?php echo "Alpa"; ?>
								        <?php endif; ?>
							        </td>
							     </tr>
						    <?php endforeach; ?>
						    </tbody>
						</table>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script src="<?= base_url('assets/vendors/datatables/js/jquery.dataTables.js'); ?>"></script>
		<script src="<?= base_url('assets/vendors/datatables/js/dataTables.bootstrap.js'); ?>"></script>
		<script type="text/javascript">
            $('#datatable').DataTable();
    </script>