@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center">Detail Data Jamaah</h1>
        </div>
        <div class="card-header py-3">
            <a type="button" class="btn btn-primary" href="{{ route('citizenTable')}}">
                Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group my-2">
                            <label for="name" class="form-label"><b>Nama :</b></label>
                            <input type="text" id="name" value="{{ $citizen->name }}" name="name" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="birthday" class="form-label"><b>Tanggal Lahir :</b></label>
                            <input type="date" id="birthday" value="{{ $citizen->birthday }}" name="birthday" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group my-2">
                            <label for="nik" class="form-label"><b>No. NIK :</b></label>
                            <input type="text" id="nik" name="nik" value="{{ $citizen->nik_number }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="gender" class="form-label"><b>Jenis Kelamin :</b></label>
                            <input type="text" id="gender" name="gender" value="{{ $citizen->gender }}" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group my-2">
                            <label for="kk" class="form-label"><b>No. KK :</b></label>
                            <input type="text" id="kk" name="kk" value="{{ $citizen->kk_number }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="phone" class="form-label"><b>No. Telepon :</b></label>
                            <input type="text" id="phone" name="phone" value="{{ $citizen->phone }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group my-2">
                            <label for="street" class="form-label"><b>Jalan :</b></label>
                            <input type="text" id="street" class="form-control" value="{{ $citizen->street }}" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group my-2">
                            <label for="rt" class="form-label"><b>RT :</b></label>
                            <input type="text" id="rt" value="{{ $citizen->rt }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group my-2">
                            <label for="rw" class="form-label"><b>RW :</b></label>
                            <input type="text" id="rw" value="{{ $citizen->rw }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group my-2">
                            <label for="house_number" class="form-label"><b>No :</b></label>
                            <input type="text" id="house_number" value="{{ $citizen->house_number }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group my-2">
                            <label for="job" class="form-label"><b>Pekerjaan :</b></label>
                            <input type="text" id="job" value="{{ $citizen->mJobId->name }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="education" class="form-label"><b>Pendidikan :</b></label>
                            <input type="text" id="education" value="{{ $citizen->mEducationId->name }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="residenceStatus" class="form-label"><b>Status Tempat Tinggal :</b></label>
                            <input type="text" id="residenceStatus" value="{{ $citizen->mResidenceStatusId->name }}" class="form-control" readonly>
                        </div>
                        @if($citizen->is_death == true)
                            <div class="form-group my-2">
                                <label for="isDeath" class="form-label"><b>Keterangan :</b></label>
                                <input type="text" id="isDeath" class="form-control" value="Meninggal" readonly>
                            </div>
                        @endif
                    </div>
                    <div class="col-4">
                        <div class="form-group my-2">
                            <label for="salary" class="form-label"><b>Penghasilan Per Bulan :</b></label>
                            <input type="text" id="salary" value="Rp.{{ $citizen->mSalaryId->mulai }} - Rp.{{ $citizen->mSalaryId->sampai }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="marriageStatus" class="form-label"><b>Status Perkawinan :</b></label>
                            <input type="text" id="marriageStatus" value="{{ $citizen->marriage_status }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="socialStatus" class="form-label"><b>Status Social :</b></label>
                            <input type="text" id="socialStatus" value="{{ $citizen->mSocialStatusId->name }}" class="form-control" readonly>
                        </div>
                        @if($citizen->death_date)
                            <div class="form-group my-2">
                                <label for="death_date" class="form-label"><b>Tanggal Meninggal :</b></label>
                                <input type="date" id="death_date" value="{{ $citizen->death_date }}" class="form-control" readonly>
                            </div>
                        @endif
                    </div>
                    <div class="col-4">
                        <div class="form-group my-2">
                            <label for="religion" class="form-label"><b>Agama :</b></label>
                            <input type="text" id="religion" value="{{ $citizen->mReligionId->name }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="familyStatus" class="form-label"><b>Status Dalam Keluarga :</b></label>
                            <input type="text" id="familyStatus" value="{{ $citizen->mFamilyStatusId->name }}" class="form-control" readonly>
                        </div>
                        <div class="form-group my-2">
                            <label for="age" class="form-label"><b>Umur :</b></label>
                            <input type="text" id="age" value="{{ $age }} Tahun" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
@endsection
