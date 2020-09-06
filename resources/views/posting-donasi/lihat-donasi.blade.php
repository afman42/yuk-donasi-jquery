@extends('layouts.backend')

@section('title')
YKI | Lihat Posting Donasi
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Lihat Posting Donasi</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Penggalang Dana</a></li>
<li class="breadcrumb-item active">Lihat Posting Donasi</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Lihat Posting Donasi - {{ $posting->judul }}</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('status'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username Donatur</th>
                    <th>Gambar</th>
                    <th>Donasi Masuk</th>
                    <th>Nama Bank</th>
                    <th>Aksi</th>
                </tr>
            </thead>
                @forelse ($masukan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->username }}</td>
                    <td><a href="{{ url($item->photo_struk) }}" data-lightbox="image-{{ $item->id }}"><img src="{{ url($item->photo_struk) }}" width="100" height="100"></a></td>
                        <td>{{ $item->donasi_masuk }}</td>
                        <td>{{ $item->nama_bank }}</td>
                        <td>
                            @if($item->status_konfirmasi == 'proses')
                                <a href="{{ route('posting.bataldonasi', ['id' => $item ]) }}" class="btn btn-sm btn-primary">Batal</a> &nbsp; <a href="{{ route('posting.terimadonasi', ['id' => $item ]) }}" class="btn btn-sm btn-success">Terima</a>
                            @else
                                Tidak Ada Aksi - {{ $item->status_konfirmasi }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>Gambar Kosong</td>
                    </tr>
                @endforelse
        </table>
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
<script src="{{ asset('js/lightbox.js') }}"></script>
<script>
    $(function() {
        var table = $('#table').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });
</script>
@endsection

@section('script-css')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">
@endsection
