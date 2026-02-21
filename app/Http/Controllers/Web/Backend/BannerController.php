<?php
namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\CMS;
use App\Models\Language;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    /**
     * Show the form for editing the banner.
     *
     * @return View
     */
    public function edit(): View
    {
        $banner    = CMS::find(4);
        $languages = Language::where('status', 'active')->get();

        return view('backend.layout.banner.edit', compact('banner', 'languages'));
    }

    /**
     * Update the banner.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id'   => 'nullable|exists:languages,id',
            'image'         => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:5120',
            'image_two'     => 'nullable|image|mimes:png,jpg,jpeg,gif,webp|max:5120',
            'video_mobile'  => 'nullable|mimes:mp4,mov,avi,wmv|max:512000', // 500MB max for videos
            'video_desktop' => 'nullable|mimes:mp4,mov,avi,wmv|max:512000', // 500MB max for videos
        ]);

        try {
            $cms = CMS::find(4);

            if (! $cms) {
                return redirect()->back()->with('t-error', 'Banner record not found.');
            }

            // Update language
            $cms->language_id = $request->language_id;

            if ($request->hasFile('image')) {
                $imagePath = fileUpload_old($request->file('image'), 'banners', time() . '_' . $request->file('image')->getClientOriginalName());
                if ($imagePath !== null) {
                    if ($cms->image && file_exists(public_path($cms->image))) {
                        fileDelete(public_path($cms->image));
                    }
                    $cms->image = $imagePath;
                }
            }

            if ($request->hasFile('image_two')) {
                $imageTwoPath = fileUpload_old($request->file('image_two'), 'banners', time() . '_' . $request->file('image_two')->getClientOriginalName());
                if ($imageTwoPath !== null) {
                    if ($cms->image_two && file_exists(public_path($cms->image_two))) {
                        fileDelete(public_path($cms->image_two));
                    }
                    $cms->image_two = $imageTwoPath;
                }
            }
            // Handle video uploads and store in image_four / image_five columns
            if ($request->hasFile('video_mobile')) {
                $videoMobilePath = fileUpload_old($request->file('video_mobile'), 'banners', time() . '_' . $request->file('video_mobile')->getClientOriginalName());
                if ($videoMobilePath !== null) {
                    if ($cms->image_four && file_exists(public_path($cms->image_four))) {
                        fileDelete(public_path($cms->image_four));
                    }
                    $cms->image_four = $videoMobilePath;
                }
            }

            if ($request->hasFile('video_desktop')) {
                $videoDesktopPath = fileUpload_old($request->file('video_desktop'), 'banners', time() . '_' . $request->file('video_desktop')->getClientOriginalName());
                if ($videoDesktopPath !== null) {
                    if ($cms->image_five && file_exists(public_path($cms->image_five))) {
                        fileDelete(public_path($cms->image_five));
                    }
                    $cms->image_five = $videoDesktopPath;
                }
            }

            $cms->save();

            return redirect()->back()->with('t-success', 'Banner updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
