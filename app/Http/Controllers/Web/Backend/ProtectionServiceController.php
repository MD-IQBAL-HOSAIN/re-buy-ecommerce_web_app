<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\CMS;
use App\Models\Language;
use App\Models\ProtectionService;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class ProtectionServiceController extends Controller
{
    protected $protectionService;
    protected $languages;

    public function __construct(ProtectionService $protectionService)
    {
        $this->protectionService = $protectionService;
        $this->languages = Language::where('status', 'active')->get();
    }

    /**
     * Display a listing of protection services.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->protectionService->latest()->get();

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
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('protection-service.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('protection-service.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['name', 'description', 'price', 'action'])
                ->make();
        }
        // Load CMS & languages for header
        $cms = CMS::find(2);
        $languages = $this->languages;
        return view("backend.layout.protection-service.index", compact('cms', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $languages = $this->languages;
        return view("backend.layout.protection-service.create", compact('languages'));
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'price' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->protectionService->newInstance();
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->save();

            return redirect()->route('protection-service.index')->with('t-success', 'Protection Service Created Successfully!');
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
        $data = $this->protectionService->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.protection-service.edit", compact('data', 'languages'));
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'price' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->protectionService->findOrFail($id);
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->save();

            return redirect()->route('protection-service.index')->with('t-success', 'Protection Service Updated Successfully!');
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
        $data = $this->protectionService->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.protection-service.show", compact('data', 'languages'));
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
            $data = $this->protectionService->findOrFail($id);
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
            $data = $this->protectionService->findOrFail($id);
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
