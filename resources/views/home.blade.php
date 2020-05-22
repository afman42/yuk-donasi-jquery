@php
    use Illuminate\Support\Str;
@endphp
@extends('layouts.frontend')
    @section('content')
    <div class="container">
      <div class="row">
        <div class="col-md-12 mt-4">
          <ul class="list-unstyled">
            @foreach ($berita as $item)                
            <li class="media mt-2">
              <img src="{{ url($item->gambar) }}" class="mr-3" alt="..." width="64" height="64">
              <div class="media-body">
                <h5 class="mt-0 mb-1"><a href="{{ url('berita/'.$item->id) }}">{{ Str::limit($item->judul,10,'...') }}</a></h5>
                {{ Str::limit($item->deskripsi,20,'...') }}
              </div>
            </li>
            @endforeach
          </ul>
          {{ $berita->links() }}
        </div>
      </div>
    </div>
    <div class="container">
        <div class="row mt-2">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="" class="form-inline">
                    <input type="search" name="q" id="" class="form-control" placeholder="Masukan Pencarian Donatur">
                    <button type="submit" class="btn btn-primary ml-1">Cari</button>
                </form>
            </div>
            <div class="col-md-4"></div>
            <div class="mt-5"></div>
            @forelse ($posting as $item)
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ url($item->gambar) }}" class="card-img-top" height="200" alt="...">
                    <div class="card-body">
                      <h5 class="card-title" style="font-size: 16px">{{ Str::limit($item->judul,10,'...') }}</h5>
                      <p class="card-text">{{ Str::limit($item->deskripsi, 20, '...') }}</p>
                      <a href="{{ url('posting-donasi/'.$item->id) }}" class="btn btn-primary">Donasi</a>
                    </div>
                  </div>
            </div>
            @empty
                <p>Maaf Kosong</p>
            @endforelse
            <div class="col-md-12 mt-3" style="padding-bottom: 50px;">
              {{ $posting->appends(['q' => request()->only('q')])->render() }}
            </div>
        </div>
    </div>
    @endsection    

