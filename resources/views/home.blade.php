@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Dashboard</b></h1>
    </div>

    <div class="row">

        <!-- Pemasukan -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-success text-uppercase mb-1">
                                Pemasukan</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp. {{ number_format($pemasukan)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengeluaran --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-danger text-uppercase mb-1">
                                Pengeluaran</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp. {{ number_format($pengeluaran)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- Jamaah -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-info text-uppercase mb-1">Total Jamaah
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h4 mb-0 mr-3 font-weight-bold text-gray-800">{{ $jamaah }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Saldo Akhir --}}
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                Saldo Akhir</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">Rp. {{ number_format($total)}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="calendar-section">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <div class="calendar calendar-first" id="calendar_first">
                                    <div class="calendar_header">
                                        <button class="switch-month switch-left">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <h2></h2>
                                        <button class="switch-month switch-right">
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <div class="calendar_weekdays"></div>
                                    <div class="calendar_content"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="calendar calendar-second" id="calendar_second">
                                    <div class="calendar_header">
                                        <button class="switch-month switch-left">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <h2></h2>
                                        <button class="switch-month switch-right">
                                            <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <div class="calendar_weekdays"></div>
                                    <div class="calendar_content"></div>
                                </div>
                            </div>
                        </div> <!-- End Row -->
		            </div> <!-- End Calendar -->
				</div>
			</div>
		</div>
	</section>
</div>

@push('scripts')

@endpush
@endsection
