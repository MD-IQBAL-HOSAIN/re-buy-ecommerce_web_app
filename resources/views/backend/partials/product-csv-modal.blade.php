@push('styles')
    <style>
        .csv-modal {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(17, 24, 39, 0.15);
        }

        .csv-modal-header {
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
            border-bottom: 1px solid #e5e7eb;
            padding: 20px 24px;
        }

        .csv-modal-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .csv-modal-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #22c55e);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 1px;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.25);
        }

        .csv-modal-subtitle {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        .csv-upload-card {
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
        }

        .csv-input {
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
        }

        .csv-help-block {
            margin-top: 12px;
        }

        .csv-help-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .csv-help-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .csv-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: #111827;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }

        .csv-help-note {
            margin-top: 10px;
            font-size: 12px;
            color: #6b7280;
        }

        .csv-help-note code {
            background: #7492d8;
            color: #fff;
            padding: 1px 6px;
            border-radius: 6px;
            font-size: 11px;
        }

        .csv-modal-footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 16px 24px;
        }

        .csv-upload-btn {
            border-radius: 10px;
            padding: 8px 18px;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.25);
        }

        .csv-upload-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            text-align: center;
        }

        .csv-upload-overlay-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: 500;
            color: #333;
        }

        .csv-rainbow-spinner {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: conic-gradient(#ff6b6b, #ffd93d, #6bcB77, #4dabf7, #b197fc, #ff6b6b);
            mask: radial-gradient(farthest-side, transparent 55%, #000 56%);
            -webkit-mask: radial-gradient(farthest-side, transparent 55%, #000 56%);
            animation: csvSpin 1s linear infinite;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .csv-upload-title {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
        }

        .csv-upload-subtitle {
            font-size: 13px;
            color: #6b7280;
        }

        @keyframes csvSpin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

<div class="modal fade" id="productCsvUploadModal" tabindex="-1" aria-labelledby="productCsvUploadLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content csv-modal">
            <div class="modal-header csv-modal-header">
                <div class="csv-modal-title-group">
                    <div class="csv-modal-icon">CSV</div>
                    <div>
                        <h5 class="modal-title" id="productCsvUploadLabel">Import Products from CSV</h5>
                        <p class="csv-modal-subtitle">Upload a CSV file to add products in bulk.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productCsvUploadForm" action="{{ route('product.import-csv') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="csv-upload-card">
                        <label for="product-csv-file" class="form-label">CSV File</label>
                        <input type="file" class="form-control csv-input" id="product-csv-file" name="csv_file"
                            accept=".csv" required>
                        <div class="csv-help-block">
                            <div class="csv-help-title">Required</div>
                            <div class="csv-help-list">
                                <span class="csv-chip">subcategory_name</span>
                                <span class="csv-chip">condition_name</span>
                                <span class="csv-chip">name</span>
                                <span class="csv-chip">price</span>
                                <span class="csv-chip">sku</span>
                                <span class="csv-chip">description</span>
                                <span class="csv-chip">discount_price</span>
                                <span class="csv-chip">stock</span>
                                <span class="csv-chip">old_price</span>
                                <span class="csv-chip">is_featured</span>
                                <span class="csv-chip">status</span>
                                <span class="csv-chip">storage</span>
                                <span class="csv-chip">colors</span>
                                <span class="csv-chip">protection_services</span>
                                <span class="csv-chip">accessories</span>
                                <span class="csv-chip">thumbnail_url</span>
                                <span class="csv-chip">gallery_urls</span>
                            </div>
                        </div>
                        <div class="csv-help-note">Use <code>|</code> to separate multiple values.</div>
                    </div>
                </div>
                <div class="modal-footer csv-modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                        id="productCsvCancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary csv-upload-btn" id="productCsvSubmitBtn">
                        <span class="csv-upload-text">Upload</span>
                        <span class="csv-upload-spinner d-none">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Uploading...
                        </span>
                    </button>
                </div>
            </form>
            <div class="csv-upload-overlay d-none">
                <div class="csv-upload-overlay-content">
                    <div class="csv-rainbow-spinner mb-3" role="status" aria-hidden="true"></div>
                    <div class="csv-upload-title">Uploading CSV</div>
                    <div class="csv-upload-subtitle">Please wait while we process your file...</div>
                </div>
            </div>
        </div>
    </div>
</div>
