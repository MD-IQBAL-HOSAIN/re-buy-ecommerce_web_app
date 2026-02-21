@extends('backend.master')

@section('title', 'Question Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <h4 class="mb-sm-0">Question Details</h4>
                </div>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('question.index') }}">Questions</a></li>
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
                    <h4 class="text-center mb-4">Question Details</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 200px;">Sell Product</th>
                                <td>{{ $data->sellProduct->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 200px;">Question</th>
                                <td>{{ $data->question ?? 'N/A' }}</td>
                            </tr>
                           {{--  <tr>
                                <th>Question Price</th>
                                <td>{{ number_format($data->price, 2) ?? 'N/A' }}</td>
                            </tr> --}}
                            <tr>
                                <th>Options</th>
                                <td>
                                    @if ($data->options && $data->options->count() > 0)
                                        <ul class="mb-0">
                                            @foreach ($data->options as $option)
                                                <li>{{ $option->option }} ( Price: {{ number_format($option->price, 2) }})</li>
                                            @endforeach
                                        </ul>
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
                        <a href="{{ route('question.edit', $data->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('question.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
