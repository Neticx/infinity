<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/'); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('assets/'); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('assets/'); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url('assets/'); ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="<?php echo base_url('assets/'); ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="<?php echo base_url('assets/'); ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="<?php echo base_url('assets/'); ?>vendors/starrr/dist/starrr.css" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url('assets/'); ?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url('assets/'); ?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url('assets/'); ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- SummerNote -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/'); ?>vendors/summernote/summernote.css">
    <!-- SweetAlert -->
    <script src="<?php echo base_url('assets/vendors/sweetalert'); ?>/dist/sweetalert-dev.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendors/sweetalert'); ?>/dist/sweetalert.css">
    <!-- Bootstrap Table -->
    <link href="<?php echo base_url('assets/'); ?>vendors/bootstrap-table/bootstrap-table.css" type="text/css" rel="stylesheet">
    <!-- Bootstrap Image Upload -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendors/bootstrap-fileupload'); ?>/bootstrap-fileupload.css">
    <!-- Lightbox Master -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendors/lightbox-master/dist/ekko-lightbox.css'); ?>">
    <!-- JQuery AutoComplete -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendors/'); ?>autocomplete/jquery.autocomplete.css">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('assets/'); ?>build/css/custom.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/'); ?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Google Maps -->
    <?php if(isset($useMaps)): ?>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyD_m4RL6vKm4i0vIZN7xGPBOdOyG_WApnM&sensor=true"></script>
    <?php endif; ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url(); ?>" class="site_title"><i class="fa fa-graduation-cap"></i> Bimbel Infinity!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo base_url('assets/img/') . (!empty($this->session->userdata('foto_SESS'))?!empty($this->session->userdata('foto_SESS')):'male.png'); ?>" alt="" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->session->userdata('nama_user'); ?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu List</h3>
                <ul class="nav side-menu">
                  <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-home"></i> Home </a></li>
                  <li><a href="<?php echo base_url('notulensi'); ?>"><i class="fa fa-pencil"></i> Notula </a></li>
                  <li><a><i class="fa fa-newspaper-o"></i> Berita <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('news/add'); ?>">Tambah Berita</a></li>
                      <li><a href="<?php echo base_url('news'); ?>">Daftar Berita</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-file-text-o"></i> Siswa <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('siswa/form_pendaftaran'); ?>">Form Pendaftaran Siswa</a></li>
                      <li><a href="<?php echo base_url('siswa/data_siswa'); ?>">Data Siswa</a></li>
                      <li><a href="<?php echo base_url('pengajuan/daftar_pembayaran_khusus'); ?>">Daftar Pengajuan Pembayaran Khusus</a></li>
                      <li><a href="<?php echo base_url('pengajuan/pembayaran_khusus'); ?>">Req Pembayaran Khusus</a></li>
                      <li><a href="<?php echo base_url('pengajuan/daftar_virtual_account'); ?>">Daftar Pengajuan Virtual Account</a></li>
                      <li><a href="<?php echo base_url('pengajuan/virtual_account'); ?>">Req Nomor Virtual Account</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-book"></i> Buku Tamu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('tamu'); ?>">Daftar Tamu</a></li>
                      <li><a href="<?php echo base_url('tamu/add'); ?>">Buku Tamu</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-graduation-cap"></i> Bimbel <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('bimbel/program'); ?>">Program Bimbel</a></li>
                      <li><a href="<?php echo base_url('bimbel/kelas'); ?>">Daftar Kelas</a></li>
                      <li><a href="<?php echo base_url('bimbel/ruang'); ?>">Data Ruangan</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-calendar"></i> Jadwal <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('user'); ?>">Jadwal Pengajar</a></li>
                      <li><a href="<?php echo base_url('user/add'); ?>">Jadwal Siswa</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-university"></i> Cabang <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('cabang'); ?>">Data Cabang</a></li>
                      <li><a href="<?php echo base_url('cabang/add'); ?>">Tambah Data Cabang</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-file-text"></i> Surat Permohonan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li class=""><a>Izin<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu" style="display: none;">
                          <li><a href="<?php echo base_url('permohonan/izin/permohonan_izin'); ?>">Izin</a></li>
                          <li><a href="<?php echo base_url('permohonan/izin/izin_tidak_masuk_kerja'); ?>">Izin Tidak Masuk Kerja</a></li>
                          <li><a href="<?php echo base_url('permohonan/izin/izin_terlambat'); ?>">Izin Terlambat</a></li>
                          <li><a href="<?php echo base_url('permohonan/izin/izin_pulang_awal'); ?>">Izin Pulang Awal</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-vcard-o"></i> Pengajar <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('pengajar/'); ?>">Data Pengajar</a></li>
                      <li><a href="<?php echo base_url('pengajar/add'); ?>">Tambah Pengajar</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-user"></i> Pegawai <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('user'); ?>">Data Pegawai</a></li>
                      <li><a href="<?php echo base_url('user/add'); ?>">Tambah Pegawai</a></li>
                    </ul>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" onclick="javascript:location.href='<?php echo base_url('auth/logout'); ?>';" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo base_url('assets/img/') . (!empty($this->session->userdata('foto_SESS'))?!empty($this->session->userdata('foto_SESS')):'male.png'); ?>" alt=""><?php echo $this->session->userdata('username_SESS'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo base_url('profil'); ?>"> Profile</a></li>
                    <li><a href="<?php echo base_url('auth/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
              <?php if(!empty($this->session->flashdata('alert_type')) && !empty($this->session->flashdata('alert_data'))): ?>
              <?php
                $icon_alert = 'fa-bell';
                switch($this->session->flashdata('alert_type')){
                  case 'success':
                    $icon_alert = 'fa-check-square-o';
                  break;

                  case 'danger':
                    $icon_alert = 'fa-ban';
                  break;

                  case 'warning':
                    $icon_alert = 'fa-warning';
                  break;
                }
              ?>
              <div class="page-title" style="margin-bottom: 20px;">
                <div class="alert bg-<?php echo $this->session->flashdata('alert_type'); ?>" role="alert">
                  <i class="fa <?php echo $icon_alert; ?>"></i> <?php echo $this->session->flashdata('alert_data'); ?>
                </div>
              </div>
              <?php endif; ?>