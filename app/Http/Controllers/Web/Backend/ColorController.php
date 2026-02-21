<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Color;
use App\Models\Product;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    protected $color;
    protected $product;
    protected $languages;

    public function __construct(Color $color, Product $product)
    {
        $this->color = $color;
        $this->product = $product;
        $this->languages = Language::where('status', 'active')->get();
    }

    /**
     * Display a listing of colors.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->color->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    return $data->name ?? 'N/A';
                })

                ->addColumn('color_preview', function ($data) {
                    $code = $data->code ?? '#000000';
                    return '<div style="width: 40px; height: 40px; background-color: ' . $code . '; border: 1px solid #ddd; border-radius: 4px;"></div>';
                })

                ->addColumn('code', function ($data) {
                    return $data->code ?? 'N/A';
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('color.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('color.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['name', 'color_preview', 'code', 'action'])
                ->make();
        }
        return view("backend.layout.color.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $languages = $this->languages;
        return view("backend.layout.color.create", compact('languages'));
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
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->color->newInstance();
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->code = $request->code;
            $data->save();

            return redirect()->route('color.index')->with('t-success', 'Color Created Successfully !!');
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
        $data = $this->color->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.color.edit", compact('data', 'languages'));
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
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->color->findOrFail($id);
            $data->language_id = $request->language_id;
            $data->name = $request->name;
            $data->code = $request->code;
            $data->save();

            return redirect()->route('color.index')->with('t-success', 'Color Updated Successfully !!');
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
        $data = $this->color->findOrFail($id);
        $languages = $this->languages;
        return view("backend.layout.color.show", compact('data', 'languages'));
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
            $data = $this->color->findOrFail($id);
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
