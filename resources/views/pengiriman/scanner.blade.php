@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">QR Code Pengiriman ke Gudang</div>
                <div class="panel-body">
                    <center><video width="320" height="240" id="preview"></video></center>
                    @if ($pengiriman->status == 1)
                    @push('scripts')
                    <script type="text/javascript">
                      $(function() {
                      let scanner = new Instascan.Scanner({ backgroundScan: false, video: document.getElementById('preview') });
                      scanner.addListener('scan', function (content) {
                        // console.log(content);
                        var url = "{{ route ('pengiriman.send', 'id') }}"
                        url = url.replace('id', content);
                        var sendData = {};
                        sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                        sendData['_method'] = "PUT";
                        $.ajax({
                           type: "POST",
                           url: url,
                           data: sendData,
                           success: function(data)
                           {
                               alert("Barang telah dikirim.");
                               window.location.href = "{{ route ('pengiriman.index') }}";
                            },
                           error: function(xhr, status, error) 
                           {
                                alert(xhr.responseText);
                            } 
                         });
                      });
                      Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                          scanner.start(cameras[0]);
                        } else {
                          console.error('No cameras found.');
                        }
                      }).catch(function (e) {
                        console.error(e);
                      });
                      });
                    </script>
                    @endpush
                    @elseif ($pengiriman->status == 2)
                    @push('scripts')
                    <script type="text/javascript">
                      $(function() {
                      let scanner = new Instascan.Scanner({ backgroundScan: false, video: document.getElementById('preview') });
                      scanner.addListener('scan', function (content) {
                        // console.log(content);
                        var url = "{{ route ('pengiriman.receive', 'id') }}"
                        url = url.replace('id', content);
                        var sendData = {};
                        sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                        sendData['_method'] = "PUT";
                        $.ajax({
                           type: "POST",
                           url: url,
                           data: sendData,
                           success: function(data)
                           {
                               alert("Barang telah diterima.");
                               window.location.href = "{{ route ('gudang.index') }}";
                            },
                           error: function(xhr, status, error) 
                           {
                                alert(xhr.responseText);
                            } 
                         });
                      });
                      Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                          scanner.start(cameras[0]);
                        } else {
                          console.error('No cameras found.');
                        }
                      }).catch(function (e) {
                        console.error(e);
                      });
                      });
                    </script>
                    @endpush
                    @elseif ($pengiriman->status == 4)
                    @push('scripts')
                    <script type="text/javascript">
                      $(function() {
                      let scanner = new Instascan.Scanner({ backgroundScan: false, video: document.getElementById('preview') });
                      scanner.addListener('scan', function (content) {
                        // console.log(content);
                        var url = "{{ route ('pengiriman.send', 'id') }}"
                        url = url.replace('id', content);
                        var sendData = {};
                        sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                        sendData['_method'] = "PUT";
                        $.ajax({
                           type: "POST",
                           url: url,
                           data: sendData,
                           success: function(data)
                           {
                               alert("Barang telah dikirim.");
                               window.location.href = "{{ route ('pengiriman.index') }}";
                            },
                           error: function(xhr, status, error) 
                           {
                                alert(xhr.responseText);
                            } 
                         });
                      });
                      Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                          scanner.start(cameras[0]);
                        } else {
                          console.error('No cameras found.');
                        }
                      }).catch(function (e) {
                        console.error(e);
                      });
                      });
                    </script>
                    @endpush
                    @elseif ($pengiriman->status == 5)
                    @push('scripts')
                    <script type="text/javascript">
                      $(function() {
                      let scanner = new Instascan.Scanner({ backgroundScan: false, video: document.getElementById('preview') });
                      scanner.addListener('scan', function (content) {
                        // console.log(content);
                        var url = "{{ route ('pengiriman.arrive', 'id') }}"
                        url = url.replace('id', content);
                        var sendData = {};
                        sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                        sendData['_method'] = "PUT";
                        $.ajax({
                           type: "POST",
                           url: url,
                           data: sendData,
                           success: function(data)
                           {
                               alert("Barang telah sampai ke pelanggan.");
                               window.location.href = "{{ route ('gudang.index') }}";
                            },
                           error: function(xhr, status, error) 
                           {
                                alert(xhr.responseText);
                            } 
                         });
                      });
                      Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                          scanner.start(cameras[0]);
                        } else {
                          console.error('No cameras found.');
                        }
                      }).catch(function (e) {
                        console.error(e);
                      });
                      });
                    </script>
                    @endpush
                    @endif
                </div>
                <div class="panel-footer">
                    Lakukan scanning QR Code untuk verifikasi pengiriman dan penerimaan barang.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
