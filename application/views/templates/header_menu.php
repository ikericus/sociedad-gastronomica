<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('') ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?php echo $this->config->item('acronym_name') ?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $this->config->item('short_name') ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Alternar vista</span>
        <span><?php echo $this->session->userdata('firstname') ?></span>
      </a>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  