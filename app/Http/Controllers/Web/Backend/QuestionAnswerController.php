<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionOption;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuestionAnswerController extends Controller
{
    /**
     * Display a listing of question answers.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = QuestionAnswer::with(['user', 'sellProduct'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function ($data) {
                    $name = $data->user?->name ?? 'N/A';
                    $email = $data->user?->email ? ' (' . $data->user->email . ')' : '';
                    return $name . $email;
                })
                ->addColumn('product', function ($data) {
                    return $data->sellProduct?->name ?? 'N/A';
                })
                ->addColumn('question_price', function ($data) {
                    return number_format((float) $data->question_price, 2) ?? '0.00';
                })
                ->addColumn('option_price', function ($data) {
                    return number_format((float) $data->option_price, 2) ?? '0.00';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('question-answers.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['user', 'product', 'question_price', 'option_price', 'action'])
                ->make();
        }

        return view('backend.layout.question-answers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $data = QuestionAnswer::with(['user', 'sellProduct'])->findOrFail($id);

        $answers = $data->answers ?? [];
        $questionIds = collect($answers)->pluck('question_id')->filter()->unique()->values();
        $optionIds = collect($answers)->pluck('option_id')->filter()->unique()->values();

        $questions = Question::whereIn('id', $questionIds)->get()->keyBy('id');
        $options = QuestionOption::whereIn('id', $optionIds)->get()->keyBy('id');

        $answerDetails = [];
        foreach ($answers as $answer) {
            $question = $questions->get($answer['question_id'] ?? null);
            $option = $options->get($answer['option_id'] ?? null);

            $answerDetails[] = [
                'question' => $question?->question ?? 'N/A',
                'question_price' => $question?->price ?? 0,
                'option' => $option?->option ?? 'N/A',
                'option_price' => $option?->price ?? 0,
            ];
        }

        return view('backend.layout.question-answers.show', compact('data', 'answerDetails'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $data = QuestionAnswer::findOrFail($id);
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
