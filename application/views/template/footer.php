<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
            </div>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            &copy; Bimbel Infinity All Right Reserved. Powered by  : Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?php echo base_url('assets/'); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets/'); ?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url('assets/'); ?>vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php echo base_url('assets/'); ?>vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php echo base_url('assets/'); ?>vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo base_url('assets/'); ?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url('assets/'); ?>vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php echo base_url('assets/'); ?>vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php echo base_url('assets/'); ?>vendors/Flot/jquery.flot.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php echo base_url('assets/'); ?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php echo base_url('assets/'); ?>vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php echo base_url('assets/'); ?>vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url('assets/'); ?>vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- SummerNote -->
    <script type="text/javascript" src="<?php echo base_url('assets/vendors/summernote'); ?>/summernote.js"></script>
    <script type="text/javascript">
        $(function() {
          $('.summernote').summernote({
            height: 250
          });
        });
    </script>
    <!-- jQuery Tags Input -->
    <script src="<?php echo base_url('assets/'); ?>vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="<?php echo base_url('assets/'); ?>vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url('assets/'); ?>vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="<?php echo base_url('assets/'); ?>vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="<?php echo base_url('assets/'); ?>vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url('assets/'); ?>vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- Bootstrap Table -->
    <script src="<?php echo base_url('assets/'); ?>vendors/bootstrap-table/bootstrap-table.js"></script>
    <!-- Bootstrap Image Upload -->
    <script type="text/javascript" src="<?php echo base_url('assets/vendors/bootstrap-fileupload'); ?>/bootstrap-fileupload.js"></script>
    <!-- Lightbox Master -->
    <script type="text/javascript" src="<?php echo base_url('assets/vendors/lightbox-master/dist/ekko-lightbox.js'); ?>"></script>
    <script type="text/javascript">
        function getNotif(){
            $.ajax({
                url: '<?php echo base_url('notification/get_notif'); ?>',
                type: 'GET',
                dataType: 'json',
                success: function (hasil) {
                    $('#totalNotif').empty();
                    $('#totalNotif').append(hasil.total);
                    $('#daftarNotifikasi').empty();
                    $('#daftarNotifikasi').append(hasil.data);
                }
            });
        }

        $(document).ready(function ($) {
            getNotif();
            setInterval(function () {
                getNotif();
            }, 40000);

            $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                    onShown: function() {
                        if (window.console) {
                            return console.log('Checking our the events huh?');
                        }
                    },
                    onNavigate: function(direction, itemIndex) {
                        if (window.console) {
                            return console.log('Navigating '+direction+'. Current item: '+itemIndex);
                        }
                    }
                });
            });

            $('#open-image').click(function (e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });
            $('#open-youtube').click(function (e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });

            $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                event.preventDefault();

                var lb;
                return $(this).ekkoLightbox({
                    onShown: function() {
                        lb = this;
                        $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                            e.preventDefault();
                            lb.navigateTo(2);
                        });
                    }
                });
            });
        });
    </script>
    <!-- JQuery AutoComplete -->
    <script type="text/javascript" src="<?php echo base_url('assets/vendors/'); ?>autocomplete/jquery.autocomplete.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url('assets/'); ?>build/js/custom.min.js"></script>
  </body>
</html>