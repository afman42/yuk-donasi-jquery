@extends('layouts.backend')

@section('title')
YKI | Bank   
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Bank</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Penggalang Dana</a></li>
<li class="breadcrumb-item active">Bank</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Bank</h3>

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
                    <th>No. Rek</th>
                    <th>Nama Bank</th>
                    <th>Atas Nama</th>
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
            <form id="productForm" name="productForm" method="POST">
                <input type="hidden" name="id_bank" id="id_bank">
                <div class="form-group">
                    <label for="no_rek" class="form-control-label">No Rek</label>
                    <input type="text" class="form-control" id="no_rek" name="no_rek">
                </div>
                <div class="form-group">
                    <label for="nama_bank" class="form-control-label">Nama Bank</label>
                    <input type="text" class="form-control" id="nama_bank" name="nama_bank">
                </div>
                <div class="form-group">
                    <label for="atas_nama" class="form-control-label">Atas Nama</label>
                    <input type="text" class="form-control" id="atas_nama" name="atas_nama">
                </div>
        </div>
        <input type="hidden" name="action" id="action">
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <h5 class="modal-title" id="modelHeading">Hapus Bank</h5>
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
    $('.akun-tree').addClass('menu-open');
    $('#akun').addClass('active');
    $('#donatur').addClass('active');
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
            $('#ajaxModel').modal('show');
        });

        $('#productForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Tambah') {

                $.ajax({
                    url: "{{ route('bank.store') }}",
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
                    url: "{{ url('penggalang-dana/bank/update') }}",
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
            $.get("{{ url('penggalang-dana/bank') }}" + '/' + product_id + '/edit', function(data) {
                $('#saveBtn').html("Simpan");
                $('#action').val("Edit");
                $('#ajaxModel').modal('show');
                console.log(data);
                $('#id_bank').val(data.id);
                $('#no_rek').val(data.no_rekening);
                $('#nama_bank').val(data.nama_bank);
                $('#atas_nama').val(data.atas_nama);
            })
        });

        var product_id;
        $(document).on('click', '.delete', function() {
            product_id = $(this).data("id");
            $.get("{{ url('penggalang-dana/getbank') }}" + '/' + product_id, function(data) {
                $('#yakinHapus').text('Yakin Menghapus Atas Nama ' + data.atas_nama + ' ?')
            })
            $('#ajaxHapus').modal('show');
        });

        $('#hapus_button').click(function() {
            $.ajax({
                url: "/penggalang-dana/bank/destroy" + "/" + product_id,
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
            ajax: "{{ route('bank.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_rekening',
                    name: 'no_rekening'
                },
                {
                    data: 'nama_bank',
                    name: 'nama_bank'
                },
                {
                    data: 'atas_nama',
                    name: 'atas_nama'
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
