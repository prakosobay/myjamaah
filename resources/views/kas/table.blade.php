@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>List Data Transaksi</b></h1>
        </div>

        {{-- Filter --}}
        <div class="card-header py-3">
            <div class="row input-daterange">
                <div class="col-md-3">
                    <label for="from_date" class="form-label"><b>Tanggal Mulai :</b></label>
                    <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label"><b>Tanggal Sampai :</b></label>
                    <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label"><b>Tipe Transaksi :</b></label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="Semua">Semua</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3 mt-4 pt-2">
                    <button type="button" name="filter" id="filter" class="btn btn-sm btn-primary mr-1">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-sm btn-warning mr-1">Refresh</button>
                    <button type="button" name="submit" id="export" class="btn btn-sm btn-success">Export</button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mx-2 my-2 text-center">
                <b>{{ session('success') }}</b>
            </div>
        @endif

        @if (session('failed'))
            <div class="alert alert-danger mx-2 my-2 text-center">
                <b>{{ session('failed') }}</b>
            </div>
        @endif

        {{-- Table --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="transaction" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Nama Transaksi</th>
                            <th class="currency">Nominal (Rp)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 col-md-6">
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="transaction" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                        <tr>
                            <td >Pemasukan</td>
                            <td class="currency" id="pemasukan"></td>
                        </tr>
                        <tr>
                            <td>Pengeluaran</td>
                            <td class="currency" id="pengeluaran"></td>
                        </tr>
                        <tr>
                            <td>Saldo Akhir</td>
                            <td class="currency" id="saldo_akhir"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('scripts')

    {{-- mask Money --}}
    <script src="{{ asset('vendor/jquery/jquery.maskMoney.min.js') }}"></script>
    <script>
        $(document).ready( function () {

            load_data();
            function load_data(from_date = '', to_date = '', type = ''){
                $('#transaction').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:'{{ route('yajraTransaction')}}',
                        data:{from_date:from_date, to_date:to_date, type:type}
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'date_trans', name: 'date_trans' },
                        { data: 'type', name: 'type' },
                        { data: 'name', name: 'name' },
                        { data: 'val', name: 'val' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            }

            function load_data_total(from_date = '', to_date = '', type = ''){
                let income, expense, total;
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: '{{ route('totalSaldo')}}',
                    data : {from_date:from_date, to_date:to_date, type:type},
                    success: function (data) {
                        if(data.length !== 0){

                            for (let i = 0; i < data.length; i++) {
                               if(data[i].type_transaction === 'Pemasukan'){
                                   income = data[i].total;
                                //    console.log(parseInt(income).toLocaleString())
                                    $('#pemasukan').html(` Rp. ${parseInt(income).toLocaleString()}`);
                               }

                               else if(data[i].type_transaction === 'Pengeluaran'){

                                    expense = data[i].total;
                                    $('#pengeluaran').html(` Rp. ${parseInt(expense).toLocaleString()}`);
                               }

                                total = income - expense;
                                $('#saldo_akhir').html(` Rp. ${parseInt(total).toLocaleString()}`);
                            }
                        }

                        console.log(data)
                    },
                    error: function() {
                        console.log(data);
                    }
                });
            }

            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var type = $('#type').val();

                if(from_date != '' &&  to_date != ''){
                    $('#transaction').DataTable().destroy();
                    load_data(from_date, to_date, type);
                    load_data_total(from_date, to_date, type);
                } else{
                    alert('Kedua Tanggal Harus Terisi !');
                }
            });

            $('#export').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var type = $('#type').val();

                if(from_date != '' &&  to_date != ''){
                    exportExcel(from_date, to_date, type)

                } else{
                    alert('Kedua Tanggal Harus Terisi !');
                }
            });

            function exportExcel(from_date = '', to_date = '', type = ''){
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: '{{ route('exportExcelSaldo')}}',
                    data : {from_date:from_date, to_date:to_date, type:type},
                    xhrFields:{
                        responseType: 'blob'
                    },
                    success: function (data) {
                        let link = document.createElement('a')
                        link.href = window.URL.createObjectURL(data)
                        link.download = 'Report.xlsx'
                        link.click()
                        console.log(data)
                    },
                    error: function() {
                        console.log(data);
                    }
                });
            }

            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#type').val('');
                $('#pemasukan').val('');
                $('#pengeluaran').val('');
                $('#saldo_akhir').val('');
                $('#transaction').DataTable().destroy();
                load_data();
                load_data_total();
            });

            $(function() {
                $('.currency').maskMoney({ prefix: 'Rp ', thousands: '.' });
            });
        });
    </script>
@endpush
@endsection
