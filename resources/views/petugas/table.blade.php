@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Petugas</b></h1>
        </div>
        <div class="card-header py-3">

            <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#addData">
                Tambah Data
            </button>

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Export Excel
              </button>
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="petugas" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>No. </th>
                            <th>Nama Petugas</th>
                            <th>Tugas</th>
                            <th>Tanggal</th>
                            <th>Nominal (Rp)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Excel --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('laporanPetugas.exportExcel') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Export Data Petugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label"><b>Nama Petugas :</b></label>
                            <select name="name" id="name" class="form-select" required>
                                <option selected></option>
                                @foreach ( $petugas as $p )
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Store-->
    <div class="modal fade" id="addData" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addDataLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('storeLaporanPetugas')}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Petugas</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label"><b>Nama Petugas :</b></label>
                            <select name="name" id="name" class="form-select" required>
                                <option selected></option>
                                @foreach ( $petugas as $p )
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duty" class="form-label"><b>Tugas :</b></label>
                            <input type="text" class="form-control" placeholder="Isi di sini" value="{{ old('duty')}}" id="duty" name="duty" required>
                        </div>
                        <div class="form-group">
                            <label for="nominal" class="form-label"><b>Nominal :</b></label>
                            <input type="number" class="form-control" value="{{ old('nominal') }}" id="nominal" name="nominal" placeholder="0" required>
                        </div>
                        <div class="form-group">
                            <label for="date" class="form-label"><b>Tanggal :</b></label>
                            <input type="date" class="form-control" value="{{ old('date') }}" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-label"><b>Status</b></label>
                            <select name="status" id="status" class="form-select" required>
                                <option selected></option>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Sudah Dibayar">Sudah Dibayar</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')

    <script>
        $(document).ready( function () {
            $('#petugas').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('laporan/petugas/yajra') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'm_petugas_id.name', name: 'm_petugas_id.name' },
                    { data: 'duty', name: 'duty' },
                    { data: 'date', name: 'date' },
                    { data: 'nominal', name: 'nominal' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
@endsection
