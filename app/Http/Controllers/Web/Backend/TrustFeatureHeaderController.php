<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\CMS;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class TrustFeatureHeaderController extends Controller
{

    /**
     * Show the form for editing the how it works header.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('backend.layout.trust-feature.index');
    }

    /**
     * Update the how it works header.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id' => 'nullable|exists:languages,id',
            'title' => 'nullable|string|max:255',
        ]);

        try {
            $cms = CMS::find(11);

            if (!$cms) {
                $cms = CMS::firstOrCreate(['id' => 11], [
                    'title' => 'Ihr Vertrauen ist unsere Priorität',
                    'slug' => 'trust-features'
                ]);
            }

            $data = [
                'language_id' => $request->language_id,
                'title' => $request->title
            ];
            $cms->update($data);

            return redirect()->back()->with('t-success', 'Header updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
