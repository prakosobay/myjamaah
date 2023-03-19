@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Jamaah</b></h1>
        </div>
        <div class="card-header py-3">
            <a type="button" class="btn btn-primary" href="{{ route('citizenAdd')}}">
                Tambah Data
            </a>

            <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#staticBackdrop">
                Import Excel
            </button>

              <!-- Modal Import Excel -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="{{ route('citizenImport')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="jamaah" class="form-label">Pilih File Excel</label>
                                    <input type="file" class="form-control" id="jamaah" name="jamaah" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <a type="button" class="btn btn-secondary mx-2" href="{{ route('citizenExport')}}">
                Export Excel
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
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>No. </th>
                            <th>Nama</th>
                            <th>No. KK</th>
                            <th>Agama</th>
                            <th>Tanggal Lahir</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                        @foreach ( $citizens as $citizen )
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $citizen->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $citizen->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="{{ route('citizenDelete', $citizen->id)}}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Anda Yakin Ingin Menghapus ?</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <button class="btn btn-danger mx-1 my-1" type="submit">Hapus</button>
                                                <button class="btn btn-secondary mx-1 my-1" data-dismiss="modal" type="button">Tidak</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{ $citizen->name }}</td>
                            <td>{{ $citizen->nik_number }}</td>
                            <td>{{ $citizen->mReligionId->name }}</td>
                            <td>{{ Carbon\Carbon::parse($citizen->birthday)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('citizenView', $citizen->id)}}" class="btn-success btn-sm btn mx-1 my-1">Detail</a>
                                <a href="{{ route('citizenEdit', $citizen->id)}}" class="btn-warning btn-sm btn mx-1 my-1">Perbarui</a>
                                <button type="button" class="btn btn-danger btn-sm mx-1 my-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $citizen->id }}" data-id="{{ $citizen->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        $(document).ready( function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
@endsection
