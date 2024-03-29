@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center">Penghasilan Perbulan</h1>
        </div>
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                Tambah Data
            </button>

            {{-- Modal --}}
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form method="post" action="{{ route('salaryStore')}}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="mulai" class="form-label"><b>Penghasilan :</b></label>
                                    <input type="text" name="mulai" class="form-control" placeholder="Rp 1.000.000" required autofocus>
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
                            <th>Penghasilan</th>
                            <th>Updated By</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="isi-table text-center">
                        @foreach ( $salaries as $salary )

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $salary->id }}" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel{{ $salary->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form method="post" action="{{ route('salaryDelete', $salary->id)}}">
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
                            <td>{{ $salary->range }}</td>
                            <td>{{ $salary->updatedBy->name }}</td>
                            <td>{{ $salary->updated_at }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm mx-1 my-1" data-toggle="modal" data-target="#deleteModal{{ $salary->id }}" data-id="{{ $salary->id }}">
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

        $("input[data-type='currency']").on({
            keyup: function() {
            formatCurrency($(this));
            },
            blur: function() {
            formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();

        // don't validate empty input
        if (input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            // input_val = "Rp" + input_val;

            // final formatting
            if (blur === "blur") {
            input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
@endpush
@endsection
