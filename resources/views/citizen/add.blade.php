@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center"><b>Data Jamaah</b></h1>
        </div>
        <div class="card-header py-3">
            <a type="button" class="btn btn-primary" href="{{ route('citizenTable')}}">
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

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <div class="container-fluid">
                <form action="{{ route('citizenStore')}}" method="POST" id="citizenForm">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="name" class="form-label"><b>Nama :</b></label>
                                <input type="text" id="name" value="{{ old('name')}}" name="name" class="form-control @error('name') is-invalid @enderror" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="birthday" class="form-label"><b>Tanggal Lahir :</b></label>
                                <input type="date" id="birthday" value="{{ old('birthday')}}" name="birthday" class="form-control">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="nik" class="form-label"><b>No. NIK :</b></label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik')}}" class="form-control" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="gender" class="form-label"><b>Jenis Kelamin :</b></label>
                                <select name="gender" id="gender" class="form-select">
                                    <option selected></option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="kk" class="form-label"><b>No. KK :</b></label>
                                <input type="text" id="kk" name="kk" value="{{ old('kk')}}" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="phone" class="form-label"><b>No. Telepon :</b></label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone')}}" class="form-control" placeholder="Gunakan +62 xxxx" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group my-2">
                                <label for="street" class="form-label"><b>Jalan :</b></label>
                                <input type="text" id="street" class="form-control" name="street" value="{{ old('street')}}" >
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group my-2">
                                <label for="rt" class="form-label"><b>RT :</b></label>
                                <select name="rt" id="rt" class="form-select" >
                                    <option selected></option>
                                    @for ( $i = 1; $i < 14; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group my-2">
                                <label for="rw" class="form-label"><b>RW :</b></label>
                                <select name="rw" id="rw" class="form-select" >
                                    <option selected></option>
                                    <option value="04">04</option>
                                    <option value="06">06</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group my-2">
                                <label for="house_number" class="form-label"><b>No :</b></label>
                                <input type="text" id="house_number" name="house_number" value="{{ old('house_number')}}" class="form-control" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="job" class="form-label"><b>Pekerjaan :</b></label>
                                <select name="job" id="job" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $jobs as $job )
                                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="education" class="form-label"><b>Pendidikan :</b></label>
                                <select name="education" id="education" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $educations as $education )
                                        <option value="{{ $education->id }}">{{ $education->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="residenceStatus" class="form-label"><b>Status Tempat Tinggal :</b></label>
                                <select name="residenceStatus" id="residenceStatus" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $residenceStatuses as $residenceStatus )
                                        <option value="{{ $residenceStatus->id }}">{{ $residenceStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="flexCheckDefault" class="form-label"><b>Keterangan :</b></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_death">
                                    <label class="form-check-label" for="flexCheckDefault">Meninggal</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="salary" class="form-label"><b>Penghasilan Per Bulan :</b></label>
                                <select name="salary" id="salary" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $salaries as $salary )
                                        <option value="{{ $salary->id }}">{{ ($salary->range) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="marriageStatus" class="form-label"><b>Status Perkawinan :</b></label>
                                <select name="marriageStatus" id="marriageStatus" class="form-select" >
                                    <option selected></option>
                                    <option value="Belom Kawin">Belom Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Janda">Janda</option>
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="socialStatus" class="form-label"><b>Status Social :</b></label>
                                <select name="socialStatus" id="socialStatus" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $socialStatuses as $socialStatus )
                                        <option value="{{ $socialStatus->id }}">{{ $socialStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="death_date" class="form-label"><b>Tanggal Meninggal :</b></label>
                                <input type="date" id="death_date" value="{{ old('death_date')}}" name="death_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="religion" class="form-label"><b>Agama :</b></label>
                                <select name="religion" id="religion" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $religions as $religion )
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="familyStatus" class="form-label"><b>Status Dalam Keluarga :</b></label>
                                <select name="familyStatus" id="familyStatus" class="form-select" >
                                    <option selected></option>
                                    @foreach ( $familyStatuses as $familyStatus )
                                        <option value="{{ $familyStatus->id }}">{{ $familyStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn-primary btn my-1 mx-1" type="submit" id="citizenForm">Simpan</button>
                        </div>
                    </div>
                </form>
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
