@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pengiriman</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        @role('perusahaan')
                        <table id="pengiriman-table">
                        </table>
                        @push('scripts')
                        <script>
                        $(function() {
                            var table = $('#pengiriman-table').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: '{{ route('pengiriman.loadPerusahaan') }}',
                                columns: [
                                    { data: 'propinsi', name: 'propinsi', title:'Tujuan' },
                                    { data: 'kabupaten', name: 'kabupaten'},
                                    { data: 'gudang_name', name: 'gudang_name', title:'Pemilik'  },
                                    { data: 'item', name: 'item', title:'Barang' },
                                    { data: 'amount', name: 'amount', title:'Jumlah' },
                                    { data: 'status', name: 'status', title:'Status' },
                                    { data: 'action', name: 'action', title:'Action'}
                                ]
                            });

                            $('#pengiriman-table tbody').on( 'click', '#kirim-qrcode', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.qrCode', 'id') }}"
                                url = url.replace('id', data['id']);
                                window.location.href = url;
                            });

                            $('#pengiriman-table tbody').on( 'click', '#kirim', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.scanner', 'id') }}"
                                url = url.replace('id', data['id']);
                                window.location.href = url;
                            });
                        });
                        </script>
                        @endpush
                        @endrole
                        @role('pemilik_gudang')
                        <table id="pengiriman-table">
                        </table>
                        @push('scripts')
                        <script>
                        $(function() {
                            var table = $('#pengiriman-table').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: '{{ route('pengiriman.loadGudang') }}',
                                columns: [
                                    { data: 'propinsi', name: 'propinsi', title:'Dari' },
                                    { data: 'kabupaten', name: 'kabupaten'},
                                    { data: 'perusahaan_name', name: 'perusahaan_name', title:'Perusahaan'  },
                                    { data: 'item', name: 'item', title:'Barang' },
                                    { data: 'amount', name: 'amount', title:'Jumlah' },
                                    { data: 'status', name: 'status', title:'Status' },
                                    { data: 'action', name: 'action', title:'Action'}
                                ]
                            });

                            $('#pengiriman-table tbody').on( 'click', '#terima', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.accept', 'id') }}"
                                url = url.replace('id', data['id']);
                                var sendData = {};
                                sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                                sendData['_method'] = "PUT";
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: sendData,
                                   success: function(data)
                                   {
                                       alert("Pengiriman disetujui. Barang akan dikirim oleh perusahaan.");
                                       window.location.href = "{{ route ('pengiriman.index') }}";
                                    },
                                   error: function(xhr, status, error) 
                                   {
                                        alert(xhr.responseText);
                                    } 
                                 });
                            });

                            $('#pengiriman-table tbody').on( 'click', '#tolak', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.reject', 'id') }}"
                                url = url.replace('id', data['id']);
                                var sendData = {};
                                sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                                sendData['_method'] = "PUT";
                                $.ajax({
                                   type: "POST",
                                   url: url,
                                   data: sendData,
                                   success: function(data)
                                   {
                                       alert("Pengiriman ditolak. Barang tidak akan dikirim oleh perusahaan.");
                                       window.location.href = "{{ route ('pengiriman.index') }}";
                                    },
                                   error: function(xhr, status, error) 
                                   {
                                        alert(xhr.responseText);
                                    } 
                                 });
                            });

                            $('#pengiriman-table tbody').on( 'click', '#terima-barang', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.scanner', 'id') }}"
                                url = url.replace('id', data['id']);
                                window.location.href = url;
                            });

                            $('#pengiriman-table tbody').on( 'click', '#ambil-qrcode', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.qrCode', 'id') }}"
                                url = url.replace('id', data['id']);
                                window.location.href = url;
                            });

                            $('#pengiriman-table tbody').on( 'click', '#kirim', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.scanner', 'id') }}"
                                url = url.replace('id', data['id']);
                                window.location.href = url;
                            });

                            $('#pengiriman-table tbody').on( 'click', '#sampai', function () {
                                var data = table.row( $(this).parents('tr') ).data();
                                var url = "{{ route ('pengiriman.scanner', 'id') }}"
                                url = url.replace('id', data['id']);
                                window.location.href = url;
                            });
                        });
                        </script>
                        @endpush
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
