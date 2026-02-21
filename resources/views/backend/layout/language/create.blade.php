@extends('backend.master')

@section('title', 'Language Create')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1 class="page-title">Create Language</h1>
        </div>
        <div class="ms-auto d-flex align-items-center gap-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Language</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- start main content --}}
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form action="{{ route('language.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label for="code" class="form-label">Language Code</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ old('code') }}" placeholder="Language Code">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Language Name</label>
                            <input type="text" name="name" id="name" class="form-control " placeholder="Language Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end main content --}}
@endsection
