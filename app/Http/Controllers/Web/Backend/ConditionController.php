<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Language;
use App\Models\Condition;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ConditionController extends Controller
{
    protected $condition;
    protected $languages;

    public function __construct(Condition $condition)
    {
        $this->condition = $condition;
        $this->languages = Language::where('status', 'active')->get();
    }

    /**
     * Display a listing of conditions.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->condition->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('condition.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('condition.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['name', 'action'])
                ->make();
        }
        return view("backend.layout.condition.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $languages = $this->languages;
        return view("backend.layout.condition.create", compact('languages'));
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
                'name' => 'required|string|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->condition->newInstance();
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->save();

            return redirect()->route('condition.index')->with('t-success', 'Condition Created Successfully !!');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong! ' . $e->getMessage());
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
        $data = $this->condition->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.condition.edit", compact('data', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|exists:languages,id',
                'name' => 'required|string|max:500',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->condition->findOrFail($id);
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->save();

            return redirect()->route('condition.index')->with('t-success', 'Condition Updated Successfully !!');
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
        $data = $this->condition->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.condition.show", compact('data', 'languages'));
    }

    /**
     * Toggle status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id)
    {
        try {
            $data = $this->condition->findOrFail($id);
            $data->status = $data->status == 'active' ? 'inactive' : 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully!!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->condition->findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully!!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $e->getMessage()
            ]);
        }
    }
}
