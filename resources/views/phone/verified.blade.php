@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Selamat</div>
                <div class="panel-body">
                    <center>Nomor telepon anda telah terverifikasi.</center>
                    <br>
                    <center>Anda akan dialihkan ke halaman utama dalam waktu 5 detik.</center>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Total seconds to wait
        var seconds = 5;
        
        function countdown() {
            seconds = seconds - 1;
            if (seconds < 0) {
                // Chnage your redirection link here
                // alert('josss');
                window.location.href = "{{ route('home') }}";
            } else {
                // Update remaining seconds
                // document.getElementById("countdown").innerHTML = seconds;
                // Count down using javascript
                window.setTimeout("countdown()", 1000);
            }
        }
        
        // Run countdown function
        countdown();
    </script>
    @endpush
</div>
@endsection
