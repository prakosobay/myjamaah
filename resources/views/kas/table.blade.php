@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>List Data Transaksi</b></h1>
        </div>

        {{-- Filter --}}
        <div class="card-header py-3">
            <form action="{{ route('storeFilter')}}" method="POST" class="validate-form">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter_type" class="form-label"><b>Tipe Transaksi :</b></label>
                            <select name="filter_type" id="filter_type" class="form-select" required>
                                <option selected value="Semua">Semua</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from" class="form-label"><b>Tanggal Mulai :</b></label>
                            <input type="date" id="date_from" value="{{ old('date_from')}}" name="date_from" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to" class="form-label"><b>Tanggal Sampai :</b></label>
                            <input type="date" id="date_to" value="{{ old('date_to')}}" name="date_to" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-3 mt-4">
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
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

        {{-- Total Saldo --}}
        <div class="card shadow my-2">
            <div class="card">
                Total Saldo
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        $(document).ready( function () {
            $('#transaction').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('yajraTransaction')}}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'date_trans', name: 'date_trans' },
                    { data: 'type', name: 'type' },
                    { data: 'name', name: 'name' },
                    { data: 'val', name: 'val' },
                ]
            });
        });
    </script>
@endpush
@endsection
