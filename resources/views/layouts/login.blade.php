<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Yuk Donasi | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#">Yuk Donasi</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silakan Masuk</p>
      <form id="contoh-form" method="post">
        {{-- {{ csrf_field() }} --}}
        <div class="form-group">
          <input type="text" class="form-control" name="username" placeholder="Masukan Username">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Masukan Password">
        </div>
        <input type="hidden" name="action" id="action" value="Tambah">
        <div class="form-group">
          <button type="submit" class="btn btn-primary" id="submit-form">Masuk</button>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script>
   $(function(){
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
         //ketika submit button d click
         $('#contoh-form').on('submit', function(event) {
            event.preventDefault();
            if ($('#action').val() == 'Tambah') {

                $.ajax({
                    url: "{{ route('admin.login') }}",
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
                        if (data.error) {
                            toast = toastr.error(data.error);
                        }
                        if (data.success) {
                            $('#contoh-form')[0].reset();
                            toast = toastr.success(data.success);
                            location.href="{{ route('admin.index') }}"
                        }
                        toast;
                    }
                })
            } //1
            
        })
       
       });
</script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

</body>
</html>
