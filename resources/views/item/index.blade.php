@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Daftar Barang</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="items-table">
                        </table>
                    </div>
                    @push('scripts')
                    <script>
                    $(function() {
                        var table = $('#items-table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: '{{ route('item.load') }}',
                            columns: [
                                { data: 'name', name: 'name', title:'Nama'  },
                                { data: 'price', name: 'price', title:'Harga Satuan' },
                                { data: 'amount', name: 'amount', title:'Jumlah' },
                                { name: 'total_price', title:'Harga Total'},
                                { name: 'action', title:'Action'}
                            ],
                            "columnDefs": [{
                                "targets": -2,
                                "orderable": false,
                                "render": function ( data, type, row ) {
                                    return (row['price'] * row['amount']);
                                }
                            }, {
                                "targets": -1,
                                "width": "40%",
                                "orderable": false,
                                "defaultContent": "<button id='tambah'>Tambah</button><button id='ubah-harga'>Ubah Harga</button><button id='distribusi'>Distribusi</button><button id='ambil'>Ambil</button>"
                            }]
                        });

                        $('#items-table tbody').on( 'click', '#tambah', function () {
                            var data = table.row( $(this).parents('tr') ).data();
                            var url = "{{ route ('item.add', 'id') }}"
                            url = url.replace('id', data['id']);
                            window.location.href = url;
                        });

                        $('#items-table tbody').on( 'click', '#ubah-harga', function () {
                            var data = table.row( $(this).parents('tr') ).data();
                            var url = "{{ route ('item.changeprice', 'id') }}"
                            url = url.replace('id', data['id']);
                            window.location.href = url;
                        });

                        $('#items-table tbody').on( 'click', '#distribusi', function () {
                            var data = table.row( $(this).parents('tr') ).data();
                            var url = "{{ route ('item.distributeForm', 'id') }}"
                            url = url.replace('id', data['id']);
                            window.location.href = url;
                        });

                        $('#items-table tbody').on( 'click', '#ambil', function () {
                            var data = table.row( $(this).parents('tr') ).data();
                            var url = "{{ route ('item.takeForm', 'id') }}"
                            url = url.replace('id', data['id']);
                            window.location.href = url;
                        });
                    });
                    </script>
                    @endpush
                </div>
                <div class="panel-footer">
                    <button onclick="window.location.href='{{ route('item.new') }}'">Tambah Barang</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
