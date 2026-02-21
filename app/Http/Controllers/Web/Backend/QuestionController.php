<?php
namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\SellProduct;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    protected $question;
    protected $sellProducts;

    public function __construct(Question $question)
    {
        $this->question     = $question;
        $this->sellProducts = SellProduct::all();
    }

    /**
     * Display a listing of questions.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->question->with(['sellProduct', 'options'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('product', function ($data) {
                    return $data->sellProduct?->name ?? 'N/A';
                })
                ->addColumn('question', function ($data) {
                    return $data->question ?? 'N/A';
                })
               /*  ->addColumn('price', function ($data) {
                    return number_format($data->price, 2) ?? 'N/A';
                }) */
                ->addColumn('options', function ($data) {
                    return $data->options?->pluck('option')->implode(', ') ?: 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('question.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                   <i class="mdi mdi-pencil"></i>
                                </a>
                                <a href="' . route('question.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['product', 'question','options', 'action'])
                ->make();
        }

        return view('backend.layout.questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $sellProducts = $this->sellProducts;
        return view('backend.layout.questions.create', compact('sellProducts'));
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
                'sell_product_id' => 'required|integer',
                'question'        => 'required|string|max:2000',
                // 'price'           => 'nullable|numeric|min:0',
                'options_text'    => 'required|array|min:1',
                'options_text.*'  => 'required|string|max:255',
                'options_price'   => 'nullable|array',
                'options_price.*' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $question = $this->question->create([
                'sell_product_id' => $request->sell_product_id,
                'question'        => $request->question,
                // 'price'           => $request->price,
            ]);

            $optionsText  = $request->options_text ?? [];
            $optionsPrice = $request->options_price ?? [];
            $options      = array_filter($optionsText, fn($opt) => trim($opt) !== '');
            foreach ($options as $index => $optionText) {
                $price = $optionsPrice[$index] ?? 0.00;
                $question->options()->create([
                    'option' => $optionText,
                    'price'  => $price,
                ]);
            }

            return redirect()->route('question.index')->with('t-success', 'Question Created Successfully!');
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
        $data         = $this->question->with('options')->findOrFail($id);
        $sellProducts = $this->sellProducts;
        return view('backend.layout.questions.edit', compact('data', 'sellProducts'));
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
                'sell_product_id' => 'required|integer',
                'question'        => 'required|string|max:2000',
                // 'price'           => 'nullable|numeric|min:0',
                'options_text'    => 'required|array|min:1',
                'options_text.*'  => 'required|string|max:255',
                'options_price'   => 'nullable|array',
                'options_price.*' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $question                  = $this->question->findOrFail($id);
            $question->sell_product_id = $request->sell_product_id;
            $question->question        = $request->question;
            // $question->price           = $request->price;
            $question->save();

            $question->options()->delete();
            $optionsText  = $request->options_text ?? [];
            $optionsPrice = $request->options_price ?? [];
            $options      = array_filter($optionsText, fn($opt) => trim($opt) !== '');
            foreach ($options as $index => $optionText) {
                $price = $optionsPrice[$index] ?? 0.00;
                $question->options()->create([
                    'option' => $optionText,
                    'price'  => $price,
                ]);
            }

            return redirect()->route('question.index')->with('t-success', 'Question Updated Successfully!');
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
        $data = $this->question->with(['sellProduct', 'options'])->findOrFail($id);
        return view('backend.layout.questions.show', compact('data'));
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
            $data = $this->question->findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted Successfully!',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $e->getMessage(),
            ]);
        }
    }
}
