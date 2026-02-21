<?php
namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\BuySubcategory;
use App\Models\Language;
use App\Models\SellProduct;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SellProductController extends Controller
{
    protected $sellProduct;
    protected $languages;
    protected $buySubcategories;

    public function __construct(SellProduct $sellProduct)
    {
        $this->sellProduct      = $sellProduct;
        $this->languages        = Language::where('status', 'active')->get();
        $this->buySubcategories = BuySubcategory::all();
    }

    /**
     * Display a listing of sell products.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->sellProduct->with(['language', 'buySubcategory'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $image = $data->image ? asset($data->image) : asset('frontend/no-image.jpg');
                    return '<img src="' . $image . '" width="60" alt="Product Image"/>';
                })
                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })
                ->addColumn('short_name', function ($data) {
                    return $data->short_name ?? 'N/A';
                })
                ->addColumn('language', function ($data) {
                    return $data->language?->name ?? 'N/A';
                })
                ->addColumn('subcategory', function ($data) {
                    return $data->buySubcategory?->name ?? 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('sell-products.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('sell-products.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['image', 'name', 'short_name', 'language', 'subcategory', 'action'])
                ->make();
        }
        return view('backend.layout.sell-products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $languages     = $this->languages;
        $subcategories = $this->buySubcategories;
        return view('backend.layout.sell-products.create', compact('languages', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id'        => 'required|integer',
                'buy_subcategory_id' => 'required|integer',
                'name'               => 'required|string|max:255',
                'short_name'         => 'nullable|string|max:255',
                // 'description'        => 'nullable|string|max:5000',
                'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data                     = $this->sellProduct->newInstance();
            $data->language_id        = $request->language_id;
            $data->buy_subcategory_id = $request->buy_subcategory_id;
            $data->name               = $request->name;
            $data->short_name         = $request->short_name;
            $data->slug               = Str::slug($request->name);
            // $data->description        = $request->description;

            if ($request->hasFile('image')) {
                $imagePath = fileUpload_old($request->file('image'), 'sell-products', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->image = $imagePath;
                }
            }

            $data->save();

            return redirect()->route('sell-products.index')->with('t-success', 'Sell Product Created Successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $data          = $this->sellProduct->findOrFail($id);
        $languages     = $this->languages;
        $subcategories = $this->buySubcategories;
        return view('backend.layout.sell-products.edit', compact('data', 'languages', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id'        => 'required|integer',
                'buy_subcategory_id' => 'required|integer',
                'name'               => 'required|string|max:255',
                'short_name'         => 'nullable|string|max:255',
                // 'description'        => 'nullable|string|max:5000',
                'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data                     = $this->sellProduct->findOrFail($id);
            $data->language_id        = $request->language_id;
            $data->buy_subcategory_id = $request->buy_subcategory_id;
            $data->name               = $request->name;
            $data->short_name         = $request->short_name;
            $data->slug               = Str::slug($request->name);
            // $data->description        = $request->description;

            if ($request->hasFile('image')) {
                if ($data->image !== null) {
                    fileDelete(public_path($data->image));
                }
                $imagePath = fileUpload_old($request->file('image'), 'sell-products', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->image = $imagePath;
                }
            }

            $data->save();

            return redirect()->route('sell-products.index')->with('t-success', 'Sell Product Updated Successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show($id): View
    {
        $data = $this->sellProduct->findOrFail($id);
        return view('backend.layout.sell-products.show', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $data = $this->sellProduct->findOrFail($id);
            if ($data->image && file_exists(public_path($data->image))) {
                fileDelete(public_path($data->image));
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $e->getMessage(),
            ]);
        }
    }
}
