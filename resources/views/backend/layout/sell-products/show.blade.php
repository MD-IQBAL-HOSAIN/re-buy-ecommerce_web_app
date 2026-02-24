@extends('backend.master')

@section('title', 'Sell Product Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Sell Product Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('sell-products.index') }}">Sell Products</a></li>
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
                    <h4 class="text-center mb-4">Sell Product Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Language</th>
                                <td>{{ $data->language->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Category</th>
                                <td>{{ $data->buySubcategory?->buyCategory?->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Subcategory</th>
                                <td>{{ $data->buySubcategory->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Name</th>
                                <td>{{ $data->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Short Name</th>
                                <td>{{ $data->short_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Storage</th>
                                <td>{{ $data->storage ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <td>{{ $data->color ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>{{ $data->model ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>EAN</th>
                                <td>{{ $data->ean ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>{{ $data->slug ?? 'N/A' }}</td>
                            </tr>
                           {{--  <tr>
                                <th>Description</th>
                                <td>{!! $data->description ?? 'N/A' !!}</td>
                            </tr> --}}
                            <tr>
                                <th>Image</th>
                                <td>
                                    @if ($data->image)
                                        <img src="{{ asset($data->image) }}" width="120" alt="Sell Product Image">
                                    @else
                                        N/A
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
                        <a href="{{ route('sell-products.edit', $data->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('sell-products.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
