<style>
.datepicker-inline {
    width: 100%;
}
.datepicker table {
    width: 100%;
}
</style>

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

        
      <!-- Small boxes (Stat box) -->
       <div >
 
            <div class="responsive-calendar"></div>

            <div class="text-center">
              <a id="createBookingButton" href="" class="btn btn-primary"><i class="fa fa-pencil"></i> Crear nueva reserva el día <span id="fecha-reserva"></a>
            </div>

            <table id="bookingsTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Usuario</th>
                <th>#</th>
                <th>Horario</th>
                <th>Notas</th>
                <th>Acción</th>
                <th>Fecha reserva</th>
              </tr>
              </thead>

            </table>
          </div>
       </div>    

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->    

  <?php if(in_array('deleteBooking', $user_permission)): ?>
    <!-- remove brand modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Eliminar reserva</h4>
          </div>

          <form role="form" action="<?php echo base_url('bookings/remove') ?>" method="post" id="removeForm">
            <div class="modal-body">
              <p>¿Realmente deseas eliminar la reserva?</p>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Eliminar</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>              
            </div>
          </form>


        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <?php endif; ?>


  <script type="text/javascript">
    
    let booking_date;

    $(document).ready(function() {
      
      $("#bookingMainNav").addClass('active');

      var today = new Date(new Date().getFullYear(),new Date().getMonth() , new Date().getDate());
      
      update(today);

      $('.responsive-calendar').datepicker({
          language: "es",
          todayHighlight: true
      }).on('changeDate', (event) => {                 
        update(event.date);
      });
    });

    function update(date) {
      if (date !== undefined) {
        
        booking_date = date;

        $('#fecha-reserva').html(date.toLocaleDateString());
      
        $("#createBookingButton").attr("href", '<?php echo base_url('bookings/create/') ?>' + booking_date.getTime() / 1000);
        
        getBookingsDay();
      }
    }

     function getBookingsDay()
     {       
       var table = $('#bookingsTable');
       
       table.css('visibility', 'hidden');

       table.DataTable({
          ajax: {
            url   : '<?php echo base_url('bookings/fetchBookingsByDate') ?>',
            type  : 'post',
            data  :  { date : booking_date.getTime() / 1000 },
          },
          order     : [],
          searching : false,
          paging    : false,
          ordering  : false,
          info      : false,
          bDestroy  : true,
          language: { infoEmpty: "Ninguna reserva para esta fecha",
                      emptyTable: "Ninguna reserva para esta fecha",
                      zeroRecords: "Ninguna reserva para esta fecha"
                    },
        });
        table.css('visibility', 'visible');
     }

    function removeFunc(id)
    {
      if(id) {
        $("#removeForm").on('submit', function() {

          var form = $(this);

          // remove the text-danger
          $(".text-danger").remove();

          $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: { booking_id:id }, 
            dataType: 'json',
            success:function(response) {

              // hide the modal
              $("#removeModal").modal('hide');

              getBookingsDay();

              // if(response.success === true) {
              //   $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              //     '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              //     '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              //   '</div>');

              // } else {

              //   $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              //     '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              //     '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
              //   '</div>'); 
              // }
            }
          }); 

          return false;
        });
      }
    }

  </script>
