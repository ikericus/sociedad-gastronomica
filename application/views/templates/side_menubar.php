<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Inicio</span>
          </a>
        </li>
        
        <?php if($user_permission): ?>
        
          <!-- Usuarios -->
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            <li id="userMainNav"><a href="<?php echo base_url('users/') ?>"><i class="fa fa-address-book"></i> <span>Usuarios</span></a></li>
          <?php endif; ?>
        
          <!-- Grupos -->
          <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li id="groupMainNav"><a href="<?php echo base_url('groups/') ?>"><i class="fa fa-users"></i> <span>Grupos</span></a></li>
          <?php endif; ?>
        
          <!-- Mesas -->
          <?php if(in_array('createTable', $user_permission) || in_array('updateTable', $user_permission) || in_array('viewTable', $user_permission) || in_array('deleteTable', $user_permission)): ?>
            <li id="tablesMainNav"><a href="<?php echo base_url('tables/') ?>"><i class="fa fa-square"></i> <span>Mesas</span></a></li>
          <?php endif; ?>
        
          <!-- Reservas -->
          <?php if(in_array('createBooking', $user_permission) || in_array('updateBooking', $user_permission) || in_array('viewBooking', $user_permission) || in_array('deleteBooking', $user_permission)): ?>
            <li id="bookingMainNav"><a href="<?php echo base_url('bookings/') ?>"><i class="fa fa-book"></i> <span>Reservas</span></a></li>
          <?php endif; ?>

          <!-- Categorias -->
          <!-- <?php if(in_array('createCategory', $user_permission) || in_array('updateCategory', $user_permission) || in_array('viewCategory', $user_permission) || in_array('deleteCategory', $user_permission)): ?>
            <li id="categoryMainNav"><a href="<?php echo base_url('category/') ?>"><i class="fa fa-files-o"></i> <span>Categorias</span></a></li>
          <?php endif; ?> -->
        
          <!-- Productos -->
          <?php if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
            <li id="productMainNav"><a href="<?php echo base_url('products/') ?>"><i class="fa fa-glass"></i> <span>Productos</span></a></li>
          <?php endif; ?>

          <!-- Sobres -->
          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li id="OrderMainNav"><a href="<?php echo base_url('orders/') ?>"><i class="fa fa-envelope"></i> <span>Sobres</span></a></li>
          <?php endif; ?>
        
          <!-- Pagos -->
          <?php if(in_array('createPayment', $user_permission) || in_array('updatePayment', $user_permission) || in_array('viewPayment', $user_permission) || in_array('deletePayment', $user_permission)): ?>
            <li id="PaymentMainNav"><a href="<?php echo base_url('payments/') ?>"><i class="fa fa-credit-card"></i> <span>Pagos</span></a></li>
          <?php endif; ?>

          <!-- Informes -->
          <?php if(in_array('viewReport', $user_permission)): ?>
            <li class="treeview" id="ReportMainNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Informes</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('viewReport', $user_permission)): ?>
                  <li id="debtsReportSubMenu"><a href="<?php echo base_url('reports/debts') ?>"><i class="fa fa-circle-o"></i> Deudas</a></li>
                  <li id="topproductsReportSubMenu"><a href="<?php echo base_url('reports/topproducts') ?>"><i class="fa fa-circle-o"></i> Top productos</a></li>
                  <li id="intakesReportSubMenu"><a href="<?php echo base_url('reports/intakes') ?>"><i class="fa fa-circle-o"></i> Consumos</a></li>
                  <!-- <li id="productReportSubMenu"><a href="<?php echo base_url('reports') ?>"><i class="fa fa-circle-o"></i> Product Wise</a></li>
                  <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/storewise') ?>"><i class="fa fa-circle-o"></i> Total Store wise</a></li> -->
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
        
		  <!-- Mi perfil -->
          <?php if(in_array('viewProfile', $user_permission)): ?>
            <li class="treeview" id="profileMainNav">
              <a href="#">
                <i class="fa fa-user"></i>
                <span>Mi perfil</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('viewProfile', $user_permission)): ?>
                  <li id="profileReportSubMenu"><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-circle-o"></i> Mis datos</a></li>
                <?php endif; ?>
                <?php if(in_array('updateProfile', $user_permission)): ?>
                  <li id="settingReportSubMenu"><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-circle-o"></i> Editar</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

        <?php endif; ?>
        

        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Salir</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>