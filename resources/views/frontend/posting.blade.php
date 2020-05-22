
@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8">
                <h5>{{ $posting->judul }}</h5>
                <img src="{{ url($posting->gambar) }}" alt="" class="w-100" height="300">
                <p>{{ $posting->deskripsi }}</p>
                <div class="mt-2">
                    <div id="disqus_thread"></div>
                </div>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>                
@endsection    

