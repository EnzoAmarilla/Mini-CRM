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
                <h3 class="card-title">Empresas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if ($empresas->count())
                <table id="empresas-table" class="text-center table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Logo</th>
                    <th>Sitio Web</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($empresas as $empresa)
                    <tr id="tr_{{ $empresa->id }}">  
                      <td class="td-padding">{{ $empresa->nombre }}</td>
                      <td class="td-padding">{{ $empresa->email }}</td>
                      <td class="td-padding"><img class="p-3 w-50" src="{{ Storage::url("$empresa->logotipo") }}" alt="img"/></td>
                      <td class="td-padding"><a href="{{ $empresa->sitio_web }}" target="_blank"><span class="badge badge-light">{{ $empresa->sitio_web }}</span></a></td>
                      <td class="td-padding" data-toggle="modal" data-target="#modal_create_update" onclick="createUpdateEmpresa({{ $empresa->id }});"><a href="javascript:void(0)" style="color: black !important"><i class="fas fa-edit" style="cursor: pointer;"></i></a></td>
                      <td class="td-padding" onclick="warningDelete({{ $empresa->id }});"><i class="fas fa-pause" style="cursor: pointer;"></i></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="col-md-2 p-0">
                  <button type="button" data-toggle="modal" data-target="#modal_create_update" onclick="createUpdateEmpresa(0)" class="mobile-w100 btn btn-block bg-gradient-primary btn-sm mt-3">+ Crear Nueva Empresa</button>
                </div>
                @else
                <div class="alert alert-secondary" role="alert">
                  No hay registros disponibles!
                </div>
                <div class="col-md-2 p-0">
                  <button type="button" data-toggle="modal" data-target="#modal_create_update" onclick="createUpdateEmpresa(0)" class="mobile-w100 btn btn-block bg-gradient-primary btn-sm mt-3">+ Crear Nueva Empresa</button>
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
            <form id="form_empresas" action="/empresas" method="POST" enctype="multipart/form-data">
              <div class="modal-body">
                  @csrf
                  <div id="input_hiden_method"></div>
                <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Introduzcir nombre" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Introduzcir email" required>
                </div>
                <div id="div_file_empresa" class="form-group">
                  <label id="label_file_empresa">Adjuntar logotipo</label>
                  <input type="file" class="form-control" id="logotipo_empresa" name="logotipo_empresa" accept="image/*" required>
                </div>
                <div id="div_image_preview" class="form-group d-none justify-content-center align-items-center" style="width:100% !important">
                  <img id="image_preview" alt="img_preview" style="width:100% !important">
                </div>
                <div class="form-group">
                  <label>Sitio Web</label>
                  <input type="text" class="form-control" id="web_empresa" name="web_empresa" placeholder="Introduzcir sitio web" required>
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
              <button id="eliminarEmpresaBtn" type="submit" class="btn btn-primary">Eliminar</button>
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
      $("#empresas-table").DataTable({
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
      }).buttons().container().appendTo('#empresas-table .col-md-6:eq(0)');
    });

  function createUpdateEmpresa(id) {
      $('#modal_create_update').trigger('reset');
      if(id > 0) {
        editarEmpresa(id);
      }else{
        crearEmpresa();
      }
  }

  function crearEmpresa(){
    $('#modal_create_update_title').html('Nueva Empresa');
    $('#form_empresas').attr('method','POST');
    $('#form_empresas').attr('action','/empresas');
    $('#div_image_preview').removeClass('d-flex');
    $('#image_preview').removeAttr('src');
    $('#div_image_preview').addClass('d-none');
    $('#logotipo_empresa').attr('required','required');
  }
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function editarEmpresa(id){
    $('#modal_create_update_title').html('Editar Empresa');
    $('#form_empresas').attr('action','/empresas/'+id);
    $('#input_hiden_method').html(`<input type="hidden" name="_method" value="PUT">`);
    $('#logotipo_empresa').removeAttr('required');
    // form_empresas
    $.ajax({
      type: 'GET',
      url: '/getDataEmpresa/'+id,
      success: function(data) {
            // console.log(data);
            $('#nombre_empresa').val(data.nombre);
            $('#email').val(data.email);
            $('#div_image_preview').removeClass('d-none');
            $('#image_preview').attr('src','/storage'+data.logotipo.substr(6));
            $('#div_image_preview').addClass('d-flex');
            $('#web_empresa').val(data.sitio_web);
          },
          error: function(data){
              console.log(data);
              Swal.fire('Error al traer los datos de la empresa!', 'Vuelva a intentar nuevamente','error')
          }
      });
  }

  function warningDelete(id){
    $('#modal_delete').modal('show');
    $('#eliminarEmpresaBtn').attr('onclick','deleteEmpresa('+id+')');
  }

  function deleteEmpresa(id){
    $(".preloader").removeAttr('style');
    $.ajax({
          type: 'DELETE',
          url: '/empresas/'+id,
          success: function(data) {
              console.log(data);
              $('#tr_'+id).remove();
              $('#modal_delete').modal('hide');
              $(".preloader").addClass('d-none');
              Swal.fire({
                title: 'Eliminado',
                text: "Empresa eliminada con exito!",
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
              Swal.fire('Error al eliminar empresa!', 'Vuelva a intentar nuevamente','error')
          }
      });
  }
</script>
@endsection