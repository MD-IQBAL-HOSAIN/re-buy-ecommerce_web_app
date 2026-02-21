<?php

namespace App\Http\Controllers\API;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class QuestionAnswerApiController extends Controller
{
    /**
     * Get questions with options by sell product id
     *
     * @param int $sellProductId
     * @return JsonResponse
     */
    public function questionsBySellProduct(int $sellProductId): JsonResponse
    {
        try {
            $questions = Question::query()
                ->with(['options'])
                ->select(['id', 'sell_product_id', 'question', 'price'])
                ->where('sell_product_id', $sellProductId)
                ->latest()
                ->get();

            return jsonResponse(
                true,
                'Questions retrieved successfully.',
                200,
                [
                    'questions' => $questions,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve questions.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Store user answers for multiple questions
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'sell_product_id' => 'required|integer|exists:sell_products,id',
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.option_id' => 'required|integer|exists:question_options,id',
        ]);

        if ($validator->fails()) {
            return jsonErrorResponse('Validation failed.', 422, $validator->errors()->toArray());
        }


        try {
            $user = auth()->user();
            $userId = $user?->id;
            $totalQuestionPrice = 0.00;
            $totalOptionPrice = 0.00;
            $sellProductId = (int) $request->sell_product_id;

            $questionIds = collect($request->answers)->pluck('question_id')->unique()->values();
            $optionIds = collect($request->answers)->pluck('option_id')->unique()->values();

            $questions = Question::whereIn('id', $questionIds)->get(['id', 'sell_product_id', 'price'])->keyBy('id');
            $questionPrices = $questions->pluck('price', 'id');
            $options = QuestionOption::whereIn('id', $optionIds)->get()->keyBy('id');

            foreach ($request->answers as $answer) {
                $questionId = $answer['question_id'];
                $optionId = $answer['option_id'];

                $option = $options->get($optionId);
                $questionPrice = (float) ($questionPrices[$questionId] ?? 0.00);
                $question = $questions->get($questionId);

                if (! $question || ! $question->sell_product_id) {
                    return jsonErrorResponse(
                        'Sell product not found for given question.',
                        422,
                        ['question_id' => $questionId]
                    );
                }

                if ((int) $question->sell_product_id !== $sellProductId) {
                    return jsonErrorResponse(
                        'Question does not belong to the selected sell product.',
                        422,
                        ['question_id' => $questionId, 'sell_product_id' => $sellProductId]
                    );
                }

                if (! $option || (int) $option->question_id !== (int) $questionId) {
                    return jsonErrorResponse(
                        'Invalid option for the given question.',
                        422,
                        ['question_id' => $questionId, 'option_id' => $optionId]
                    );
                }

                $totalQuestionPrice += $questionPrice;
                $totalOptionPrice += (float) ($option->price ?? 0.00);
            }

            $answerRow = QuestionAnswer::create([
                'user_id' => $userId,
                'sell_product_id' => $sellProductId,
                'question_price' => $totalQuestionPrice,
                'option_price' => $totalOptionPrice,
                'answers' => $request->answers,
                'user_info' => [
                    'name' => $user?->name,
                    'address' => $user?->address,
                    'city' => $user?->city,
                    'zipcode' => $user?->zip_code,
                    'country' => $user?->country,
                    'phone' => $user?->phone,
                ],
            ]);

            return jsonResponse(
                true,
                'Answers saved successfully.',
                200,
                [
                    'answer' => $answerRow,
                    // 'total_question_price' => $totalQuestionPrice,
                    // 'total_option_price' => $totalOptionPrice,
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to save answers.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Get latest question answer for authenticated user (minimal payload)
     */
    public function index(): JsonResponse
    {
        try {
            $userId = auth()->id();

            $data = QuestionAnswer::query()
                ->with(['user:id,name,email', 'sellProduct:id,name'])
                ->select(['id', 'user_id', 'sell_product_id', 'question_price', 'option_price'])
                ->where('user_id', $userId)
                ->latest()
                ->first();

            if (! $data) {
                return jsonResponse(true, 'No data found.', 200, [
                    'data' => null,
                ]);
            }

            return jsonResponse(
                true,
                'Latest question answers wise Price retrieved successfully.',
                200,
                [
                    'data' => [
                        'id' => $data->id,
                        'user_id' => $data->user_id,
                        'name' => $data->user?->name,
                        'email' => $data->user?->email,
                        'sell_product_id' => $data->sell_product_id,
                        'sell_product_name' => $data->sellProduct?->name,
                        'question_price' => $data->question_price,
                        'option_price' => $data->option_price,
                    ],
                ]
            );
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to retrieve question answers.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Update user_info for the latest question answer of authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storePickUpDetails(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'phone' => ['nullable', 'string', 'max:50', 'regex:/^\+?\d+$/'], // allows digits and optional leading + for country code
        ]);

        if ($validator->fails()) {
            return jsonErrorResponse('Validation failed.', 422, $validator->errors()->toArray());
        }

        try {
            $userId = auth()->id();
            $latest = QuestionAnswer::where('user_id', $userId)->latest()->first();

            if (! $latest) {
                return jsonErrorResponse('No question answer found for this user.', 404);
            }

            $latest->user_info = [
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'zipcode' => $request->zipcode,
                'country' => $request->country,
                'phone' => $request->phone,
            ];
            $latest->save();

            return jsonResponse(true, 'User info saved successfully.', 200, [
                'id' => $latest->id,
                'user_id' => $latest->user_id,
                'user_info' => $latest->user_info,
            ]);
        } catch (\Exception $e) {
            return jsonErrorResponse(
                'Failed to save user info.',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }
}
