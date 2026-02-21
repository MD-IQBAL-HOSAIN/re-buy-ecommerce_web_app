<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Language;
use App\Models\TrustFeature;
use Illuminate\Http\Request;
use App\Models\CMS;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class TrustFeatureController extends Controller
{
    protected $trustFeature;
    protected $language;

    public function __construct(TrustFeature $trustFeature, Language $language)
    {
        $this->trustFeature = $trustFeature;
        $this->language = $language;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->trustFeature->select(['id', 'title', 'icon'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('icon', function ($data) {
                    // Check if icon is an image path or font-awesome class
                    if (str_contains($data->icon, 'fas') || str_contains($data->icon, 'far') || str_contains($data->icon, 'fab')) {
                        return '<i class="' . $data->icon . ' fa-2x"></i>';
                    }
                    $image = $data->icon ? asset($data->icon) : asset('frontend/no-image.jpg');
                    return '<img src="' . $image . '" width="60" alt="Icon"/>';
                })
                ->addColumn('title', function ($data) {
                    return $data->title ?? 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('trust-feature.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['icon', 'title', 'action'])
                ->make();
        }

        // Load languages and CMS for header (Assuming ID 11 for Trust Feature Header)
        $languages = Language::where('status', 'active')->get();
        // Ensure CMS record exists or fetch it
        $cms = CMS::find(11);
        if (!$cms) {
            $cms = CMS::create(['id' => 11, 'title' => 'Ihr Vertrauen ist unsere Priorität', 'slug' => 'trust-features']);
        }

        return view('backend.layout.trust-feature.index', compact('languages', 'cms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $languages = $this->language->where('status', 'active')->get();
        return view('backend.layout.trust-feature.create', compact('languages'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'icon' =>  'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            // Double check if it is file upload
            if ($request->hasFile('icon')) {
                $validator = Validator::make($request->all(), [
                    'icon' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
                ]);
            }

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->trustFeature->newInstance();
            $data->language_id = $request->language_id;
            $data->title = $request->title;

            // Handle Icon (Text Class or File Upload)
            if ($request->hasFile('icon')) {
                $imagePath = fileUpload_old($request->file('icon'), 'trust-feature', time() . '_' . $request->file('icon')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->icon = $imagePath;
                }
            } else {
                $data->icon = $request->icon;
            }

            $data->save();

            return redirect()->route('trust-feature.index')->with('t-success', 'Created Successfully !!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $item = $this->trustFeature->findOrFail($id);
        $languages = $this->language->where('status', 'active')->get();
        return view('backend.layout.trust-feature.edit', compact('item', 'languages'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $item = $this->trustFeature->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'language_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $item->language_id = $request->language_id;
            $item->title = $request->title;

            if ($request->hasFile('icon')) {
                if ($item->icon !== null) {
                    fileDelete(public_path($item->icon));
                }
                $imagePath = fileUpload_old($request->file('icon'), 'trust-feature', time() . '_' . $request->file('icon')->getClientOriginalName());
                if ($imagePath !== null) {
                    $item->icon = $imagePath;
                }
            }


            $item->save();

            return redirect()->route('trust-feature.index')->with('t-success', 'Updated Successfully!!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
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
            $data = $this->trustFeature->findOrFail($id);
            // Delete the image file from storage if it exists
            if ($data->icon && file_exists(public_path($data->icon))) {
                fileDelete(public_path($data->icon));
            }

            $data->delete();

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
}
