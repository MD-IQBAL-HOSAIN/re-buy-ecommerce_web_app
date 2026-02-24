@extends('backend.master')

@section('title', 'SEO Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">SEO Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">SEO</a></li>
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
                    <h4 class="text-center mb-4">SEO Script Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Script</th>
                                <td>
                                    <pre class="bg-light p-3 rounded mb-0" style="white-space: pre-wrap;">{!! $data->script ?? 'N/A' !!}</pre>
                                </td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Status</th>
                                <td>
                                    @if ($data->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
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

                    <div class="d-flex justify-content-between gap-2">
                        <a href="{{ route('seo.edit', $data->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('seo.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
