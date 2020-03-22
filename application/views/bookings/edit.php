  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gestión
        <small>Reservas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Gestión</a></li>
        <li class="active">reservas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
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

        <form role="form" action="<?php base_url('bookings/create') ?>" method="post">
          <div class="box-body">

            <?php echo validation_errors(); ?>

            <div class="form-group">
              <label for="fecha-reserva">Fecha</label> 
              <span id="fecha-reserva"></span> 
              <input type="hidden" id="date" name="date" value="<?php echo $this->data['booking_data']['date'] ?>">              
            </div>

            <div class="form-group">
              <label for="people">Nº personas</label> 
              <select class="form-control" id="people" name="people">
                <?php for($i = 1; $i<=$this->data['booking_data']['totalCapacity']+1; $i++)
                { 
                  if($i == $this->data['booking_data']['people'])
                    echo "<option value='$i' selected>$i</option>";
                  else
                    echo "<option value='$i' >$i</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">            
            
              <?php $serialize_timetables = unserialize($booking_data['timetables']); ?>

              <label for="timetables">Horario</label>
              <table class="table table-responsive">
                <tbody>
                  <tr>
                    <td><input type="checkbox" name="timetables[]" value="almuerzo" <?php 
                        if($serialize_timetables) {
                          if(in_array('almuerzo', $serialize_timetables)) { echo "checked"; } 
                        }
                        ?>> Almuerzo</td>                    
                    <td><input type="checkbox" name="timetables[]" value="comida" <?php 
                        if($serialize_timetables) {
                          if(in_array('comida', $serialize_timetables)) { echo "checked"; } 
                        }
                        ?>> Comida</td>
                    <td><input type="checkbox" name="timetables[]" value="merienda" <?php 
                        if($serialize_timetables) {
                          if(in_array('merienda', $serialize_timetables)) { echo "checked"; } 
                        }
                        ?>> Merienda</td>
                    <td><input type="checkbox" name="timetables[]" value="cena" <?php 
                        if($serialize_timetables) {
                          if(in_array('cena', $serialize_timetables)) { echo "checked"; } 
                        }
                        ?>> Cena</td>
                  </tr>
              </table>
            </div>

            <div class="form-group">
              <label for="remarks">Notas</label>
              <textarea class="form-control" id="remarks" name="remarks" placeholder="Indica si vas a usar horno o cualquier otra cosa" autocomplete="off"><?php echo $this->data['booking_data']['remarks'] ?></textarea>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Guardar reserva</button>
              <a href="<?php echo base_url('bookings/') ?>" class="btn btn-warning">Volver</a>
            </div>
          </form>
       </div>    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->    

  <script type="text/javascript">
    
    $(document).ready(function() {      
      var date = new Date(<?php echo $this->data['booking_data']['date'] ?> * 1000);
      $('#fecha-reserva').html(date.toLocaleDateString());
    });

  </script>
