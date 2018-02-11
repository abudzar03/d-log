@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Rating Gudang</div>
                <div class="panel-body">
                    <h1 style="text-align: center;">@for ($i = 0; $i < ($gudang->rating/10); $i++) &#9733; @endfor</h1>
                </div>
            </div>
        </div>
    </div>

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
                            ajax: '{{ route('gudang.load') }}',
                            columns: [
                                { data: 'name', name: 'name', title:'Nama'  },
                                { data: 'price', name: 'price', title:'Harga Satuan' },
                                { data: 'amount', name: 'amount', title:'Jumlah' },
                                { name: 'total_price', title:'Harga Total'}
                            ],
                            "columnDefs": [{
                                "targets": -1,
                                "orderable": false,
                                "render": function ( data, type, row ) {
                                    return (row['price'] * row['amount']);
                                }
                            }]
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
