<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Language;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class DynamicPageController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = Language::where('status', 'active')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @SuppressWarnings("unused")
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Page::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('page_title', function ($data) {
                    $page_title = $data->page_title;
                    return $page_title;
                })
                ->addColumn('page_content', function ($data) {
                    $page_content = $data->page_content;
                    return $page_content;
                })

                ->addColumn('status', function ($data) {
                    $backgroundColor  = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('dynamic.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                     <i class="mdi mdi-pencil"></i>
                                </a>
                                 <a href="' . route('dynamic.show', ['id' => $data->id]) . '" type="button" class="btn btn-warning fs-14 text-white edit-icn" title="show">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })


                ->rawColumns(['page_title', 'page_content', 'status', 'action'])
                ->make();
        }

        return view('backend.layout.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response     *
     */
    public function create(): View
    {
        $languages = $this->languages;
        return view('backend.layout.pages.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|exists:languages,id',
                'page_title' => 'required|string|max:1000',
                'page_content' => 'required|string|max:50000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = new Page();
            $data->language_id = $request->language_id;
            $data->page_title = $request->page_title;
            $data->page_content = $request->page_content;
            $data->save();

            return redirect()->route('dynamic.index')->with('t-success', 'Created Successfully !!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong!' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $data = Page::findOrFail($id);
        $languages = $this->languages;
        return view('backend.layout.pages.edit', compact('data', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|exists:languages,id',
                'page_title' => 'required|string|max:1000',
                'page_content' => 'required|string|max:50000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = Page::findOrFail($id);
            $data->language_id = $request->language_id;
            $data->page_title = $request->page_title;
            $data->page_content = $request->page_content;
            $data->save();

            return redirect()->route('dynamic.index')->with('t-success', 'Updated Successfully.');
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('t-error', 'Something went wrong!');
        }
    }

    /**
     * Update the status of the specified dynamic page.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        $data = Page::findOrFail($id);
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
     * This function is used to show the details of a dynamic page.
     *
     * @param int $id The ID of the dynamic page to show.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = Page::findOrFail($id);
        return view('backend.layout.pages.show', compact('data'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = Page::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Data.',
            ]);
        }
    }
}
