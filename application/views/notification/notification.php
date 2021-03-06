<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Notification List</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="table"
              data-toggle="table"
              data-url="<?php echo base_url('notification/list_data'); ?>"
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
                <th data-field="notif">Notification</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>