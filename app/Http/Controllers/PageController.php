<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     *  @var Page
     */
    protected $page;
    protected $languages;

    public function __construct(Page $page)
    {
        $this->page = $page;
        $this->languages = Language::where('status', 'active')->get();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->page->latest()->get();
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
                                <a href="' . route('backend.page.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>
                                 <a href="' . route('backend.page.show', ['id' => $data->id]) . '" type="button" class="btn btn-warning fs-14 text-white edit-icn" title="show">
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
     */
    public function create()
    {
        $data = $this->page;
        $languages = $this->languages;
        return view('backend.layout.pages.create',compact('data', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|integer',
                'page_title' => 'required|string|max:255',
                'page_content' => 'required|string|max:2000',
            ]);
            // dd($validator->errors());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->page->newInstance();
            $data->language_id = $request->language_id;
            $data->page_title = $request->page_title;
            $data->page_content = $request->page_content;
            $data->save();

            return redirect()->route('backend.page.index')->with('t-success', 'Created Successfully !!');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $languages = $this->languages;
        return view('backend.layout.pages.edit', ['page' => $page, 'languages' => $languages]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|integer',
                'page_title' => 'required|string|max:255',
                'page_content' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            
            $page->language_id = $request->language_id;
            $page->page_title = $request->page_title;
            $page->page_content = $request->page_content;
            $page->save();

            return redirect()->route('backend.page.index')->with('t-success', 'Updated Successfully.');
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->with('t-error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        try {

            $page->delete();

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

    public function status(int $id): JsonResponse
    {
        $data = Page::findOrFail($id);

        $data->status = !$data->status;
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Status Chaned Successfully.',
            'data'    => $data,
        ]);
    }
}
