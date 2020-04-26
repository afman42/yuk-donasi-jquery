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
        <a href="#" class="btn btn-primary">Tambah</a>
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body">

    </div>
</div>
@endsection

@section('script-datatable')
<script> 
    $('#mel-posting').addClass('active');
</script>
@endsection