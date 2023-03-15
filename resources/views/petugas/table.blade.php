@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Petugas</b></h1>
        </div>
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Data
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
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Store-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        {{-- <input type="text" class="form-control" placeholder="Isi di sini" value="{{ old('name')}}" id="name" name="name" required> --}}
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
                        <button class="btn btn-danger mx-1 my-1" type="submit">Simpan</button>
                        <button class="btn btn-secondary mx-1 my-1" data-dismiss="modal" type="button">Tidak</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')

    <script>
        $(document).ready( function () {
            $('#petugas').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('yajraLaporanPetugas') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'mPetugasId.name', name: 'mPetugasId.name' },
                    { data: 'duty', name: 'duty' },
                    { data: 'date', name: 'date' },
                    { data: 'nominal', name: 'nominal' }
                ]
            });
        });
    </script>
@endpush
@endsection
