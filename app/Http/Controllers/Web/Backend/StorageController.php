<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Storage;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StorageController extends Controller
{
   protected $storage;
   protected $languages;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
        $this->languages = Language::where('status', 'active')->get();
    }

    /**
     * Display a listing of storages.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->storage->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })

                ->addColumn('capacity', function ($data) {
                    return $data->capacity ?? 'N/A';
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('storage.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('storage.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['name', 'capacity', 'action'])
                ->make();
        }
        return view("backend.layout.store.index");
    }

    /**
     * Show the form for creating a new storage.
     *
     * @return View
     */
    public function create(): View
    {
        $languages = $this->languages;
        return view("backend.layout.store.create", compact('languages'));
    }

    /**
     * Store a newly created storage in database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'language_id' => 'required|exists:languages,id',
            'name' => 'required|string|max:255|in:GB,TB,PB',
            'capacity' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $this->storage->create([
                'language_id' => $request->language_id,
                'name' => $request->name,
                'capacity' => $request->capacity,
            ]);

            return redirect()->route('storage.index')
                ->with('success', 'Storage created successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create storage. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified storage.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        $storage = $this->storage->find($id);
        $languages = $this->languages;

        if (!$storage) {
            return redirect()->route('storage.index')
                ->with('error', 'Storage not found.');
        }

        return view("backend.layout.store.show", compact('storage', 'languages'));
    }

    /**
     * Show the form for editing the specified storage.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function edit(int $id): View|RedirectResponse
    {
        $storage = $this->storage->find($id);
        $languages = $this->languages;

        if (!$storage) {
            return redirect()->route('storage.index')
                ->with('error', 'Storage not found.');
        }

        return view("backend.layout.store.edit", compact('storage', 'languages'));
    }

    /**
     * Update the specified storage in database.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $storage = $this->storage->find($id);

        if (!$storage) {
            return redirect()->route('storage.index')
                ->with('error', 'Storage not found.');
        }

        $validator = Validator::make($request->all(), [
            'language_id' => 'required|exists:languages,id',
            'name' => 'required|string|max:255|in:GB,TB,PB',
            'capacity' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $storage->update([
                'language_id' => $request->language_id,
                'name' => $request->name,
                'capacity' => $request->capacity,
            ]);

            return redirect()->route('storage.index')
                ->with('t-success', 'Storage updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('t-error', 'Failed to update storage. ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified storage from database.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $storage = $this->storage->find($id);

            if (!$storage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Storage not found.'
                ], 404);
            }

            $storage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Storage deleted successfully.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete storage. ' . $e->getMessage()
            ], 500);
        }
    }
}
