@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Transaksi</b></h1>
        </div>
        <div class="card-header py-3">
            <a type="button" href="{{ route('tableTransaction')}}" class="btn btn-primary mr-2">
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
            <form method="post" action="{{ route('saldoKas.update', $get->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Transaksi :</label>
                            <input type="text" id="name" value="{{ $get->name }}" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="date" class="form-label">Tanggal :</label>
                            <input type="date" id="date" name="date_trans" value="{{ $get->date_trans }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type" class="form-label">Tipe :</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="{{ $get->type }}">{{ $get->type }}</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nominal" class="form-label">Nominal : </label>
                            <input type="nominal" id="nominal" value="{{ $get->val }}" name="nominal" class="form-control" required>
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
