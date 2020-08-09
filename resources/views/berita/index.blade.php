@extends('layouts.backend')

@section('title')
YKI | Berita   
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Berita</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Admin</a></li>
<li class="breadcrumb-item active">Berita</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Berita</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-default" data-toggle="modal" id="createNewProduct">
            Tambah
          </button>
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Publish</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modelHeading">Tambah Bank</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="productForm" name="productForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_berita" id="id_berita">
                <div class="form-group">
                    <label for="judul" class="form-control-label">Judul</label>
                    <input type="text" class="form-control" id="judul" name="judul">
                </div>
                <div class="form-group">
                    <label for="Deskripsi" class="form-control-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
                </div>
                <div class="form-group">
                    <label for="gambar" class="form-control-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
                <div class="form-group">
                    <label for="publish" class="form-control-label">Publish</label>
                    <select name="publish" id="publish" class="form-control">
                    </select>
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

  <div class="modal fade" id="ajaxHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">Hapus Berita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" id="yakinHapus">
                <p>Yakin Mau Menghapus Ini !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="hapus_button">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script-datatable')
<script>  
    $('#berita').addClass('active');
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

        $('#createNewProduct').click(function() {
            $('#productForm')[0].reset();
            $('#saveBtn').html('Tambah');
            $('#action').val('Tambah');
            $('#publish').load("{{ route('berita.beritaid') }}")
            $('#ajaxModel').modal('show');
        });

        $('#productForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Tambah') {

                $.ajax({
                    url: "{{ route('berita.store') }}",
                    method: 'POST',
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
            } //1
            if ($('#action').val() == 'Edit') {
                $.ajax({
                    url: "{{ url('admin/berita/update') }}",
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
            $.get("{{ url('admin/berita') }}" + '/' + product_id + '/edit', function(data) {
                $('#publish').load("{{ route('berita.beritaid') }}", function(datas) {
                    $('select[name="publish"]').find('option[value="' + data.publish + '"]').attr("selected", true);
                })
                $('#saveBtn').html("Simpan");
                $('#action').val("Edit");
                $('#ajaxModel').modal('show');
                $('#modelHeading').text('Update Berita')
                console.log(data);
                $('#id_berita').val(data.id);
                $('#judul').val(data.judul);
                $('#deskripsi').val(data.deskripsi);
                // $('#gambar').val(data.gambar);
            })
        });

        var product_id;
        $(document).on('click', '.delete', function() {
            product_id = $(this).data("id");
            $.get("{{ url('admin/getberita') }}" + '/' + product_id, function(data) {
                $('#yakinHapus').text('Yakin Menghapus Atas Judul ' + data.judul + ' ?')
            })
            $('#ajaxHapus').modal('show');
        });

        $('#hapus_button').click(function() {
            $.ajax({
                url: "/admin/berita/destroy" + "/" + product_id,
                method: "POST",
                success: function(data) {
                    var toast = "";
                    setTimeout(function() {
                        $('#hapus_button').text('Menghapus...');
                        $('#ajaxHapus').modal('hide');
                        $('#table').DataTable().ajax.reload();
                    }, 500);

                    if (data.error) {
                        toast = toastr.error("Data tidak dapat dihapus");
                    }

                    if (data.success) {
                        toast = toastr.success(data.success);
                    }
                }
            })
        });
        
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url : "{{ url('/admin/berita') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'judul',
                    name: 'judul'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
                },
                {
                    data: 'gambar',
                    name: 'gambar'
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
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
