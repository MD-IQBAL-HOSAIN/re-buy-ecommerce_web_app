@extends('backend.master')

@section('title', 'Storage Details')

@push('styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Storage Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('storage.index') }}">Storages</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card box-shadow-0">
                <div class="card-body">
                    <h4 class="text-center mb-4">Storage Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Language</th>
                                <td>{{ $languages->firstWhere('id', $storage->language_id)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Storage Name</th>
                                <td>{{ $storage->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Capacity</th>
                                <td>{{ $storage->capacity ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $storage->created_at ? $storage->created_at->format('d M, Y h:i A') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $storage->updated_at ? $storage->updated_at->format('d M, Y h:i A') : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('storage.edit', $storage->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('storage.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
