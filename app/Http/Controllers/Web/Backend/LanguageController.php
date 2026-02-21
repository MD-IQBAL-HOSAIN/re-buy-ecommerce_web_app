<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LanguageStoreRequest;
use App\Http\Requests\LanguageUpdateRequest;

class LanguageController extends Controller
{
    protected $language;

    public function __construct(\App\Models\Language $language)
    {
        $this->language = $language;
    }

    /**
     * Display a listing of dynamic page content.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */

    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {

            // Fetch all language records
            $data = $this->language->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('code', function ($data) {
                    return $data->code;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
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
                                <a href="' . route('language.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                                </a>

                            </div>';
                })
                ->rawColumns(['code', 'name', 'status', 'action'])
                ->make();
        }
        return view('backend.layout.language.index');
    }
//language remove action button
     /*  <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
     </a> */


    /**
     * Show the form for creating a new language.
     *
     * @return View
     */
    public function create(): View
    {
        return view('backend.layout.language.create');
    }



    /**
     * Store a newly created language in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(LanguageStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $this->language->create($data);
            return redirect()->route('language.index')->with('t-success', 'Language created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Language creation failed! Error: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified language Edit.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $data = $this->language->find($id);
        return view('backend.layout.language.edit', compact('data'));
    }


    /**
     * Update the specified language in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(LanguageUpdateRequest $request, $id)
    {
        try {
            $this->language->find($id)->update($request->validated());

            return redirect()->route('language.index')->with('t-success', 'Language updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Language update failed! Error: ' . $e->getMessage());
        }
    }



    /**
     * Change the status of the specified language Content.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        $data = $this->language->findOrFail($id);
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
     * Remove the specified language from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data =  $this->language->findOrFail($id);
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
