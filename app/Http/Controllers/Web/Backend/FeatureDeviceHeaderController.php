<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\CMS;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FeatureDeviceHeaderController extends Controller
{
    /**
     * Show the form for editing the feature device header.
     *
     * @return View
     */
    public function edit(): View
    {
        $featureDevice = CMS::find(5);
        $languages = Language::where('status', 'active')->get();

        return view('backend.layout.feature-device-header.edit', compact('featureDevice', 'languages'));
    }

    /**
     * Update the feature device header.
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

            $cms = CMS::find(5);
            if (!$cms) {
                return redirect()->back()->with('t-error', 'Feature Device Header record not found.');
            }

            // Update language
            $cms->language_id = $request->language_id;
            $cms->title = $request->title;
            $cms->subtitle = $request->subtitle;

            if ($request->hasFile('image')) {
                $imagePath = fileUpload_old($request->file('image'), 'feature-device', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    $cms->image = $imagePath;
                }
            }

            // Create slug from title only if slug is null (first time only)
            if (empty($cms->slug) && $request->title) {
                $cms->slug = Str::slug($request->title);
            }

            $cms->save();

            return redirect()->back()->with('t-success', 'Feature Device Header updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
