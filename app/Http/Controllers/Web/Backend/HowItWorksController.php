<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Language;
use App\Models\HowItWork;
use Illuminate\Http\Request;
use App\Models\SellElectronics;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class HowItWorksController extends Controller
{
    protected $howItWorks;
    protected $language;

    public function __construct(HowItWork $howItWorks, Language $language)
    {
        $this->howItWorks = $howItWorks;
        $this->language = $language;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->howItWorks->select(['id', 'title', 'subtitle', 'image'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    $image = $data->image ? asset($data->image) : asset('frontend/no-image.jpg');
                    return '<img src="' . $image . '" width="60" alt="Product Image"/>';
                })
                ->addColumn('title', function ($data) {
                    return $data->title ?? 'N/A';
                })
                ->addColumn('subtitle', function ($data) {
                    return $data->subtitle ?? 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('how-it-works.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('how-it-works.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['image', 'title', 'subtitle', 'action'])
                ->make();
        }

        // Load languages and CMS for header
        $languages = Language::where('status', 'active')->get();
        $cms = \App\Models\CMS::find(10);
        return view('backend.layout.how-it-works.index', compact('languages', 'cms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $languages = $this->language->where('status', 'active')->get();
        return view('backend.layout.how-it-works.create', compact('languages'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->howItWorks->newInstance();
            $data->language_id = $request->language_id;
            $data->title = $request->title;
            $data->subtitle = $request->subtitle;

            if ($request->hasFile('image')) {
                $imagePath = fileUpload_old($request->file('image'), 'how-it-works', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $data->image = $imagePath;
                }
            }
            $data->save();

            return redirect()->route('how-it-works.index')->with('t-success', 'Created Successfully !!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $item = $this->howItWorks->findOrFail($id);
        $languages = $this->language->where('status', 'active')->get();
        return view('backend.layout.how-it-works.edit', compact('item', 'languages'));
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
            $item = $this->howItWorks->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'language_id' => 'required|integer',
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $item->language_id = $request->language_id;
            $item->title = $request->title;
            $item->subtitle = $request->subtitle;

            if ($request->hasFile('image')) {
                if ($item->image !== null) {
                    fileDelete(public_path($item->image));
                }
                $imagePath = fileUpload_old($request->file('image'), 'how-it-works', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $item->image = $imagePath;
                }
            }


            $item->save();

            return redirect()->route('how-it-works.index')->with('t-success', 'Updated Successfully!!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $item = $this->howItWorks->findOrFail($id);
        $languages = $this->language->where('status', 'active')->get();
        return view('backend.layout.how-it-works.show', compact('item', 'languages'));
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
            $data = $this->howItWorks->findOrFail($id);
            // Delete the image file from storage if it exists
            if ($data->image && file_exists(public_path($data->image))) {
                fileDelete(public_path($data->image));
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
