<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\CMS;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Exception;

class BuyCategoryHeaderController extends Controller
{
    /**
     * Show the form for editing the buy category header.
     *
     * @return View
     */
    public function edit(): View
    {
        // $cms = CMS::find(1); no need already loaded in BuyCategoryController
        return view('backend.layout.buy-category.index');
    }

    /**
     * Update the buy category header.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id' => 'nullable|exists:languages,id',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
        ]);

        try {
            $cms = CMS::find(1);

            if (!$cms) {
                return redirect()->back()->with('t-error', 'CMS record not found.');
            }

            $data = [
                'language_id' => $request->language_id,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
            ];

            // Create slug from title only if slug is null (first time only)
            if (empty($cms->slug) && $request->title) {
                $data['slug'] = Str::slug($request->title);
            }

            $cms->update($data);

            return redirect()->route('buy-category.index')->with('t-success', 'Buy Category Header updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
