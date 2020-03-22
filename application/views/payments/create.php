

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Gestionar
      <small>Pagos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Pagos</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Añadir pago</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="product_name">Fecha</label>
                  <input type="text" class="form-control" id="datetime" name="datetime" placeholder="Introduce fecha" autocomplete="off" value="<?php echo $date_time ?>"/>
                </div>

                <div class="form-group">
                  <label for="price">Suma</label>
                  <input type="text" class="form-control" id="amount" name="amount" placeholder="Introduce cantidad" autocomplete="off" />
                </div>

                <div class="form-group">
                  <label for="category">Usuario</label>
                  <select class="form-control select_group" id="user_id" name="user_id">
                    <?php foreach ($users_data as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['firstname'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="concept">Concepto</label>
                  <input type="text" class="form-control" id="concept" name="concept" placeholder="Introduce concepto" autocomplete="off" />
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?php echo base_url('payments/') ?>" class="btn btn-warning">Salir</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#paymentMainNav").addClass('active');
    
    $('#datetimepicker').datetimepicker({locale: 'es'});

  });
</script>