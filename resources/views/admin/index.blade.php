@extends('layouts.backend')

@section('title')
YKI | Beranda
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Beranda</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Admin</a></li>
<li class="breadcrumb-item active">Beranda</li>   
@endsection

@section('content')

@endsection

@section('script-datatable')
<script>  
    // $('.akun-tree').addClass('menu-open');
    $('#beranda').addClass('active');
    // $('#donatur').addClass('active');
</script>
@endsection