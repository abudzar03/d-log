@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if ($status == 0)
                <div class="panel-heading">Tambah Barang Baru</div>
                @elseif ($status == 1)
                <div class="panel-heading">Tambah Stok Barang</div>
                @elseif ($status == 2)
                <div class="panel-heading">Ubah Harga Barang</div>
                @elseif ($status == 3)
                <div class="panel-heading">Distribusi Barang</div>
                @else
                <div class="panel-heading">Ambil Barang</div>
                @endif
                <div class="panel-body">
                    @if ($status == 0)
                    <form class="form-horizontal" method="POST" action="{{ route('item.save') }}">
                    @elseif($status == 1)
                    <form class="form-horizontal" method="POST" action="{{ route('item.add', $id) }}">
                        <input name="_method" type="hidden" value="PUT">
                    @elseif($status == 2)
                    <form class="form-horizontal" method="POST" action="{{ route('item.changeprice', $id) }}">
                        <input name="_method" type="hidden" value="PUT">
                    @else
                    <form class="form-horizontal" method="POST" action="#" id="gudang-find" name="gudang-find">
                    @endif
                        {{ csrf_field() }}
                        @if ($status == 0)
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nama Barang</label>
                            <div class="col-md-5">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if ($status == 0 || $status == 2)
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Harga Satuan</label>
                            <div class="col-md-5">
                                <input id="price" type="number" class="form-control" name="price" required autofocus>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if ($status == 0 || $status == 1 || $status == 3 || $status == 4)
                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                            <label for="amount" class="col-md-4 control-label">Jumlah</label>
                            <div class="col-md-2">
                                <input id="amount" type="number" class="form-control" name="amount" required autofocus>
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if ($status == 3 || $status == 4)
                        <div class="form-group{{ $errors->has('propinsi_id') ? ' has-error' : '' }}">
                            <label for="propinsi_id" class="col-md-4 control-label">Propinsi</label>

                            <div class="col-md-6">
                                <select id="propinsi_id" class="form-control" name="propinsi_id" form="gudang-find" onchange="setKabupaten(this);" required>
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
                                var url = "{{ route ('item.getKabupaten', 'id') }}";
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
                        @endif
                        @if ($status == 3 || $status == 4)
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-md-6">
                                <button type="submit" class="btn btn-primary">Cari Gudang</button>
                            </div>
                        </div>
                        @else
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-md-6">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($status ==  3 || $status ==  4)
    <div class="row" id="gudang-result" name="gudang-result">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body"></div>
            </div>
        </div>
    </div>
    @if($status ==  3)
    @push('scripts')
    <script>
        $(function() {
            var selectedGudang;
            $("#gudang-result").hide();

            $("#gudang-find").submit(function(e) {
                $("#gudang-result").find(".panel-heading").empty();
                $("#gudang-result").find(".panel-body").empty();
                var url = "{{ route ('gudang.distributeFind') }}";
                $.ajax({
                       type: "GET",
                       url: url,
                       data: $("#gudang-find").serialize(), // serializes the form's elements.
                       success: function(data)
                       {
                            //console.log(data);
                            if (typeof data['name'] !== 'undefined') {
                                selectedGudang = data;
                                $("#gudang-result").show();
                                appendString='';
                                for(var i = 0; i< (data['rating']/10); i++){
                                    appendString += "&#9733;";
                                }
                                $("#gudang-result").find(".panel-heading").append("Gudang Ditemukan");
                                $("#gudang-result").find(".panel-body").append("<div class='row'><label class='col-md-4 cont'>Pemilik</label><div class='col-md-5'>" + data['name'] + "</div></div><div class='row'><label class='col-md-4 cont'>Alamat</label><div class='col-md-5'>" + data['alamat'] + "</div></div><div class='row'><label class='col-md-4 cont'>Email</label><div class='col-md-5'>" + data['email'] + "</div></div><div class='row'><label class='col-md-4 cont'>Nomor Telepon</label><div class='col-md-5'>" + data['nomor_telepon'] + "</div></div><div class='row'><label class='col-md-4 cont'>Rating</label><div class='col-md-5'>" + appendString + "</div></div><div class='row pull-right'><div class='col-md-9'><button class='btn btn-primary' id='kirim' name='kirim'>Kirim</button></div></div>");
                            } else {
                                $("#gudang-result").show();
                                $("#gudang-result").find(".panel-heading").append("Gudang Tidak Ditemukan");
                                $("#gudang-result").find(".panel-body").append("Gudang Tidak Ditemukan");
                            }
                        },
                       error: function(xhr, status, error) 
                       {
                            alert(xhr.responseText);
                        } 
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            });

            $('#gudang-result').find('.panel-body').on( 'click', '#kirim', function () {
                var sendData = {};
                sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                sendData['user_gudang_id'] = selectedGudang['id'];
                sendData['item_id'] = {{ $id }};
                sendData['amount'] = $("#gudang-find").find("#amount").val();
                $.ajax({
                   type: "POST",
                   url: "{{ route ('pengiriman.request') }}",
                   data: sendData,
                   success: function(data)
                   {
                       // console.log(data);
                       alert("Pengiriman telah diajukan. Mohon tunggu persetujuan pemilik gudang.");
                       window.location.href = "{{ route ('item.index') }}";
                    },
                   error: function(xhr, status, error) 
                   {
                        alert(xhr.responseText);
                    } 
                 });
            });
        });
    </script>
    @endpush
    @else
    @push('scripts')
    <script>
        $(function() {
            var selectedGudang;
            $("#gudang-result").hide();

            $("#gudang-find").submit(function(e) {
                $("#gudang-result").find(".panel-heading").empty();
                $("#gudang-result").find(".panel-body").empty();
                var url = "{{ route ('gudang.takeFind', 'id') }}"
                url = url.replace('id', {{ $id }});
                $.ajax({
                       type: "GET",
                       url: url,
                       data: $("#gudang-find").serialize(), // serializes the form's elements.
                       success: function(data)
                       {
                            // console.log(data);
                            if (typeof data['name'] !== 'undefined') {
                                selectedGudang = data;
                                $("#gudang-result").show();
                                appendString='';
                                for(var i = 0; i< (data['rating']/10); i++){
                                    appendString += "&#9733;";
                                }
                                $("#gudang-result").find(".panel-heading").append("Gudang Ditemukan");
                                $("#gudang-result").find(".panel-body").append("<div class='row'><label class='col-md-4 cont'>Pemilik</label><div class='col-md-5'>" + data['name'] + "</div></div><div class='row'><label class='col-md-4 cont'>Alamat</label><div class='col-md-5'>" + data['alamat'] + "</div></div><div class='row'><label class='col-md-4 cont'>Email</label><div class='col-md-5'>" + data['email'] + "</div></div><div class='row'><label class='col-md-4 cont'>Nomor Telepon</label><div class='col-md-5'>" + data['nomor_telepon'] + "</div></div><div class='row'><label class='col-md-4 cont'>Rating</label><div class='col-md-5'>" + appendString + "</div></div><div class='row pull-right'><div class='col-md-9'><button class='btn btn-primary' id='ambil' name='kirim'>Ambil</button></div></div>");
                            } else {
                                $("#gudang-result").show();
                                $("#gudang-result").find(".panel-heading").append("Gudang Tidak Ditemukan");
                                $("#gudang-result").find(".panel-body").append("Gudang Tidak Ditemukan");
                            }
                        },
                       error: function(xhr, status, error) 
                       {
                            alert(xhr.responseText);
                        } 
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            });

            $('#gudang-result').find('.panel-body').on( 'click', '#ambil', function () {
                var sendData = {};
                sendData['_token'] = $('meta[name="csrf-token"]').attr('content');
                sendData['user_gudang_id'] = selectedGudang['id'];
                sendData['item_id'] = {{ $id }};
                sendData['amount'] = $("#gudang-find").find("#amount").val();
                $.ajax({
                   type: "POST",
                   url: "{{ route ('pengiriman.take') }}",
                   data: sendData,
                   success: function(data)
                   {
                       console.log(data);
                       alert("Pengambilan telah diajukan.");
                       window.location.href = "{{ route ('item.index') }}";
                    },
                   error: function(xhr, status, error) 
                   {
                        alert(xhr.responseText);
                    } 
                 });
            });
        });
    </script>
    @endpush
    @endif
    @endif
</div>
@endsection
