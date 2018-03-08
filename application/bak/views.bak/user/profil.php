<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6">
      <div class="x_panel">
        <div class="x_title">
          <h2>Form Data User <?php echo $dataUser['nama']; ?></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('user/action_edit'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="id_user" value="<?php echo $dataUser['id_user']; ?>">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama" class="form-control" placeholder="Nama" required="" value="<?php echo $dataUser['nama']; ?>">
            </div>
            <div class="form-group">
              <label>Nomor Pegawai</label>
              <input type="text" name="no_pegawai" class="form-control" placeholder="Nomor Pegawai" required="" value="<?php echo $dataUser['no_pegawai']; ?>">
            </div>
            <div class="form-group">
              <label>Divisi</label>
              <input type="text" name="divisi" class="form-control" placeholder="Divisi" required="" value="<?php echo $dataUser['divisi']; ?>">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email" required="" value="<?php echo $dataUser['email']; ?>">
            </div>
            <div class="form-group">
              <label>No Telp</label>
              <input type="text" name="no_telp" class="form-control" placeholder="No Telepon" required="" value="<?php echo $dataUser['no_telp']; ?>">
            </div>
            <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
              <?php foreach($status as $key => $value): ?>
              <?php $sele = ($dataUser['status']== $key); ?>
              <option value="<?php echo $key; ?>" <?php echo $sele; ?>><?php echo $value; ?></option>
              <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Cabang</label>
              <select name="cabang" class="form-control">
                <?php foreach($cabang as $cab): ?>
                <option value="<?php echo $cab['id_cabang']; ?>"><?php echo $cab['nama']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" name="alamat" placeholder="Alamat" required=""><?php echo $dataUser['alamat']; ?></textarea>
            </div>
            <div class="actionBar">
              <button class="btn btn-warning" onclick="doResetPass()" type="button">Reset Password</button>
              <button class="btn btn-success" type="submit">Ubah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
      <div class="x_panel">
        <div class="x_title">
          <h2>Ubah Otorisasi <?php echo $dataUser['nama']; ?></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form role="form" method="POST" action="<?php echo base_url('user/action_edit_otorisasi'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
            <input type="hidden" name="id_user" value="<?php echo $dataUser['id_user']; ?>">
            <div class="form-group">
              <label>Otorisasi</label>
              <select name="access" class="form-control">
                <?php foreach($roles as $role): ?>
                <?php $sele = ($dataUser['id_access'] == $role['id_access'])?'selected':''; ?>
                <option value="<?php echo $role['id_access']; ?>" <?php echo $sele; ?>><?php echo $role['nama']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Mulai Tanggal</label>
              <input type="text" name="mulai" id="mulai" class="form-control" placeholder="DD-MM-YYYY" required="" value="<?php echo set_value('mulai'); ?>">
            </div>
            <div class="form-group">
              <label>S.D Tanggal</label>
              <input type="text" name="sampai" id="sampai" class="form-control" placeholder="DD-MM-YYYY" required="" value="<?php echo set_value('sampai'); ?>">
            </div>
            <div class="actionBar">
              <button class="btn btn-success" type="submit">Ubah</button>
            </div>
          </form>
        </div>
      </div>
      <div class="x_panel">
        <div class="x_title">
          <h2>History Otorisasi <?php echo $dataUser['nama']; ?></h2>
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
                <th>Otorisasi</th>
                <th>Mulai Tanggal</th>
                <th>S.D Tanggal</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php foreach($historyOtorisasi as $otorisasi): ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $otorisasi['nama']; ?></td>
                <td><?php echo $otorisasi['mulai']; ?></td>
                <td><?php echo $otorisasi['sampai']; ?></td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function(){
        $('#mulai').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          locale: {
              format: 'DD-MM-YYYY'
            },
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#sampai').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          locale: {
              format: 'DD-MM-YYYY'
            },
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });

      function doResetPass(){
        swal({
          title: "Apakah anda yakin?",
          text: "Anda akan mereset password user ini.",
          type: "warning",
          html: true,
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya",
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
        },
        function(){
          $.ajax({
            url: '<?php echo base_url('user/reset_pass/?UserID='.$dataUser['id_user']); ?>',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
             if(data.success){
              swal("Berhasil!", "Password berhasil di reset. Password telah dikirim ke email silahkan periksa email.", "success");
             }
             else{
              swal("Gagal!", "Password gagal di reset.", "error");
             }
            }
          });
        });
      }
    </script>