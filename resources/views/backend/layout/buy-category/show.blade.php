@extends('backend.master')

@section('title', 'Buy Category Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Buy Category Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Buy Category</a></li>
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
                    <h4 class="text-center mb-4">Category Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Language</th>
                                <td>{{ $data->language->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $data->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $data->slug ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($data->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    @if($data->image)
                                        <img src="{{ asset($data->image) }}" alt="{{ $data->name }}" width="150" height="150" style="object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $data->created_at ? $data->created_at->format('d M, Y h:i A') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $data->updated_at ? $data->updated_at->format('d M, Y h:i A') : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('buy-category.edit', $data->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('buy-category.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
