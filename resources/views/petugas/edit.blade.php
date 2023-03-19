@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Petugas</b></h1>
        </div>
        <div class="card-header py-3">
            <a type="button" href="{{ route('tableLaporanPetugas')}}" class="btn btn-primary mr-2">
                Kembali
            </a>
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
            <form method="post" action="{{ route('petugasUpdate', $petugas->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Petugas :</label>
                            <input type="text" id="name" value="{{ $petugas->mPetugasId->name }}" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="duty" class="form-label">Tugas :</label>
                            <input type="text" id="duty" name="duty" value="{{ $petugas->duty }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date" class="form-label">Tanggal :</label>
                            <input type="date" id="date" name="date" value="{{ $petugas->date }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nominal" class="form-label">Nominal (Rp) :</label>
                            <input type="text" id="nominal" name="nominal" value="{{ $petugas->nominal }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status" class="form-label">Status Pembayaran :</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="{{ $petugas->status }}">{{ $petugas->status }}</option>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Sudah Dibayar">Sudah Dibayar</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pencatat" class="form-label">Pencatat : </label>
                            <input type="pencatat" id="pencatat" value="{{ auth()->user()->name }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary btn-lg" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')

@endpush
@endsection
