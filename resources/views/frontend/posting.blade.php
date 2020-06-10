
@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-8">
                <h5>{{ $posting->judul }}</h5>
                <img src="{{ url($posting->gambar) }}" alt="" class="w-100" height="300">
                @if ($posting->user_id == $user->user_id)
                <ul class="list-unstyled mt-2">
                    <li class="media">
                      <img src="{{ url($user->gambar) }}" class="mr-3" alt="..." width="64" height="64">
                      <div class="media-body">
                        <h5 class="mt-0 mb-1">{{ $user->user->name }}</h5>
                        {{ $user->no_hp }} - {{ $user->alamat }} <br>
                        Bank : {{ $posting->bank->nama_bank }}, Atas Nama: {{ $posting->bank->atas_nama }}, No Rekening: {{ $posting->bank->no_rekening }}
                      </div>
                    </li>
                  </ul>
                @endif
                <p>{{ $posting->deskripsi }}</p>
                <div class="mt-2">
                    @comments(['model' => $posting,'perPage' => 2])
                </div>
            </div>
            @php
                $count = 0;
            @endphp
            <div class="col-md-4 mt-4" style="padding-bottom: 150px;">
                Jumlah Donasi Yang Diperlukan: <span id="jumlah">
                @foreach ($posting->masukan_donasi as $item)
                    @php
                        $count += $item->donasi_masuk;
                    @endphp
                @endforeach
                {{ $count }}
                </span>  / {{ $posting->jumlah_donasi }}
                @if (auth()->check())
                    @if (auth()->user()->hak_akses == 3)
                        <button type="button" class="btn btn-outline-primary" id="createNewProduct">Donasi</button>
                    @endif
                @else
                    Silakan Login Terlebih dahulu untuk donasi
                @endif
            </div>
        </div>
    </div>

    <div id="feedback-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Masukan Donasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form class="masukan_donasi" name="masukan_donasi" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="posting_id" value="{{ $posting->id }}">
                        <div class="form-group">
                            <label for="photo">Photo Struk</label>
                            <input type="file" name="photo_struk" id="photo_struk" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="donasi_masuk">Donasi Masuk</label>
                            <input type="number" name="donasi_masuk" class="form-control">
                        </div>
                        <input type="hidden" name="action" id="action">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="submit">Kirim</button>
                    <a href="#" class="btn" data-dismiss="modal">Tutup</a>
                </form>
                </div>
            </div>
        </div>
    </div>            
@endsection

@section('script-js')
    <script>
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
        $(document).ready(function(){
            
            $('#createNewProduct').click(function() {
                $('.masukan_donasi')[0].reset();
                $('#action').val('Tambah');
                $('#feedback-modal').modal('show');
            });

            $('.masukan_donasi').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Tambah') {

                $.ajax({
                    url: "{{ url('/donasi-masuk') }}",
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
                            $('.masukan_donasi')[0].reset();
                            toast = toastr.success(data.success);
                            location.reload();
                            $('#feedback-modal').modal('hide');
                        }
                        toast;
                    }
                })
            } //1
           
            })
        })
    </script>
@endsection

