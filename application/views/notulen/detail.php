<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Detail <?php echo $notulensi['agenda']; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <h3><?php echo $notulensi['agenda']; ?></h3>
                  	<p><strong>Tanggal Rapat : </strong> <?php echo $notulensi['tanggal']; ?> | <strong>Tempat : </strong><?php echo $notulensi['tempat']; ?></p>
                    <hr />
                    <p><strong>Isi Notulensi : </strong></p>
                    <?php echo $notulensi['isi_rapat']; ?>
                  </div>
                </div>
            </div>
        </div>