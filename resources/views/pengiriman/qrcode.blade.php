@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                @if ($pengiriman->status < 4)
                <div class="panel-heading">QR Code Pengiriman ke Gudang</div>
                @else
                <div class="panel-heading">QR Code Pengiriman ke Pelanggan</div>
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <center><img src="data:image/png;base64,{{ $barcode }}" alt="barcode"></center>
                        </div>
                    </div>
                    <div class="row" style="padding-top: 10px">
                        <div class="col-md-12">
                            <center><button class="btn btn-primary" id="kirim">Kirim</button></center>
                            @push('scripts')
                            <script>
                            $(function() {
                                $('.panel-body').on( 'click', '#kirim', function () {
                                    var url = "{{ route ('pengiriman.scanner', 'id') }}"
                                    url = url.replace('id', {{ $pengiriman->id }});
                                    window.location.href = url;
                                });
                            });
                            </script>
                            @endpush
                        </div>
                    </div>
                </div>
                @if ($pengiriman->status < 4)
                <div class="panel-footer">
                    Gunakan QR Code di atas untuk verifikasi pengiriman dan penerimaan barang untuk di simpan di gudang.
                </div>
                @else
                <div class="panel-footer">
                    Gunakan QR Code di atas untuk verifikasi pengiriman dan penerimaan barang ke pelanggan.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
