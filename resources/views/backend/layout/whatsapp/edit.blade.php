@extends('backend.master')

@section('title', 'WhatsApp Number')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">WhatsApp Number</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">WhatsApp</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1">Update WhatsApp Contact</h5>
                            <p class="text-muted mb-0">This number will be used for customer support and inquiries.</p>
                        </div>
                        <div class="avatar-sm">
                            <div class="avatar-title rounded bg-soft-success text-success">
                                <i class="ri-whatsapp-line"></i>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('whatsapp.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">WhatsApp Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                <input type="text" name="number"
                                    class="form-control @error('number') is-invalid @enderror"
                                    placeholder="+4915123456789"
                                    pattern="^\+[0-9]{6,29}$"
                                    inputmode="numeric"
                                    value="{{ old('number', $whatsapp->number ?? '') }}">
                            </div>
                            <div class="form-text">Include country code, e.g. +4915123456789</div>
                            @error('number')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="ri-save-line align-middle me-1"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
