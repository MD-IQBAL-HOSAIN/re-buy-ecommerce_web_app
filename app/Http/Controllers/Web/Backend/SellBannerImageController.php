<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\SellBannerImage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SellBannerImageController extends Controller
{
    protected $sellBannerImage;

    public function __construct(SellBannerImage $sellBannerImage)
    {
        $this->sellBannerImage = $sellBannerImage;
    }

    /**
     * Display a listing of banner images.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->sellBannerImage->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $image = $data->image ? asset($data->image) : asset('frontend/no-image.jpg');
                    return '<img src="' . $image . '" width="80" alt="Banner Image"/>';
                })
                ->addColumn('created', function ($data) {
                    return $data->created_at ? $data->created_at->format('d M, Y') : 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('sell-banner-image.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('sell-banner-image.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make();
        }

        return view('backend.layout.sell-banner-image.index');
    }

    /**
     * Show the form for creating banner images.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backend.layout.sell-banner-image.create');
    }

    /**
     * Store banner images (up to 4 at once).
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'image_one' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_two' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_three' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                'image_four' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $files = [
                $request->file('image_one'),
                $request->file('image_two'),
                $request->file('image_three'),
                $request->file('image_four'),
            ];

            foreach ($files as $image) {
                if (! $image) {
                    continue;
                }

                $imagePath = fileUpload_old($image, 'banner-images', time() . '_' . $image->getClientOriginalName());
                if ($imagePath !== null) {
                    $this->sellBannerImage->create([
                        'image' => $imagePath,
                    ]);
                }
            }

            return redirect()->route('sell-banner-image.index')->with('t-success', 'Banner images added successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a banner image.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $data = $this->sellBannerImage->findOrFail($id);
        return view('backend.layout.sell-banner-image.edit', compact('data'));
    }

    /**
     * Update a banner image.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->sellBannerImage->findOrFail($id);

            if ($request->hasFile('image')) {
                if ($data->image && file_exists(public_path($data->image))) {
                    fileDelete(public_path($data->image));
                }

                $imagePath = fileUpload_old($request->file('image'), 'banner-images', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->image = $imagePath;
                }
            }

            $data->save();

            return redirect()->route('sell-banner-image.index')->with('t-success', 'Banner image updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified banner image.
     *
     * @param int $id
     * @return View
     */
    public function show($id): View
    {
        $data = $this->sellBannerImage->findOrFail($id);
        return view('backend.layout.sell-banner-image.show', compact('data'));
    }

    /**
     * Remove the specified banner image.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = $this->sellBannerImage->findOrFail($id);

            if ($data->image && file_exists(public_path($data->image))) {
                fileDelete(public_path($data->image));
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the data. ' . $e->getMessage(),
            ]);
        }
    }
}
