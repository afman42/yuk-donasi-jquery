@extends('layouts.backend')

@section('title')
YKI | Biodata
@endsection


@section('breadcumb-kiri')
<h1 class="m-0 text-dark">Biodata</h1>
@endsection

@section('breadcumb-kanan')
<li class="breadcrumb-item"><a href="#">Penggalang Dana</a></li>
<li class="breadcrumb-item active">Biodata</li>   
@endsection

@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Biodata</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
      </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('penggalang-dana.biodata-post') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <select name="jenis_kelamin" id="jk" class="form-control @error('jenis_kelamin') is-invalid @enderror"">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="1" @if ($biodata !== null && $biodata->jenis_kelamin == 1) {{ 'selected' }} @endif>Laki - Laki</option>
                            <option value="0" @if ($biodata !== null && $biodata->jenis_kelamin == 2) {{ 'selected' }} @endif>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" name="no_hp" id="no_hp" <?php if($biodata !== null) { echo "value='"; echo $biodata->no_hp."'";} ?> class="form-control @error('no_hp') is-invalid @enderror" placeholder="Masukan No Hp">
                        @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"><?php if($biodata !== null) { echo $biodata->alamat;} ?></textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror">
                        @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Ganti Profil" class="btn btn-primary">
                    </div>
                </form>
            </div>
            
            <div class="col-md-6">
                @if (session('model'))
                <table class="table">
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>{{ session('model')->jenis_kelamin == 1 ? 'Laki-Laki' : 'Perempuan' }} </td>
                    </tr>
                    <tr>
                        <td>No Handphone</td>
                        <td>:</td>
                        <td>{{ session('model')->no_hp  }} </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ session('model')->alamat }} </td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td>:</td>
                        <td>
                            <img src="{{ url(session('model')->gambar) }}" alt="gambar" class="img-thumbnail">
                        </td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('script-datatable')
<script>  
    $('#profil').addClass('active');
</script>
@endsection

@section('script-css')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
