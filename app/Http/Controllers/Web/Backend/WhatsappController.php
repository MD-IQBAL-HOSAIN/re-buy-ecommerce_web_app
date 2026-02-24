<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Whatsapp;

class WhatsappController extends Controller
{
    /**
     * Show the WhatsApp number edit page.
     *
     * @return View
     */
    public function edit(): View
    {
        $whatsapp = Whatsapp::query()->first();

        if (!$whatsapp) {
            $whatsapp = Whatsapp::create([
                'number' => null,
            ]);
        }

        return view('backend.layout.whatsapp.edit', compact('whatsapp'));
    }

    /**
     * Update the WhatsApp number.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'number' => ['nullable', 'string', 'max:30', 'regex:/^\\+[0-9]{6,29}$/'],
        ], [
            'number.regex' => 'Please enter a valid WhatsApp number with country code, e.g. +88017564564.',
        ]);

        try {
            $whatsapp = Whatsapp::query()->first();

            if (!$whatsapp) {
                $whatsapp = new Whatsapp();
            }

            $whatsapp->number = $request->number;
            $whatsapp->save();

            return redirect()->back()->with('t-success', 'WhatsApp number updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
