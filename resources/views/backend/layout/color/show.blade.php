@extends('backend.master')

@section('title', 'Color Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Color Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('color.index') }}">Colors</a></li>
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
                    <h4 class="text-center mb-4">Color Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Language</th>
                                <td>{{ $languages->firstWhere('id', $data->language_id)->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Color Name</th>
                                <td>{{ $data->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Color Code</th>
                                <td>{{ $data->code ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Color Preview</th>
                                <td>
                                    @if($data->code)
                                        <div style="width: 80px; height: 80px; background-color: {{ $data->code }}; border: 1px solid #ddd; border-radius: 8px;"></div>
                                    @else
                                        <span class="text-muted">No color code</span>
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

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('color.edit', $data->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('color.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
