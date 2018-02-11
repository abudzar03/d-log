@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Verifikasi Nomor Telepon</div>
                <div class="panel-body">
                    Anda akan melakukan verifikasi nomor telepon. Pastikan nomor telepon di bawah ini benar.
                    <br>
                    <center><h1>{{ Auth::user()->nomor_telepon }}</h1></center>
                    <br>
                    <center><button class="btn btn-primary" id="nomor-benar" name="nomor-benar">Benar</button></center>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="kode-verifikasi" name="kode-verifikasi">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><center>Masukkan Kode Verifikasi DALAM WAKTU 60 DETIK</center></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('phone.verify') }}">
                        {{ csrf_field() }}
                        <input id="token" name="token" type="hidden" value="">
                        <div class="form-group">
                            <label for="kode" class="col-md-4 control-label">Kode Verifikasi</label>
                            <div class="col-md-5">
                                <input id="kode" type="text" class="form-control" name="kode" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-md-6">
                                <button type="submit" class="btn btn-primary">Verifikasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     @push('scripts')
    <script>
        $(function() {
            var token = "";
            $("#kode-verifikasi").hide();
            $( "#nomor-benar" ).click(function() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route ('phone.smsotp') }}',
                    success: function (data) {
                        console.log('Success:', data);
                        $("#kode-verifikasi").show();
                        $("#token").attr('value', data);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            })
        });
    </script>
    @endpush
</div>
@endsection
