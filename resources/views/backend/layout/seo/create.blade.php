@extends('backend.master')

@section('title', 'SEO Create')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header d-flex align-items-center justify-content-between">
        <div>
            <h1 class="page-title">Create SEO</h1>
        </div>
        <div class="ms-auto d-flex align-items-center gap-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create SEO</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    {{-- start main content --}}
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <form action="{{ route('seo.store') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label for="script" class="form-label">Script</label>
                            <textarea name="script" id="script" rows="6"
                                class="form-control @error('script') is-invalid @enderror"
                                placeholder="<script>...</script>">{{ old('script') }}</textarea>
                            @error('script')
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
