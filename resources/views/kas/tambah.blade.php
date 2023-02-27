@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Input Data Transaksi</b></h1>
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
            <form action="{{ route('storeTransaction')}}" method="POST" class="validate-form">
                @csrf
                <div class="card-header py-3">
                    <button type="submit" class="btn btn-success mx-3">
                        Simpan
                    </button>

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                </div>

                <div class="card-body" id="input-container">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="date" class="form-label"><b>Tanggal Transaksi :</b></label>
                            <input type="date" name="date" value="{{ old('date')}}" class="form-control" id="date" required autofocus>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type" class="form-label"><b>Tipe Transaksi :</b></label>
                                <select name="type[]" id="type" class="form-select" required>
                                    <option selected></option>
                                    <option value="Pemasukan">Pemasukan</option>
                                    <option value="Pengeluaran">Pengeluaran</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label"><b>Nama Transaksi :</b></label>
                                <input type="text" name="name[]" class="form-control" value="{{ old('name[]')}}" id="name" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="val" class="form-label"><b>Nominal :</b></label>
                                <input type="number" name="val[]" value="{{ old('val[]')}}" class="form-control" id="val" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary" id="add-input-btn">Add More</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')

    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable();

            $('#add-input-btn').on('click', function() {

                var newInput = '<div class="row my-3"><div class="col-md-2">    <div class="form-group">        <label for="type" class="form-label"><b>Tipe Transaksi :</b></label>        <select name="type[]" id="type" class="form-select" required><option selected></option><option value="Pemasukan">Pemasukan</option><option value="Pengeluaran">Pengeluaran</option>        </select>    </div></div><div class="col-md-6">    <div class="form-group">        <label for="name" class="form-label"><b>Nama Transaksi :</b></label>        <input type="text" name="name[]" class="form-control" value="{{ old('name[]')}}" id="name" required>    </div></div><div class="col-md-3">    <div class="form-group">        <label for="val" class="form-label"><b>Nominal :</b></label>        <input type="number" name="val[]" value="{{ old('val[]')}}" class="form-control" id="val" placeholder="0" required>    </div></div></div>';

            $('#input-container').append(newInput);
            });

            $(document).on('click', '#remove-btn', function() {
                $(this).prev().remove();
            });
        });
    </script>
@endpush
@endsection
