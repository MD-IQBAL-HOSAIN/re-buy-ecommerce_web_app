<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\CMS;
use App\Models\Language;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class WhatLikeToSellController extends Controller
{
   /**
     * Show the form for editing the What Like To Sell header.
     *
     * @return View
     */
    public function edit(): View
    {
        $cms = CMS::find(9);
        $languages = Language::where('status', 'active')->get();

        return view('backend.layout.sell-what-like-to-sell.edit', compact('cms', 'languages'));
    }

    /**
     * Update the What Like To Sell header.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id' => 'nullable|exists:languages,id',
            'title' => 'nullable|string|max:500',
            'subtitle' => 'nullable|string|max:500',
        ]);

        try {
            $cms = CMS::find(9);

            if (!$cms) {
                return redirect()->back()->with('t-error', 'What Like To Sell record not found.');
            }

            // Update language
            $cms->language_id = $request->language_id;
            $cms->title = $request->title;
            $cms->subtitle = $request->subtitle;
            $cms->save();

            return redirect()->back()->with('t-success', 'What Like To Sell header updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
