@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    {{-- datatable --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-2 text-gray-800 text-center">Ubah Data Jamaah</h1>
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

        <div class="card-body">
            <div class="container-fluid">
                <form action="{{ route('citizenUpdate', $citizen->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="name" class="form-label"><b>Nama :</b></label>
                                <input type="text" id="name" value="{{ $citizen->name }}" name="name" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="birthday" class="form-label"><b>Tanggal Lahir :</b></label>
                                <input type="date" id="birthday" value="{{ $citizen->birthday }}" name="birthday" class="form-control @error('birthday') is-invalid @enderror" required>
                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="nik" class="form-label"><b>No. NIK :</b></label>
                                <input type="text" id="nik" name="nik" value="{{ $citizen->nik_number }}" class="form-control @error('nik') is-invalid @enderror" readonly>
                                @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="gender" class="form-label"><b>Jenis Kelamin :</b></label>
                                <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="{{ $citizen->gender }}">{{ $citizen->gender }}</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="kk" class="form-label"><b>No. KK :</b></label>
                                <input type="text" id="kk" name="kk" value="{{ $citizen->kk_number }}" class="form-control @error('kk') is-invalid @enderror" readonly>
                                @error('kk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="phone" class="form-label"><b>No. Telepon :</b></label>
                                <input type="text" id="phone" name="phone" value="{{ $citizen->phone }}" class="form-control @error('phone') is-invalid @enderror" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group my-2">
                                <label for="street" class="form-label"><b>Jalan :</b></label>
                                <input type="text" id="street" class="form-control @error('phone') is-invalid @enderror" name="street" value="{{ $citizen->street }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group my-2">
                                <label for="rt" class="form-label"><b>RT :</b></label>
                                <select name="rt" id="rt" class="form-select  @error('rt') is-invalid @enderror" required>
                                    <option value="{{ $citizen->rt }}">{{ $citizen->rt }}</option>
                                    @for ( $i = 1; $i < 14; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('rt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group my-2">
                                <label for="rw" class="form-label"><b>RW :</b></label>
                                <select name="rw" id="rw" class="form-select @error('rw') is-invalid @enderror" required>
                                    <option value="{{ $citizen->rw }}">{{ $citizen->rw }}</option>
                                    <option value="04">04</option>
                                    <option value="06">06</option>
                                </select>
                                @error('rw')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group my-2">
                                <label for="house_number" class="form-label"><b>No :</b></label>
                                <input type="text" id="house_number" name="house_number" value="{{ $citizen->house_number }}" class="form-control @error('house_number') is-invalid @enderror" required>
                                @error('house_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="job" class="form-label"><b>Pekerjaan :</b></label>
                                <select name="job" id="job" class="form-select @error('job') is-invalid @enderror" required>
                                    <option value="{{ $citizen->mJobId->id }}">{{ $citizen->mJobId->name }}</option>
                                    @foreach ( $jobs as $job )
                                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                                    @endforeach
                                </select>
                                @error('job')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="education" class="form-label"><b>Pendidikan :</b></label>
                                <select name="education" id="education" class="form-select @error('education') is-invalid @enderror" required>
                                    <option value="{{ $citizen->mEducationId->id }}">{{ $citizen->mEducationId->name }}</option>
                                    @foreach ( $educations as $education )
                                        <option value="{{ $education->id }}">{{ $education->name }}</option>
                                    @endforeach
                                </select>
                                @error('education')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="residenceStatus" class="form-label"><b>Status Tempat Tinggal :</b></label>
                                <select name="residenceStatus" id="residenceStatus" class="form-select @error('residenceStatus') is-invalid @enderror" required>
                                    <option value="{{ $citizen->mResidenceStatusId->id }}">{{ $citizen->mResidenceStatusId->name }}</option>
                                    @foreach ( $residenceStatuses as $residenceStatus )
                                        <option value="{{ $residenceStatus->id }}">{{ $residenceStatus->name }}</option>
                                    @endforeach
                                </select>
                                @error('residenceStatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if($citizen->is_death)
                                <div class="form-group my-2">
                                    <label for="flexCheckChecked" class="form-label"><b>Keterangan :</b></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckChecked" name="is_death" checked>
                                        <label class="form-check-label" for="flexCheckChecked">Meninggal</label>
                                    </div>
                                </div>
                            @else
                                <div class="form-group my-2">
                                    <label for="flexCheckDefault" class="form-label"><b>Keterangan :</b></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_death">
                                        <label class="form-check-label" for="flexCheckDefault">Meninggal</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="salary" class="form-label"><b>Penghasilan Per Bulan :</b></label>
                                <select name="salary" id="salary" class="form-select @error('salary') is-invalid @enderror" required>
                                    <option value="{{ $citizen->mSalaryId->id }}">Rp.{{ $citizen->mSalaryId->mulai }} - Rp.{{ $citizen->mSalaryId->sampai }}</option>
                                    @foreach ( $salaries as $salary )
                                        <option value="{{ $salary->id }}">Rp.{{ $salary->mulai }} - Rp.{{ $salary->sampai }}</option>
                                    @endforeach
                                </select>
                                @error('salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="marriageStatus" class="form-label"><b>Status Perkawinan :</b></label>
                                <select name="marriageStatus" id="marriageStatus" class="form-select @error('marriageStatus') is-invalid @enderror" required>
                                    <option value="{{ $citizen->marriage_status }}">{{ $citizen->marriage_status }}</option>
                                    <option value="Belom Kawin">Belom Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Duda">Duda</option>
                                    <option value="Janda">Janda</option>
                                </select>
                                @error('marriageStatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="socialStatus" class="form-label"><b>Status Social :</b></label>
                                <select name="socialStatus" id="socialStatus" class="form-select @error('socialStatus') is-invalid @enderror" required>
                                    <option value="{{ $citizen->mSocialStatusId->id }}">{{ $citizen->mSocialStatusId->name }}</option>
                                    @foreach ( $socialStatuses as $socialStatus )
                                        <option value="{{ $socialStatus->id }}">{{ $socialStatus->name }}</option>
                                    @endforeach
                                </select>
                                @error('socialStatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="death_date" class="form-label"><b>Tanggal Meninggal :</b></label>
                                <input type="date" id="death_date" value="{{ $citizen->death_date }}" name="death_date" class="form-control @error('death_date') is-invalid @enderror">
                                @error('death_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group my-2">
                                <label for="religion" class="form-label"><b>Agama :</b></label>
                                <select name="religion" id="religion" class="form-select" required>
                                    <option value="{{ $citizen->mReligionId->id }}">{{ $citizen->mReligionId->name }}</option>
                                    @foreach ( $religions as $religion )
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="familyStatus" class="form-label"><b>Status Dalam Keluarga :</b></label>
                                <select name="familyStatus" id="familyStatus" class="form-select" required>
                                    <option value="{{ $citizen->mFamilyStatusId->id }}">{{ $citizen->mFamilyStatusId->name }}</option>
                                    @foreach ( $familyStatuses as $familyStatus )
                                        <option value="{{ $familyStatus->id }}">{{ $familyStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-2">
                                <label for="age" class="form-label"><b>Umur :</b></label>
                                <input type="text" id="age" value="{{ $age }} Tahun" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button class="btn-primary btn mx-1 my-1" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')

@endpush
@endsection
