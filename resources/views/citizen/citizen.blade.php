@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Jamaah</b></h1>
        </div>
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <a type="button" class="btn btn-primary" href="{{ route('citizenAdd')}}">
                        Tambah Data
                    </a>

                    <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#staticBackdrop">
                        Import Excel
                    </button>

                    <a type="button" class="btn btn-secondary mx-2" href="{{ route('citizenExport')}}">
                        Export Excel
                    </a>
                </div>

                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="colFormLabelSm" class="col-3 col-form-label col-form-label-sm mt-1"><h5>RW :</h5></label>
                        <div class="col-sm-5">
                            <select name="rw" id="rw" class="form-select">
                                <option selected></option>
                                <option value="04">04</option>
                                <option value="06">06</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-warning" name="filter" id="filter" type="button">Filter</button>
                        </div>
                    </div>
                </div>
            </div>

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
                <table class="table table-hover table-bordered" id="citizen" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>No. </th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>RW</th>
                            <th>Tanggal Lahir</th>
                            <th>Pilihan</th>
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

            load_data();
            $('#filter').click(function() {
                var type = $('#rw').val();

                $('#citizen').DataTable().destroy();
                load_data(type);
            });

            function load_data(type = ''){
                $('#citizen').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:'{{ route('yajraCitizen')}}',
                        data:{type:type}
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'name', name: 'name' },
                        { data: 'nik_number', name: 'nik_number' },
                        { data: 'rw', name: 'rw' },
                        { data: 'birthday', name: 'birthday' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            }
        });
    </script>
@endpush
@endsection
