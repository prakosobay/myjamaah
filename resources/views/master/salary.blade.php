@extends('layouts.master')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center">Penghasilan Perbulan</h1>
        </div>
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Data
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="{{ route('salaryStore')}}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="mulai" class="form-label"><b>Mulai :</b></label>
                                    <input id="mulai" type="text" class="form-control" name="mulai" required  autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="sampai" class="form-label"><b>Sampai :</b></label>
                                    <input id="sampai" type="text" class="form-control" name="sampai" required >
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
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="judul-table text-center">
                            <th>No. </th>
                            <th>Penghasilan</th>
                            <th>Updated By</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                        @foreach ( $salaries as $salary )
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $salary->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{ $salary->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="{{ route('salaryDelete', $salary->id)}}">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Anda Yakin Ingin Menghapus ?</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <button class="btn btn-danger mx-1 my-1" type="submit">Yes</button>
                                                <button class="btn btn-secondary mx-1 my-1" data-dismiss="modal" type="button">No</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>Rp.{{ $salary->mulai }} - Rp.{{ $salary->sampai }}</td>
                            <td>{{ $salary->updatedBy->name }}</td>
                            <td>{{ $salary->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm mx-1 my-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $salary->id }}" data-id="{{ $salary->id }}">
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