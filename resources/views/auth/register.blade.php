@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if (Session::get('akun') == 1)
                <div class="panel-heading">Daftar Sebagai Perusahaan</div>
                @else
                <div class="panel-heading">Daftar Sebagai Pemilik Gudang</div>
                @endif

                <div class="panel-body">
                    @if (Session::get('akun') == 1)
                    <form id="register" class="form-horizontal" method="POST" action="{{ route('register.perusahaan') }}">
                    @else
                    <form id="register" class="form-horizontal" method="POST" action="{{ route('register.pemilikgudang') }}">
                    @endif

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nama</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Alamat E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Konfirmasi Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                            <label for="alamat" class="col-md-4 control-label">Alamat</label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control" name="alamat" required>

                                @if ($errors->has('alamat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('propinsi_id') ? ' has-error' : '' }}">
                            <label for="propinsi_id" class="col-md-4 control-label">Propinsi</label>

                            <div class="col-md-6">
                                <select id="propinsi_id" class="form-control" name="propinsi_id" form="register" onchange="setKabupaten(this);" required>
                                    <option>--Select--</option>
                                    @foreach ($propinsis as $propinsi)
                                    <option value="{{ $propinsi->id }}">{{ $propinsi->name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('propinsi_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('propinsi_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('kabupaten_id') ? ' has-error' : '' }}">
                            <label for="kabupaten_id" class="col-md-4 control-label">Kabupaten</label>

                            <div class="col-md-6">
                                <select id="kabupaten_id" class="form-control" name="kabupaten_id" required>
                                </select>

                                @if ($errors->has('kabupaten_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kabupaten_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @push('scripts')
                        <script>
                            function setKabupaten(selected)
                            {
                                //alert(selected.value);
                                var url = "{{ route ('register.getKabupaten', 'id') }}";
                                url = url.replace('id', selected.value);
                                $.ajax({
                                    type: 'GET',
                                    url: url,
                                    success: function (data) {
                                        //console.log('Success:', data);
                                        $("#kabupaten_id").empty();
                                        $("#kabupaten_id").append("<option>--Select--</option>");
                                        $(data).each(function(i) {
                                            $("#kabupaten_id").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                                        });
                                    },
                                    error: function (data) {
                                        console.log('Error:', data);
                                    }
                                });
                            }
                        </script>
                        @endpush

                        <div class="form-group{{ $errors->has('nomor_telepon') ? ' has-error' : '' }}">
                            <label for="nomor_telepon" class="col-md-4 control-label">Nomor Telepon</label>

                            <div class="col-md-2">
                                <input id="nomor_telepon_pre" type="text" class="form-control" name="nomor_telepon_pre" value="+62" disabled >
                            </div>
                            <div class="col-md-4">
                                <input id="nomor_telepon" type="text" class="form-control" name="nomor_telepon" pattern="[0-9]{7,11}|" placeholder="8XXXXXXXXXX" required>

                                @if ($errors->has('nomor_telepon'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nomor_telepon') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Daftar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
