@extends('backend.master')

@section('title', 'View How It Works')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">How It Works Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">How It Works</a></li>
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
                    <h4 class="text-center mb-4">How It Works Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Image</th>
                                <td>
                                    @if ($item->image)
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" width="150"
                                            height="150" style="object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Language</th>
                                <td>{{ $item->language->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>{{ $item->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Subtitle</th>
                                <td>{{ $item->subtitle ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $item->created_at ? $item->created_at->format('d M, Y h:i A') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $item->updated_at ? $item->updated_at->format('d M, Y h:i A') : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('how-it-works.edit', $item->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('how-it-works.index') }}" class="btn btn-secondary ms-auto">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
