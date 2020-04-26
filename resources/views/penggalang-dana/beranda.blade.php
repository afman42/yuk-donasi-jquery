@extends('layouts.backend')

@section('title')
YKI | Beranda    
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Halaman Beranda</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Penggalang Dana</a></li>
<li class="breadcrumb-item active">Beranda</li>   
@endsection

@section('content')
<h1>Beranda</h1>
@endsection

@section('script-datatable')
<script>  
    $('#beranda').addClass('active');
</script>
@endsection