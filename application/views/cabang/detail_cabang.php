<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Detail Cabang <?php echo $dataCabang['nama']; ?></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <center><h1>Detail Data Cabang <?php echo $dataCabang['nama']; ?></h1></center>
          <hr />
          <div class="row">
            <div class="col-md-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td>No Cabang</td>
                    <td><strong><?php echo $dataCabang['id_cabang']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Nama</td>
                    <td><strong><?php echo $dataCabang['nama']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td><strong><?php echo $dataCabang['email']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>No Telp</td>
                    <td><strong><?php echo $dataCabang['no_telp']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>No Fax</td>
                    <td><strong><?php echo $dataCabang['no_fax']; ?></strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Alamat</td>
                    <td><strong><?php echo $dataCabang['alamat']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Kecamatan</td>
                    <td><strong><?php echo $dataCabang['kecamatan']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Kabupaten</td>
                    <td><strong><?php echo $dataCabang['kabupaten']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Provinsi</td>
                    <td><strong><?php echo $dataCabang['provinsi']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>POS</td>
                    <td><strong><?php echo $dataCabang['kode_pos']; ?></strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <hr />
          <fieldset>
            <legend>Kepala Cabang</legend>
            <table class="table table-stripped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>No Telp</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($kepCab)): ?>
                <tr>
                  <td><?php echo $kepCab['nama']; ?></td>
                  <td><?php echo $kepCab['email']; ?></td>
                  <td><?php echo $kepCab['no_telp']; ?></td>
                  <td><button class="btn btn-xs btn-danger" onclick="doHapus(<?php echo $kepCab['id_user']; ?>,'<?php echo $kepCab['id_cabang']; ?>')">hapus</button></td>
                </tr>
                <?php else: ?>
                <tr>
                  <td colspan="3">
                    <hr /><center>Data Kepala Cabang belum ada!. Silahkan tambahkan data <br /><br />
                    <form role="form" method="POST" action="<?php echo base_url('cabang/action_add_kc'); ?>" autocomplete="off" enctype="multipart/form-data" accept-charset="utf-8">
                      <input type="text" class="form-control autocomplete" placeholder="Search Pegawai" required=""><br />
                      <input type="hidden" name="id_user_kc" id="id_user_kc" value="">
                      <input type="hidden" name="id_cabang" value="<?php echo $dataCabang['id_cabang']; ?>">
                    <button class="btn btn-primary" type="submit">Tambahkan Kepala Cabang</button></center><hr />
                    </form>
                  </td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </fieldset>
          <hr />
          <fieldset>
            <legend>Pegawai Cabang</legend>
            <table class="table table-stripped">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>No Telp</th>
                  <th>Otoritas</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($pegawai)): ?>
                  <?php foreach($pegawai as $peg): ?>
                    <tr>
                      <td><?php echo $peg['nama']; ?></td>
                      <td><?php echo $peg['email']; ?></td>
                      <td><?php echo $peg['no_telp']; ?></td>
                      <td><?php echo $peg['access']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                <tr>
                  <td colspan="3">
                    <center><h3>Data Pegawai belum ada!. Silahkan tambahkan data</h3></center>
                  </td>
                </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </fieldset>
          <hr />
          <div id="map"></div>
          <hr />
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function(){
      $('.autocomplete').autocomplete({
          serviceUrl: '<?php echo base_url('search/kepala_cabang'); ?>',
          onSelect: function (suggestion) {
              $('#id_user_kc').val(suggestion.id_user);
          }
      });

      var LatLng = {lat: <?php echo $dataCabang['lat']; ?>, lng: <?php echo $dataCabang['lng']; ?>};
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: LatLng,
          mapTypeId: google.maps.MapTypeId.TERRAIN,
            mapTypeControl: false,
            zoomControl: true,
            scrollwheel:  false,
            streetViewControl: false,
            draggable: true,
            fullscreenControl: false,
            disableDoubleClickZoom: false
        });
      var marker = new google.maps.Marker({
        position: LatLng,
        map: map
      });
    });

    function doHapus(id, id2){
      swal({
        title: "Apakah anda yakin?",
        text: "Anda akan menghapus kepala cabang",
        type: "warning",
        html: true,
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, hapus!",
        closeOnConfirm: false
      },
      function(){
        window.location.href = "<?php echo base_url('cabang/delete_kc/?userID='); ?>" + id + "&cabangID=" + id2;
      });
    }
  </script>