<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\CMS;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class SellElectronicsHeaderController extends Controller
{
    /**
     * Show the form for editing the sell electronics header.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('backend.layout.sell-electronics.index');
    }

    /**
     * Update the sell electronics header.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id' => 'nullable|exists:languages,id',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        try {
            $cms = CMS::find(8);

            if (!$cms) {
                return redirect()->back()->with('t-error', 'CMS record not found.');
            }

            $data = [
                'language_id' => $request->language_id,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'name' => $request->name,
            ];

            // Create slug from title only if slug is null (first time only)
            if (empty($cms->slug) && $request->title) {
                $data['slug'] = Str::slug($request->title);
            }

            $cms->update($data);

            return redirect()->back()->with('t-success', 'Header updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
