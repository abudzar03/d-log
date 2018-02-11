@extends('layouts.app')

@section('content')
<div class="container">

    @if (Auth::user()->nomor_telepon_verified == 0)
    <div class="alert alert-warning">
      <strong>Perhatian!</strong> Harap untuk melakukan verifikasi nomor telepon <a href="{{ route('phone.agreement') }}">disini</a>.
    </div>
    @endif

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Selamat Datang {{ Auth::user()->name }} !
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
