<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Program Bimbel</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Program</th>
                    <th>Harga Program</th>
                    <th>Biaya Pendaftaran</th>
                    <th>Sesi Kelas</th>
                    <th>Sesi Try Out</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i=1; ?>
                  <?php foreach($program as $prog): ?>
                  <tr>
                    <form role="form" method="POST" action="<?php echo base_url('bimbel/action_edit_program/?ProgramID='.$prog['id_program']); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
                      <td><?php echo $i; ?></td>
                      <td>
                        <input type="text" class="form-control" value="<?php echo $prog['nama_program']; ?>" name="nama" placeholder="Nama Program" required="">
                      </td>
                      <td>
                        <input type="number" class="form-control" value="<?php echo $prog['harga']; ?>" name="harga" placeholder="Harga Program" required="">
                      </td>
                      <td>
                        <input type="number" class="form-control" value="<?php echo $prog['pendaftaran']; ?>" name="pendaftaran" placeholder="Biaya Pendaftaran" required="">
                      </td>
                      <td>
                        <input type="number" style="max-width: 80px;" class="form-control" value="<?php echo $prog['sesi_kelas']; ?>" name="sesi_kelas" placeholder="0" required="">
                      </td>
                      <td>
                        <input type="number" style="max-width: 80px;" class="form-control" value="<?php echo $prog['sesi_to']; ?>" name="sesi_to" placeholder="0" required="">
                      </td>
                      <td>
                        <button class="btn btn-primary" type="submit">Ubah Data</button>
                        <!-- <button class="btn btn-danger" type="button" onclick="doHapus(<?php echo $prog['id_program']; ?>,'<?php echo $prog['nama_program']; ?>')">Hapus Data</button> -->
                      </td>
                    </form>
                  </tr>
                  <?php $i++; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>