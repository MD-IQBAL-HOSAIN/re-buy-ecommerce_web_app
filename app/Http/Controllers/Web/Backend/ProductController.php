<?php
namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Accessory;
use App\Models\BuyCategory;
use App\Models\BuySubcategory;
use App\Models\Color;
use App\Models\Condition;
use App\Models\Product;
use App\Models\ProtectionService;
use App\Models\Storage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of content.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->product->with('buySubcategory.buyCategory')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('bulk', function ($data) {
                    return '<input type="checkbox" class="form-check-input product-select" value="' . $data->id . '">';
                })

                ->addColumn('category', function ($data) {
                    return $data->buySubcategory->buyCategory->name ?? 'N/A';
                })

                ->addColumn('subcategory', function ($data) {
                    return $data->buySubcategory->name ?? 'N/A';
                })

                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })

                ->addColumn('price', function ($data) {
                    $price = '£ ' . number_format($data->price, 2);
                    if ($data->discount_price) {
                        $price .= ' <del class="text-muted">£ ' . number_format($data->discount_price, 2) . '</del>';
                    }
                    return $price;
                })
                ->addColumn('discount_price', function ($data) {
                    return $data->discount_price ? '£ ' . number_format($data->discount_price, 2) : 'N/A';
                })

                ->addColumn('thumbnail', function ($data) {
                    if ($data->thumbnail) {
                        $thumbnail = str_starts_with($data->thumbnail, 'http://') || str_starts_with($data->thumbnail, 'https://')
                            ? $data->thumbnail
                            : asset($data->thumbnail);
                    } else {
                        $thumbnail = asset('frontend/no-image.jpg');
                    }
                    return '<img src="' . $thumbnail . '" width="60" alt="Product Image"/>';
                })

                ->addColumn('status', function ($data) {
                    $backgroundColor  = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status  = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('product.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('product.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['bulk', 'category', 'subcategory', 'name', 'price', 'discount_price', 'thumbnail', 'status', 'action'])
                ->make();
        }
        return view("backend.layout.product.index");
    }

    /**
     * Get shared form data for create and edit views.
     *
     * @return array
     */
    private function getFormData(): array
    {
        return [
            'categories'         => BuyCategory::where('status', 'active')->get(),
            'subcategories'      => BuySubcategory::with('buyCategory')->where('status', 'active')->get(),
            'colors'             => Color::all(),
            'conditions'         => Condition::all(),
            'storages'           => Storage::all(),
            'protectionServices' => ProtectionService::all(),
            'accessories'        => Accessory::all(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view("backend.layout.product.create", $this->getFormData());
    }

    /**
     * Get subcategories by category ID (AJAX).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSubcategories(Request $request): JsonResponse
    {
        $categoryId    = $request->category_id;
        $subcategories = BuySubcategory::where('buy_category_id', $categoryId)
            ->where('status', 'active')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            $data                     = $this->product->newInstance();
            $data->buy_subcategory_id = $request->buy_subcategory_id;
            $data->condition_id       = $request->condition_id;
            $data->name               = $request->name;
            $data->slug               = Str::slug($request->name);
            $data->sku                = $request->sku;
            $data->description        = $request->description;
            $data->price              = $request->price;
            $data->discount_price     = $request->discount_price;
            $data->stock              = $request->stock ?? 0;
            $data->old_price          = $request->old_price;
            $data->is_featured        = $request->has('is_featured') ? 1 : 0;

            if ($request->hasFile('image')) {
                $imagePath = fileUpload_old($request->file('image'), 'products', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->thumbnail = $imagePath;
                }
            }

            $data->save();

            // Attach Colors
            if ($request->has('colors') && is_array($request->colors)) {
                $data->colors()->attach($request->colors);
            }

            // Attach Storage (single selection via pivot)
            if ($request->filled('storage_id')) {
                $data->storages()->attach($request->storage_id);
            }

            // Attach Protection Services
            if ($request->has('protection_services') && is_array($request->protection_services)) {
                $data->protectionServices()->attach($request->protection_services);
            }

            // Attach Accessories
            if ($request->has('accessories') && is_array($request->accessories)) {
                $data->accessories()->attach($request->accessories);
            }

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = fileUpload_old($image, 'products/gallery', time() . '_' . $image->getClientOriginalName());
                    if ($imagePath !== null) {
                        $data->images()->create(['image' => $imagePath]);
                    }
                }
            }

            return redirect()->route('product.index')->with('t-success', 'Created Successfully !!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong!' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = $this->product->with(['colors', 'storages', 'protectionServices', 'accessories', 'images', 'buySubcategory.buyCategory'])->findOrFail($id);

        return view("backend.layout.product.edit", array_merge(
            ['data' => $data],
            $this->getFormData()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProductRequest $request, $id): RedirectResponse
    {
        try {
            $data = $this->product->findOrFail($id);

            $data->buy_subcategory_id = $request->buy_subcategory_id ?? $data->buy_subcategory_id;
            $data->condition_id       = $request->condition_id;
            $data->name               = $request->name ?? $data->name;
            $data->slug               = Str::slug($request->name ?? $data->name);
            $data->description        = $request->description ?? $data->description;
            $data->price              = $request->price ?? $data->price;
            $data->discount_price     = $request->discount_price;
            $data->stock              = $request->stock ?? $data->stock;
            $data->old_price          = $request->old_price ?? $data->old_price;
            $data->is_featured        = $request->has('is_featured') ? 1 : 0;

            if ($request->hasFile('image')) {
                if ($data->thumbnail !== null) {
                    fileDelete(public_path($data->thumbnail));
                }

                $imagePath = fileUpload_old($request->file('image'), 'products', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->thumbnail = $imagePath;
                }
            }

            $data->save();

            // Sync Colors
            if ($request->has('colors') && is_array($request->colors)) {
                $data->colors()->sync($request->colors);
            } else {
                $data->colors()->detach();
            }

            // Sync Storage (single selection via pivot)
            if ($request->filled('storage_id')) {
                $data->storages()->sync([$request->storage_id]);
            } else {
                $data->storages()->detach();
            }

            // Sync Protection Services
            if ($request->has('protection_services') && is_array($request->protection_services)) {
                $data->protectionServices()->sync($request->protection_services);
            } else {
                $data->protectionServices()->detach();
            }

            // Sync Accessories
            if ($request->has('accessories') && is_array($request->accessories)) {
                $data->accessories()->sync($request->accessories);
            } else {
                $data->accessories()->detach();
            }

            // Handle multiple images - Delete old images and add new ones
            if ($request->hasFile('images')) {
                // Delete old gallery images
                foreach ($data->images as $oldImage) {
                    if ($oldImage->image && file_exists(public_path($oldImage->image))) {
                        fileDelete(public_path($oldImage->image));
                    }
                    $oldImage->delete();
                }

                // Upload new images
                foreach ($request->file('images') as $image) {
                    $imagePath = fileUpload_old($image, 'products/gallery', time() . '_' . $image->getClientOriginalName());
                    if ($imagePath !== null) {
                        $data->images()->create(['image' => $imagePath]);
                    }
                }
            }

            return redirect()->route('product.index')->with('t-success', 'Updated Successfully!!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong!' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = $this->product->with([
            'buySubcategory.buyCategory',
            'condition',
            'colors',
            'storages',
            'protectionServices',
            'accessories',
            'images',
        ])->findOrFail($id);
        return view('backend.layout.product.show', compact('data'));
    }

    /**
     * Update the status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        $data = $this->product->findOrFail($id);
        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = $this->product->with('images')->findOrFail($id);

            $this->deleteProduct($data);

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Data. ' . $e->getMessage(),
            ]);
        }
    }

    /*
     ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===
    *  Import Products from CSV File
     ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===
     */

    /**
     * Import products from a CSV file.
     *
     * Expected columns:
     * category_name, subcategory_name, condition_name, name, price,
     * discount_price, stock, old_price, is_featured, status, sku, description,
     * storage, colors, protection_services, accessories, thumbnail_url, gallery_urls
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function importCsv(Request $request): RedirectResponse
    {
        // 1) Upload validation (file type + size)
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file   = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // 2) Stop if file can't be opened
        if ($handle === false) {
            return redirect()->back()->with('t-error', 'Unable to read the CSV file.');
        }

        // 3) Read header row
        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return redirect()->back()->with('t-error', 'CSV header row is missing.');
        }

        $headerMap = [];
        foreach ($header as $index => $column) {
            // Normalize header names (handle UTF-8 BOM, spaces, dashes)
            $cleanColumn = preg_replace('/^\xEF\xBB\xBF/', '', (string) $column);
            $key         = Str::of($cleanColumn)->lower()->trim()->replace(' ', '_')->replace('-', '_')->__toString();
            if ($key !== '') {
                $headerMap[$key] = $index;
            }
        }

        // 4) Check required columns
        $requiredColumns = ['subcategory_name', 'condition_name', 'name', 'price'];
        foreach ($requiredColumns as $requiredColumn) {
            if (! array_key_exists($requiredColumn, $headerMap)) {
                fclose($handle);
                return redirect()->back()->with('t-error', "Missing required column: {$requiredColumn}");
            }
        }

        // 5) Load reference data once for name -> id mapping
        $categories         = BuyCategory::all();
        $subcategories      = BuySubcategory::with('buyCategory')->get();
        $conditions         = Condition::all();
        $storages           = Storage::all();
        $colors             = Color::all();
        $protectionServices = ProtectionService::all();
        $accessories        = Accessory::all();

        // Helper: get a column value by key
        $getValue = function (array $row, string $key) use ($headerMap) {
            if (! array_key_exists($key, $headerMap)) {
                return null;
            }
            return isset($row[$headerMap[$key]]) ? trim((string) $row[$headerMap[$key]]) : null;
        };

        // Helper: get the first non-empty value among alternative keys
        $getFirstValue = function (array $row, array $keys) use ($getValue) {
            foreach ($keys as $key) {
                $value = $getValue($row, $key);
                if ($value !== null && $value !== '') {
                    return $value;
                }
            }
            return null;
        };

        // 6) Build fast lookup tables (case-insensitive)
        $categoryLookup = [];
        foreach ($categories as $category) {
            $categoryLookup[Str::lower(trim($category->name))] = $category->id;
        }

        $subcategoryLookupByName     = [];
        $subcategoryLookupByCategory = [];
        foreach ($subcategories as $subcategory) {
            $subcategoryKey                             = Str::lower(trim($subcategory->name));
            $subcategoryLookupByName[$subcategoryKey][] = $subcategory->id;

            // Also map subcategory by category to avoid duplicate name issues
            if ($subcategory->buy_category_id) {
                $subcategoryLookupByCategory[$subcategory->buy_category_id][$subcategoryKey] = $subcategory->id;
            }
        }

        $conditionLookup = [];
        foreach ($conditions as $condition) {
            $conditionLookup[Str::lower(trim($condition->name))] = $condition->id;
        }

        // Storage lookup supports "name" and "capacity + name"
        $storageLookup = [];
        foreach ($storages as $storage) {
            $nameKey                 = Str::lower(trim($storage->name));
            $storageLookup[$nameKey] = $storage->id;
            $capacityKey             = Str::lower(trim((string) $storage->capacity));
            if ($capacityKey !== '') {
                $combined                             = trim($capacityKey . ' ' . $storage->name);
                $storageLookup[Str::lower($combined)] = $storage->id;
            }
        }

        $colorLookup = [];
        foreach ($colors as $color) {
            $colorLookup[Str::lower(trim($color->name))] = $color->id;
        }

        $protectionLookup = [];
        foreach ($protectionServices as $service) {
            $protectionLookup[Str::lower(trim($service->name))] = $service->id;
        }

        $accessoryLookup = [];
        foreach ($accessories as $accessory) {
            $accessoryLookup[Str::lower(trim($accessory->name))] = $accessory->id;
        }

        // Helper: split pipe-delimited list into array
        $parseList = function (?string $value): array {
            if ($value === null || trim($value) === '') {
                return [];
            }
            $parts   = preg_split('/\s*\|\s*/', $value);
            $results = [];
            foreach ($parts as $part) {
                $part = trim((string) $part);
                if ($part !== '') {
                    $results[] = $part;
                }
            }
            return $results;
        };

        // 7) Process rows and track result counts
        $inserted    = 0;
        $skipped     = 0;
        $rowNumber   = 1;
        $skipReasons = [];
        $rowErrors   = [];

        // 8) Read each row
        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            // Skip empty lines
            $hasData = false;
            foreach ($row as $value) {
                if (trim((string) $value) !== '') {
                    $hasData = true;
                    break;
                }
            }
            if (! $hasData) {
                continue;
            }

            // 9) Required fields
            $categoryName    = $getFirstValue($row, ['category_name', 'buy_category_name']);
            $subcategoryName = $getFirstValue($row, ['subcategory_name', 'buy_subcategory_name']);
            $conditionName   = $getFirstValue($row, ['condition_name']);
            $name            = $getValue($row, 'name');
            $price           = $getValue($row, 'price');

            if ($subcategoryName === null || $conditionName === null || $name === null || $price === null) {
                $skipped++;
                $skipReasons['missing_required'] = ($skipReasons['missing_required'] ?? 0) + 1;
                if (count($rowErrors) < 10) {
                    $rowErrors[] = "Row {$rowNumber}: Missing required fields (subcategory_name, condition_name, name, price).";
                }
                $skipped++;
                continue;
            }

            // 10) Resolve names -> IDs (category optional)
            $categoryId = null;
            if ($categoryName !== null) {
                $categoryKey = Str::lower(trim($categoryName));
                $categoryId  = $categoryLookup[$categoryKey] ?? null;
                if ($categoryId === null) {
                    $skipped++;
                    $skipReasons['category_not_found'] = ($skipReasons['category_not_found'] ?? 0) + 1;
                    if (count($rowErrors) < 10) {
                        $rowErrors[] = "Row {$rowNumber}: Category not found ({$categoryName}).";
                    }
                    $skipped++;
                    continue;
                }
            }

            $subcategoryKey   = Str::lower(trim($subcategoryName));
            $buySubcategoryId = null;
            if ($categoryId !== null) {
                $buySubcategoryId = $subcategoryLookupByCategory[$categoryId][$subcategoryKey] ?? null;
            } else {
                $candidateIds = $subcategoryLookupByName[$subcategoryKey] ?? [];
                if (count($candidateIds) === 1) {
                    $buySubcategoryId = $candidateIds[0];
                }
            }

            $conditionKey = Str::lower(trim($conditionName));
            $conditionId  = $conditionLookup[$conditionKey] ?? null;

            // Skip if name -> id matching fails
            if ($buySubcategoryId === null || $conditionId === null) {
                $skipped++;
                if ($buySubcategoryId === null) {
                    $skipReasons['subcategory_not_found'] = ($skipReasons['subcategory_not_found'] ?? 0) + 1;
                    if (count($rowErrors) < 10) {
                        $rowErrors[] = "Row {$rowNumber}: Subcategory not found ({$subcategoryName}).";
                    }
                }
                if ($conditionId === null) {
                    $skipReasons['condition_not_found'] = ($skipReasons['condition_not_found'] ?? 0) + 1;
                    if (count($rowErrors) < 10) {
                        $rowErrors[] = "Row {$rowNumber}: Condition not found ({$conditionName}).";
                    }
                }
                $skipped++;
                continue;
            }

            // 11) Optional fields
            $sku            = $getValue($row, 'sku');
            $description    = $getValue($row, 'description');
            $discountPrice  = $getValue($row, 'discount_price');
            $stock          = $getValue($row, 'stock');
            $oldPrice       = $getValue($row, 'old_price');
            $isFeaturedRaw  = $getValue($row, 'is_featured');
            $statusRaw      = $getValue($row, 'status');
            $storageRaw     = $getFirstValue($row, ['storage', 'storage_name']);
            $colorsRaw      = $getFirstValue($row, ['colors', 'color_names']);
            $protectionRaw  = $getFirstValue($row, ['protection_services', 'protection_service_names']);
            $accessoriesRaw = $getFirstValue($row, ['accessories', 'accessory_names']);
            $thumbnailUrl   = $getFirstValue($row, ['thumbnail_url', 'thumbnail']);
            $galleryUrlsRaw = $getFirstValue($row, ['gallery_urls', 'gallery_images']);

            // Normalize flags/status
            $isFeatured = filter_var($isFeaturedRaw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $status     = in_array($statusRaw, ['active', 'inactive'], true) ? $statusRaw : 'active';
            $storageId  = null;
            if ($storageRaw !== null) {
                $storageKey = Str::lower(trim($storageRaw));
                $storageId  = $storageLookup[$storageKey] ?? null;
            }

            try {
                // 12) Create the product record
                $data                     = $this->product->newInstance();
                $data->buy_subcategory_id = (int) $buySubcategoryId;
                $data->condition_id       = (int) $conditionId;
                $data->name               = $name;
                $data->slug               = Str::slug($name);
                $data->sku                = $sku ?: null;
                $data->description        = $description;
                $data->price              = (float) $price;
                $data->discount_price     = $discountPrice !== null && $discountPrice !== '' ? (float) $discountPrice : null;
                $data->stock              = $stock !== null && $stock !== '' ? (int) $stock : 0;
                $data->old_price          = $oldPrice !== null && $oldPrice !== '' ? (float) $oldPrice : null;
                $data->is_featured        = $isFeatured === null ? 0 : (int) $isFeatured;
                $data->status             = $status;
                $data->save();

                // 13) Thumbnail (local path or URL)
                if ($thumbnailUrl !== null && $thumbnailUrl !== '') {
                    $thumbnailPath = $this->resolveImagePath($thumbnailUrl, 'products', $name);
                    if ($thumbnailPath !== null) {
                        $data->thumbnail = $thumbnailPath;
                        $data->save();
                    }
                }

                // 14) Gallery images (pipe-delimited list)
                $galleryUrls = $parseList($galleryUrlsRaw);
                if (! empty($galleryUrls)) {
                    foreach ($galleryUrls as $galleryUrl) {
                        $galleryPath = $this->resolveImagePath($galleryUrl, 'products/gallery', $name);
                        if ($galleryPath !== null) {
                            $data->images()->create(['image' => $galleryPath]);
                        }
                    }
                }

                // 15) Relations
                $colorNames = $parseList($colorsRaw);
                if (! empty($colorNames)) {
                    $colorIds = [];
                    foreach ($colorNames as $colorName) {
                        $colorKey = Str::lower(trim($colorName));
                        if (isset($colorLookup[$colorKey])) {
                            $colorIds[] = $colorLookup[$colorKey];
                        }
                    }
                    if (! empty($colorIds)) {
                        $data->colors()->attach($colorIds);
                    }
                }

                // Storage (single)
                if ($storageId !== null) {
                    $data->storages()->attach($storageId);
                }

                // Protection services (multiple)
                $protectionNames = $parseList($protectionRaw);
                if (! empty($protectionNames)) {
                    $protectionIds = [];
                    foreach ($protectionNames as $protectionName) {
                        $protectionKey = Str::lower(trim($protectionName));
                        if (isset($protectionLookup[$protectionKey])) {
                            $protectionIds[] = $protectionLookup[$protectionKey];
                        }
                    }
                    if (! empty($protectionIds)) {
                        $data->protectionServices()->attach($protectionIds);
                    }
                }

                // Accessories (multiple)
                $accessoryNames = $parseList($accessoriesRaw);
                if (! empty($accessoryNames)) {
                    $accessoryIds = [];
                    foreach ($accessoryNames as $accessoryName) {
                        $accessoryKey = Str::lower(trim($accessoryName));
                        if (isset($accessoryLookup[$accessoryKey])) {
                            $accessoryIds[] = $accessoryLookup[$accessoryKey];
                        }
                    }
                    if (! empty($accessoryIds)) {
                        $data->accessories()->attach($accessoryIds);
                    }
                }

                // Count success
                $inserted++;
            } catch (Exception $e) {
                $skipReasons['exception'] = ($skipReasons['exception'] ?? 0) + 1;
                if (count($rowErrors) < 10) {
                    $rowErrors[] = "Row {$rowNumber}: Exception while saving (maybe duplicate SKU or invalid data).";
                }
                // Any error => skip this row
                $skipped++;
            }
        }

        fclose($handle);

        // If nothing inserted, show error with reasons
        if ($inserted === 0) {
            $reasonSummary = [];
            foreach ($skipReasons as $reason => $count) {
                $reasonSummary[] = "{$reason}: {$count}";
            }
            $summaryText = ! empty($reasonSummary) ? (' Reasons: ' . implode(', ', $reasonSummary) . '.') : '';
            $detailsText = ! empty($rowErrors) ? (' Details: ' . implode(' ', $rowErrors)) : '';
            return redirect()->back()->with('t-error', 'No valid rows found to import.' . $summaryText . $detailsText);
        }

        // Build final message
        $message = "Imported {$inserted} products.";
        if ($skipped > 0) {
            $message .= " Skipped {$skipped} rows due to missing or invalid data.";
        }

        return redirect()->back()->with('t-success', $message);
    }

    /**
     * Download an image from a URL and save it in the public uploads folder.
     *
     * @param string $url
     * @param string $folder
     * @param string $namePrefix
     * @return string|null
     */
    private function resolveImagePath(string $pathOrUrl, string $folder, string $namePrefix): ?string
    {
        $trimmed = trim($pathOrUrl);
        if ($trimmed === '') {
            return null;
        }

        $isRemoteImageUrl = function (string $value): bool {
            return str_starts_with($value, 'http://') || str_starts_with($value, 'https://');
        };

        $isLocalImagePath = function (string $path): bool {
            return str_starts_with($path, 'uploads/') || str_starts_with($path, '/uploads/');
        };

        if ($isRemoteImageUrl($trimmed)) {
            // Keep remote URL as-is (do not download/store locally).
            return $trimmed;
        }

        if ($isLocalImagePath($trimmed)) {
            return ltrim($trimmed, '/');
        }

        return null;
    }


    /**
     * Bulk delete products.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No products selected.',
            ], 422);
        }

        $products = $this->product->with('images')->whereIn('id', $ids)->get();

        foreach ($products as $product) {
            $this->deleteProduct($product);
        }

        return response()->json([
            'success' => true,
            'message' => 'Selected products deleted successfully.',
        ]);
    }

    /**
     * Delete a product and its related assets.
     *
     * @param Product $data
     * @return void
     */
    private function deleteProduct(Product $data): void
    {
        // Delete the thumbnail file from storage if it exists
        if ($data->thumbnail && file_exists(public_path($data->thumbnail))) {
            fileDelete(public_path($data->thumbnail));
        }

        // Delete all gallery images
        foreach ($data->images as $image) {
            if ($image->image && file_exists(public_path($image->image))) {
                fileDelete(public_path($image->image));
            }
        }

        // Detach all relationships (cascade delete will handle pivot tables)
        $data->colors()->detach();
        $data->storages()->detach();
        $data->protectionServices()->detach();
        $data->accessories()->detach();

        $data->delete();
    }
}
