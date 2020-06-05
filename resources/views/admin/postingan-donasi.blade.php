@extends('layouts.backend')

@section('title')
YKI | Melihat Posting    
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Posting</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Admin</a></li>
<li class="breadcrumb-item active">Posting</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Posting Donasi</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Judul</th>
                    <th>Publish</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modelHeading">Nonaktif atau Aktifkan Posting</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="productForm" name="productForm" method="POST">
                <input type="hidden" name="id_posting" id="id_posting">
                <div class="form-group">
                    <select name="publish" class="form-control" id="publish"></select>
                </div>
        </div>
        <input type="hidden" name="action" id="action">
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection

@section('script-datatable')
<script>
    $('#mel-posting').addClass('active');
</script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(function() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#productForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Edit') {
                $.ajax({
                    url: "{{ url('admin/melihat-posting/update') }}",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        var toast = "";
                        if (data.errors) {
                            for (var count = 0; count < data.errors.length; count++) {
                                toast = toastr.error("" + data.errors[count] + "");
                            }
                        }
                        if (data.success) {
                            $('#productForm')[0].reset();
                            $('#table').DataTable().ajax.reload();
                            toast = toastr.success(data.success);
                            $('#ajaxModel').modal('hide');
                        }
                        toast;
                    }
                })
            }
        })

        $('body').on('click', '.editProduct', function() {
            var product_id = $(this).data('id');
            $.get("{{ url('admin/melihat-posting') }}" + '/' + product_id + '/edit', function(data) {
                $('#publish').load("{{ route('admin.postingid') }}", function(datas) {
                    $('select[name="publish"]').find('option[value="' + data.publish + '"]').attr("selected", true);
                })
                $('#saveBtn').html("Simpan");
                $('#action').val("Edit");
                $('#ajaxModel').modal('show');
                $('#id_posting').val(data.id);
            })
        });
        
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: "{{ route('admin.melihat-posting') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'user_id',
                    name: 'username'
                },
                {
                    data: 'judul',
                    name: 'judul'
                },
                {
                    data: 'publish',
                    name: 'publish'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endsection

@section('script-css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
