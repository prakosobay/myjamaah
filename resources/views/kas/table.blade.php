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
                    <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" required />
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label"><b>Tanggal Sampai :</b></label>
                    <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" required />
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
                    <button type="button" name="filter" id="filter" class="btn btn-primary mr-2">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-warning">Refresh</button>
                </div>
            </div>
        </div>

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
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')

    <script>
        $(document).ready( function () {

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
                        { data: 'val', name: 'val' }
                    ]
                });
            }

            $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var type = $('#type').val();
                // console.log(type);
                if(from_date != '' &&  to_date != ''){
                    $('#transaction').DataTable().destroy();
                    load_data(from_date, to_date, type);
                } else{
                    alert('Kedua Tanggal Harus Terisi !');
                }
            });

            $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                $('#type').val('');
                $('#transaction').DataTable().destroy();
                load_data();
            });
        });
    </script>
@endpush
@endsection
