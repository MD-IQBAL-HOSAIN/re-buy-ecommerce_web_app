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

class CustomerDetailsController extends Controller
{
    /**
     * Show the form for editing the customer details section.
     *
     * @return View
     */
    public function edit(): View
    {
        $customerDetails = CMS::find(7);
        $languages = Language::where('status', 'active')->get();

        return view('backend.layout.customer-details.edit', compact('customerDetails', 'languages'));
    }

    /**
     * Update the customer details section.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'language_id' => 'nullable|exists:languages,id',
            'customer_details' => 'nullable|string|max:300',
            'email_text' => 'nullable|string|max:100',
            'name' => 'nullable|string|max:300',
            'phone' => 'nullable|string|max:100',
            'back' => 'nullable|string|max:100',
            'continue' => 'nullable|string|max:100',
            'order_summary' => 'nullable|string|max:100',
            'total' => 'nullable|string|max:100',
            'subtotal' => 'nullable|string|max:100',
            'shipping' => 'nullable|string|max:100',
            'payment' => 'nullable|string|max:100',
            'review' => 'nullable|string|max:100',
            'products' => 'nullable|string|max:100',
            'contact' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'place_order' => 'nullable|string|max:100',
        ]);

        try {
            $cms = CMS::find(7);

            if (!$cms) {
                return redirect()->back()->with('t-error', 'Customer Details record not found.');
            }

            // Update fields
            $cms->language_id = $request->language_id;
            $cms->customer_details = $request->customer_details;
            $cms->email_text = $request->email_text;
            $cms->name = $request->name;
            $cms->phone = $request->phone;
            $cms->back = $request->back;
            $cms->continue = $request->continue;
            $cms->order_summary = $request->order_summary;
            $cms->total = $request->total;
            $cms->subtotal = $request->subtotal;
            $cms->shipping = $request->shipping;
            $cms->payment = $request->payment;
            $cms->review = $request->review;
            $cms->products = $request->products;
            $cms->contact = $request->contact;
            $cms->city = $request->city;
            $cms->postal_code = $request->postal_code;
            $cms->country = $request->country;
            $cms->place_order = $request->place_order;

            $cms->save();

            return redirect()->back()->with('t-success', 'Customer Details updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('t-error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
