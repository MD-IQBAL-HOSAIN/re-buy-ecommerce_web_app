<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\CMS;
use App\Models\Review;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class ReviewRatingsController extends Controller
{
    /**
     * Display a listing of reviews.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $data = Review::with(['user', 'product'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('user_name', function ($data) {
                    return $data->user->name ?? 'N/A';
                })

                ->addColumn('product_name', function ($data) {
                    return $data->product->name ?? 'N/A';
                })

                ->addColumn('rating', function ($data) {
                    $stars = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $data->rating) {
                            $stars .= '<i class="mdi mdi-star text-warning"></i>';
                        } else {
                            $stars .= '<i class="mdi mdi-star-outline text-muted"></i>';
                        }
                    }
                    return $stars;
                })

                ->addColumn('review_text', function ($data) {
                    return Str::limit($data->review_text ?? 'N/A', 50);
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
                                <a href="' . route('review-ratings.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="View">
                                   <i class="mdi mdi-eye"></i>
                                </a>
                                 <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="mdi mdi-delete"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['user_name', 'product_name', 'rating', 'review_text', 'status', 'action'])
                ->make();
        }

        // Load languages and CMS for header
        $languages = Language::where('status', 'active')->get();
        $cms = CMS::find(6);

        return view('backend.layout.review-ratings.index', compact('languages', 'cms'));
    }

    /**
     * Display the specified review.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $review = Review::with(['user', 'product', 'language'])->findOrFail($id);

        return view('backend.layout.review-ratings.show', compact('review'));
    }

    /**
     * Toggle the status of the review.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);
            $review->status = $review->status == 'active' ? 'inactive' : 'active';
            $review->save();

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified review.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $review = Review::findOrFail($id);
            $review->delete();

            return response()->json([
                't-success' => true,
                'message' => 'Review deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                't-success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the review ratings header.
     *
     * @return View
     */
    public function edit(): View
    {
        $reviewRatings = CMS::find(6);
        $languages = Language::where('status', 'active')->get();

        return view('backend.layout.review-ratings.edit', compact('reviewRatings', 'languages'));
    }

    /**
     * Update the review ratings header.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id' => 'nullable|exists:languages,id',
            'title' => 'nullable|string|max:500',
            'subtitle' => 'nullable|string|max:1000',
        ]);

        try {
            $cms = CMS::find(6);

            if (!$cms) {
                return redirect()->back()->with('t-error', 'Review & Ratings header record not found.');
            }

            // Update fields
            $cms->language_id = $request->language_id;
            $cms->title = $request->title;
            $cms->subtitle = $request->subtitle;

            // Create slug from title only if slug is null (first time only)
            if (empty($cms->slug) && $request->title) {
                $cms->slug = Str::slug($request->title);
            }

            $cms->save();

            return redirect()->back()->with('t-success', 'Review & Ratings header updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
