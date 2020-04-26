@extends('layouts.backend')

@section('title')
YKI | Pengaturan Akun
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Pengaturan Akun</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Penggalang Dana</a></li>
<li class="breadcrumb-item active">Pengaturan Akun</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Pengaturan Akun</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Masukan Password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password-ulang" class="form-control" placeholder="Masukan Password Ulang">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="Ganti Password" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-datatable')
<script>  
    $('#pengaturan').addClass('active');
</script>
@endsection

@section('script-css')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
