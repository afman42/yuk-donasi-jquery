
@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <h5>{{ $berita->judul }}</h5>
                <img src="{{ url($berita->gambar) }}" alt="" class="w-100" height="300">
                <p>{{ $berita->deskripsi }}</p>
            </div>
        </div>
    </div>
@endsection    

