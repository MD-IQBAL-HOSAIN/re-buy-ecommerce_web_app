@extends('backend.master')

@section('title', 'Dashboard | Product List')

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">List of Products</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2 gap-2">
                        <button type="button" class="btn btn-danger" id="bulkDeleteBtn" disabled>
                            Delete Selected
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#productCsvUploadModal">
                            Import CSV
                        </button>
                        <a href="{{ route('product.create') }}" class="btn btn-primary">+ Add Product</a>
                    </div>

                    {{-- CSV MODAL start --}}
                    @include('backend.partials.product-csv-modal')
                    {{-- CSV MODAL end --}}

                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap border-bottom w-100" id="datatable">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check m-0">
                                            <input type="checkbox" class="form-check-input" id="selectAllProducts">
                                            <label class="form-check-label" for="selectAllProducts">All Select</label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    <th>Thumbnail</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- dynamic data --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });
            if (!$.fn.DataTable.isDataTable('#datatable')) {
                let dTable = $('#datatable').DataTable({
                    order: [],
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,

                    language: {
                        processing: `<div class="text-center">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                        </div>
                        </div>`
                    },

                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('product.index') }}",
                        type: "GET",
                    },

                    columns: [{
                            data: 'bulk',
                            name: 'bulk',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'category',
                            name: 'category',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'subcategory',
                            name: 'subcategory',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'price',
                            name: 'price',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'discount_price',
                            name: 'discount_price',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'thumbnail',
                            name: 'thumbnail',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }

            // Bulk select logic
            $('#selectAllProducts').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.product-select').prop('checked', isChecked);
                toggleBulkDeleteButton();
            });

            $(document).on('change', '.product-select', function() {
                const all = $('.product-select').length;
                const checked = $('.product-select:checked').length;
                $('#selectAllProducts').prop('checked', all > 0 && all === checked);
                toggleBulkDeleteButton();
            });

            $('#bulkDeleteBtn').on('click', function() {
                const ids = $('.product-select:checked').map(function() {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    toastr.error('Please select at least one product.');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to delete selected products?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        bulkDeleteItems(ids);
                    }
                });
            });

            function toggleBulkDeleteButton() {
                const hasSelected = $('.product-select:checked').length > 0;
                $('#bulkDeleteBtn').prop('disabled', !hasSelected);
            }

            function bulkDeleteItems(ids) {
                let url = '{{ route('product.bulk-destroy') }}';
                let csrfToken = '{{ csrf_token() }}';
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        ids: ids
                    },
                    success: function(resp) {
                        $('#datatable').DataTable().ajax.reload();
                        $('#selectAllProducts').prop('checked', false);
                        toggleBulkDeleteButton();
                        if (resp.success === true) {
                            toastr.success(resp.message);
                        } else {
                            toastr.error(resp.message);
                        }
                    },
                    error: function(error) {
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            }

            // Reset select-all after table redraw
            $('#datatable').on('draw.dt', function() {
                $('#selectAllProducts').prop('checked', false);
                toggleBulkDeleteButton();
            });

            // CSV upload loading state
            $('#productCsvUploadForm').on('submit', function() {
                $('#productCsvSubmitBtn').prop('disabled', true);
                $('#productCsvCancelBtn').prop('disabled', true);
                $('.csv-upload-text').addClass('d-none');
                $('.csv-upload-spinner').removeClass('d-none');
                $('.csv-upload-overlay').removeClass('d-none');
            });
        });

        // Status Change Confirm Alert
        function showStatusChangeAlert(id) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to update the status?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    statusChange(id);
                }
            });
        }

        // Status Change
        function statusChange(id) {
            let url = '{{ route('product.status', ':id') }}';
            $.ajax({
                type: "GET",
                url: url.replace(':id', id),
                success: function(resp) {
                    console.log(resp);
                    // Reloade DataTable
                    $('#datatable').DataTable().ajax.reload();
                    if (resp.success === true) {
                        // show toast message
                        toastr.success(resp.message);
                    } else if (resp.errors) {
                        toastr.error(resp.errors[0]);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    // location.reload();
                }
            });
        }

        // delete Confirm
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete ?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }


        // Delete Button
        function deleteItem(id) {
            let url = '{{ route('product.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    $('#datatable').DataTable().ajax.reload();
                    if (resp['t-success']) {
                        toastr.success(resp.message);
                    } else {
                        toastr.error(resp.message);
                    }
                },
                error: function(error) {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        }
    </script>
@endpush
