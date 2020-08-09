@extends('layouts.backend')

@section('title')
YKI | Posting Donasi   
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Posting Donasi</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Penggalang Dana</a></li>
<li class="breadcrumb-item active">Posting Donasi</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Posting Donasi</h3>

      <div class="card-tools">
        @if ($data->bank_count > 0 && $data->biodata_donatur_count > 0)
            <button type="button" class="btn btn-default" data-toggle="modal" id="createNewProduct">
                Tambah
            </button>
        @else
            Harap isi biodata dan bank terlebih dahulu
        @endif
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
                    <th>Bank</th>
                    <th>TMS</th>
                    <th>TAS</th>
                    <th>Jumlah Donasi</th>
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
          <h4 class="modal-title" id="modelHeading">Tambah Posting Donasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="productForm" name="productForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_posting_donasi" id="id_posting_donasi">
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
                    <label for="jumlah_donasi" class="form-control-label">Jumlah Donasi</label>
                    <input type="number" class="form-control" id="jumlah_donasi" name="jumlah_donasi">
                </div>
                <div class="form-group">
                    <label for="publish" class="form-control-label">Bank</label>
                    <select name="bank_id" id="bank_id" class="form-control">
                    </select>
                </div>
                <div class="form-group">
                    <label for="gambar" class="form-control-label">Tanggal Mulai Selesai</label>
                    <input type="date" class="form-control" id="tanggal_mulai_selesai" name="tanggal_mulai_selesai">
                </div>
                <div class="form-group">
                    <label for="gambar" class="form-control-label">Tanggal Akhir Selesai</label>
                    <input type="date" class="form-control" id="tanggal_akhir_selesai" name="tanggal_akhir_selesai">
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
                <h5 class="modal-title" id="modelHeading">Hapus Posting Donasi</h5>
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

        $('#createNewProduct').click(function() {
            $('#productForm')[0].reset();
            $('#saveBtn').html('Tambah');
            $('#action').val('Tambah');
            $('#bank_id').load("{{ route('posting.postingid') }}")
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.pdf-download', function() {
            console.log('oke')
            var product_id = $(this).data('id');
            $.get("{{ url('/penggalang-dana/pdf-posting') }}" + "/" + product_id, function(data, status){
                toastr.success('Berhasil Terdownload');
            });
        });   
        $('#productForm').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Tambah') {

                $.ajax({
                    url: "{{ route('posting-donasi.store') }}",
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
                    url: "{{ url('penggalang-dana/posting-donasi/update') }}",
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
            $.get("{{ url('penggalang-dana/posting-donasi') }}" + '/' + product_id + '/edit', function(data) {
                $('#bank_id').load("{{ route('posting.postingid') }}", function(datas) {
                    $('select[name="bank_id"]').find('option[value="' + data.bank_id + '"]').attr("selected", true);
                })
                $('#saveBtn').html("Simpan");
                $('#action').val("Edit");
                $('#modelHeading').text('Update Posting Donasi')
                $('#ajaxModel').modal('show');
                console.log(data);
                $('#id_posting_donasi').val(data.id);
                $('#judul').val(data.judul);
                $('#deskripsi').val(data.deskripsi);
                $('#tanggal_mulai_selesai').val(data.tanggal_mulai_selesai);
                $('#tanggal_akhir_selesai').val(data.tanggal_akhir_selesai);
                $('#jumlah_donasi').val(data.jumlah_donasi);
            })
        });

        var product_id;
        $(document).on('click', '.delete', function() {
            product_id = $(this).data("id");
            $.get("{{ url('penggalang-dana/getposting') }}" + '/' + product_id, function(data) {
                $('#yakinHapus').text('Yakin Menghapus Posting Judul ' + data.judul + ' ?')
            })
            $('#ajaxHapus').modal('show');
        });

        $('#hapus_button').click(function() {
            $.ajax({
                url: "/penggalang-dana/posting-donasi/destroy" + "/" + product_id,
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
                url : "{{ route('posting-donasi.index') }}",
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
                    data: 'bank_id',
                    name: 'bank_id'
                },
                {
                    data: 'tanggal_mulai_selesai',
                    name: 'tanggal_mulai_selesai'
                },
                {
                    data: 'tanggal_akhir_selesai',
                    name: 'tanggal_akhir_selesai'
                },
                {
                    data: 'jumlah_donasi',
                    name: 'jumlah_donasi'
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
