<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Language;
use App\Models\Accessory;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AccessoriesController extends Controller
{
    protected $accessory;
    protected $languages;

    public function __construct(Accessory $accessory)
    {
        $this->accessory = $accessory;
        $this->languages = Language::where('status', 'active')->get();
    }

    /**
     * Display a listing of accessories.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {

            $data = $this->accessory->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })
                ->addColumn('description', function ($data) {
                    return $data->description ?? 'N/A';
                })
                ->addColumn('price', function ($data) {
                    return '€' . number_format($data->price, 2) ?? 'N/A';
                })
                ->addColumn('previous_price', function ($data) {
                    return '€' . number_format($data->previous_price, 2) ?? 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('accessory.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('accessory.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['name', 'description', 'price', 'previous_price', 'action'])
                ->make();
        }
        return view("backend.layout.accessory.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $languages = $this->languages;
        return view("backend.layout.accessory.create", compact('languages'));
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
                'language_id' => 'required|integer',
                'name' => 'required|string|max:500',
                'description' => 'nullable|string|max:5000',
                'price' => 'required|numeric|min:0',
                'previous_price' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->accessory->newInstance();
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->previous_price = $request->previous_price;
            $data->save();

            return redirect()->route('accessory.index')->with('t-success', 'Accessory Created Successfully!');
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
        $data = $this->accessory->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.accessory.edit", compact('data', 'languages'));
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
                'language_id' => 'required|integer',
                'name' => 'required|string|max:500',
                'description' => 'nullable|string|max:5000',
                'price' => 'required|numeric|min:0',
                'previous_price' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->accessory->findOrFail($id);
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->previous_price = $request->previous_price;
            $data->save();

            return redirect()->route('accessory.index')->with('t-success', 'Accessory Updated Successfully!');
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
        $data = $this->accessory->findOrFail($id);
        return view("backend.layout.accessory.show", compact('data'));
    }

    /**
     * Toggle status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status($id): JsonResponse
    {
        try {
            $data = $this->accessory->findOrFail($id);
            $data->status = !$data->status;
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Status Updated Successfully!'
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
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $data = $this->accessory->findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $e->getMessage()
            ]);
        }
    }
}
