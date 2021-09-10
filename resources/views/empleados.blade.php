@extends('layouts.admin')
@section('title', 'Admin Dashboard - Mini CRM')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ 'Error / Mensaje:  ' . $error }}
                @endforeach
            </div>
        @endif
        @if (\Session::has('message'))
          <div class="alert alert-success">
                {!! \Session::get('message') !!}
          </div>
        @endif
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Empleados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if ($empleados->count())
                <table id="empleados-table" class="text-center table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Empresa</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($empleados as $empleado)
                    <tr id="tr_{{ $empleado->id }}">  
                      <td class="td-padding">{{ $empleado->nombre }}</td>
                      <td class="td-padding">{{ $empleado->apellido }}</td>
                      <td class="td-padding">{{ $empleado->empresa->nombre }}</td>
                      <td class="td-padding">{{ $empleado->email ?? '-' }}</td>
                      <td class="td-padding">{{ $empleado->telefono ?? '-' }}</td>
                      <td class="td-padding" data-toggle="modal" data-target="#modal_create_update" onclick="createUpdateEmpleado({{ $empleado->id }});"><a href="javascript:void(0)" style="color: black !important"><i class="fas fa-edit" style="cursor: pointer;"></i></a></td>
                      <td class="td-padding" onclick="warningDelete({{ $empleado->id }});"><i class="fas fa-pause" style="cursor: pointer;"></i></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="col-md-2 p-0">
                  <button type="button" data-toggle="modal" data-target="#modal_create_update" onclick="createUpdateEmpleado(0)" class="mobile-w100 btn btn-block bg-gradient-primary btn-sm mt-3">+ Crear Nuevo Empleado</button>
                </div>
                @else
                <div class="alert alert-secondary" role="alert">
                  No hay registros disponibles!
                </div>
                <div class="col-md-2 p-0">
                  <button type="button" data-toggle="modal" data-target="#modal_create_update" onclick="createUpdateEmpleado(0)" class="mobile-w100 btn btn-block bg-gradient-primary btn-sm mt-3">+ Crear Nuevo Empleado</button>
                </div>
                @endif
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      <!-- Modal Create Update -->
      <div class="modal fade" id="modal_create_update" tabindex="-1" role="dialog" aria-labelledby="modal_create_update" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_create_update_title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="form_empleados" action="/empleados" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  @csrf
                  <div id="input_hiden_method"></div>
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" class="form-control" id="nombre_empleado" name="nombre_empleado" placeholder="Introduzcir nombre" required>
                </div>
                <div class="form-group">
                  <label>Apellido</label>
                  <input type="text" class="form-control" id="apellido_empleado" name="apellido_empleado" placeholder="Introduzcir apellido" required>
                </div>
                <div class="form-group">
                  <label>Empresa</label>
                    <select class="form-control" name="empresa_id" id="empresa_id">
                      @foreach ($empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Introduzcir email">
                </div>
                <div class="form-group">
                  <label>Teléfono</label>
                  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Introduzcir teléfono">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
          </div>
        </div>
      </div>

      <!-- Modal Delete -->
      <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Registro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Este registro se eliminara, desea continuar ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button id="eliminarEmpleadoBtn" type="submit" class="btn btn-primary">Eliminar</button>
            </div>
          </div>
        </div>
      </div>

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.card -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
<!-- Page specific script -->
<script>
  $('#modal_create_update').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
  })
    $(function () {
      $("#empleados-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "language": {
            "lengthMenu": "Display _MENU_ records per page",
            "zeroRecords": "Sin resultados",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "Sin registros disponibles",
            "infoFiltered": "(filtrando sobre un total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                  "first":      "Primero",
                  "last":       "Último",
                  "next":       "Siguiente",
                  "previous":   "Anterior"
            }
        },
        "paging": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#empleados-table .col-md-6:eq(0)');
    });

  function createUpdateEmpleado(id) {
      $('#modal_create_update').trigger('reset');
      if(id > 0) {
        editarEmpleado(id);
      }else{
        crearEmpleado();
      }
  }

  function crearEmpleado(){
    $('#modal_create_update_title').html('Nuevo Empleado');
    $('#form_empleados').attr('method','POST');
    $('#form_empleados').attr('action','/empleados');
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function editarEmpleado(id){
    $('#modal_create_update_title').html('Editar Empleado');
    $('#form_empleados').attr('action','/empleados/'+id);
    $('#input_hiden_method').html(`<input type="hidden" name="_method" value="PUT">`);
    $.ajax({
      type: 'GET',
      url: '/getDataEmpleado/'+id,
      success: function(data) {
            $('#nombre_empleado').val(data.nombre);
            $('#apellido_empleado').val(data.apellido);
            $('#empresa_id').val(data.empresa_id);
            $('#email').val(data.email);
            $('#telefono').val(data.telefono);
          },
          error: function(data){
              console.log(data);
              Swal.fire('Error al traer los datos de la empleado!', 'Vuelva a intentar nuevamente','error')
          }
      });
  }

  function warningDelete(id){
    $('#modal_delete').modal('show');
    $('#eliminarEmpleadoBtn').attr('onclick','deleteEmpleado('+id+')');
  }

  function deleteEmpleado(id){
    $(".preloader").removeAttr('style');
    $.ajax({
          type: 'DELETE',
          url: '/empleados/'+id,
          success: function(data) {
              console.log(data);
              $('#tr_'+id).remove();
              $('#modal_delete').modal('hide');
              $(".preloader").addClass('d-none');
              Swal.fire({
                title: 'Eliminado',
                text: "Empleado eliminado con exito!",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: 'success',
                confirmButtonText: 'Ok'
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload()
                }
              })
          },
          error: function(data){
              console.log(data);
              $('#modal_delete').modal('hide');
              $(".preloader").addClass('d-none');
              Swal.fire('Error al eliminar empleado!', 'Vuelva a intentar nuevamente','error')
          }
      });
  }
</script>
@endsection