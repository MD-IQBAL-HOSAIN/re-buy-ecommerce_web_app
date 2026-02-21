<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class StripeSettingsController extends Controller
{
    public function index(){
        return view("backend.layout.settings.payments-settings");
    }

    public function update(Request $request) {
        $request->validate([
            'stripe_key'       => 'nullable|string',
            'stripe_secret'         => 'nullable|string',
            'stripe_websocket_secret'         => 'nullable|string',
            'payment_success_url'         => 'nullable|string',
            'payment_cancel_url'         => 'nullable|string',
        ]);

        try {
            $stripeKey = str_replace(' ', '', $request->stripe_key);
            $stripeSecret = str_replace(' ', '', $request->stripe_secret);
            $stripeWebhookSecret = str_replace(' ', '', $request->stripe_webhook_secret);
            $paymentSuccessUrl = str_replace(' ', '', $request->payment_success_url);
            $paymentCancelUrl = str_replace(' ', '', $request->payment_cancel_url);

            $envContent = File::get(base_path('.env'));
            $lineBreak  = "\n";
            $envContent = preg_replace([
                '/STRIPE_KEY=(.*)\s*/',
                '/STRIPE_SECRET=(.*)\s*/',
                '/STRIPE_WEBHOOK_SECRET=(.*)\s*/',
                '/PAYMENT_SUCCESS_URL=(.*)\s*/',
                '/PAYMENT_CANCEL_URL=(.*)\s*/',

            ], [
                'STRIPE_KEY=' . $stripeKey . $lineBreak,
                'STRIPE_SECRET=' . $stripeSecret . $lineBreak,
                'STRIPE_WEBHOOK_SECRET=' . $stripeWebhookSecret . $lineBreak,
                'PAYMENT_SUCCESS_URL=' . $paymentSuccessUrl . $lineBreak,
                'PAYMENT_CANCEL_URL=' . $paymentCancelUrl . $lineBreak,
            ], $envContent);

            File::put(base_path('.env'), $envContent);

            return response()->json([
                'success'=> true,
                'message' => 'stripe data updated'
            ], 201);

        }
        catch (\Exception $e) {

            return response()->json([
                'success'=> false,
                'message' => 'error', 'Failed to update ... '.$e->getMessage()
            ], 422);
        }
    }

    public function test(){
        return 'gayh';
    }
}
