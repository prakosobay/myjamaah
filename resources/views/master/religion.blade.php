@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center">Agama</h1>
        </div>
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                Tambah Data
            </button>

              <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="{{ route('religionStore')}}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="religion" class="form-label"><b>Nama Agama:</b></label>
                                    <input id="religion" type="text" class="form-control" name="name" required  autofocus>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>No. </th>
                            <th>Nama</th>
                            <th>Updated By</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                        @foreach ( $religions as $religion )

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $religion->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel{{ $religion->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="{{ route('religionDelete', $religion->id)}}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Anda Yakin Ingin Menghapus ?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Yakin</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{ $religion->name }}</td>
                            <td>{{ $religion->updatedBy->name }}</td>
                            <td>{{ $religion->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm mx-1 my-1" data-toggle="modal" data-target="#deleteModal{{ $religion->id }}" data-id="{{ $religion->id }}">
                                    Delete
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
