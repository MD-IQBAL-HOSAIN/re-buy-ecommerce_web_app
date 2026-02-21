<?php

namespace Database\Seeders;

use App\Models\CMS;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cmsList = [
            // Buy Category Header CMS Entries
            ['id' => 1, 'language_id' => 1, 'name' => null, 'title' => 'Shop by Category', 'subtitle' => 'Find your perfect refurbished device', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Protection Service Header CMS Entries
            ['id' => 2, 'language_id' => 1, 'name' => null, 'title' => 'Optional extras to protect your device', 'subtitle' => 'Add these to your order for extra peace of mind', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Refurbished Electronics Header CMS Entries
            ['id' => 3, 'language_id' => 1, 'name' => 'Buy Now', 'title' => 'Buy refurbished electronics', 'subtitle' => 'Get an instant price quote, ship for free, and receive fast payment. The simple, secure way to sell your devices.', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Banner CMS Entries
            ['id' => 4, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Featured Devices Header CMS Entries
            ['id' => 5, 'language_id' => 1, 'name' => null, 'title' => 'Featured Devices', 'subtitle' => 'Our most popular refurbished electronics', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Review and Rating Header CMS Entries
            ['id' => 6, 'language_id' => 1, 'name' => null, 'title' => 'Trusted by thousands', 'subtitle' => 'See what our customers have to say', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Customer Details CMS Entries
            ['id' => 7, 'language_id' => 1, 'name' => 'Name', 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => 'Email', 'phone' => 'Phone Number', 'total' => 'Total', 'continue' => 'Continue', 'back' => 'Back','place_order'=>'Place Order','add_to_cart' => null, 'buy_now' => null, 'shipping' => 'Shipping', 'payment' => 'Payment', 'review' => 'Review', 'return' => null, 'order_summary' => 'Order Summary', 'customer_details' => 'Customer Details', 'subtotal' => 'Subtotal', 'products' => 'Products', 'contact' => 'Contacts', 'city' => 'City', 'postal_code' => 'Postal Code', 'country' => 'Country', 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Sell Electronics Header CMS Entries
            ['id' => 8, 'language_id' => 1, 'name' => 'Sell Now', 'title' => 'Sell your used electronics instantly', 'subtitle' => 'Get an instant price quote, ship for free, and receive fast payment. The simple, secure way to sell your devices.', 'button_text_one' => 'Sell Now', 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // What would you Like To Sell Header CMS Entries
            ['id' => 9, 'language_id' => 1, 'name' => null, 'title' => 'What would you like to sell', 'subtitle' => 'Select a category to get started. We buy all major brands and models.', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // how It Works Header CMS Entries
            ['id' => 10, 'language_id' => 1, 'name' => 'Simple 4-step process', 'title' => 'How it works', 'subtitle' => 'Selling your device has never been easier. Start in just a few minutes.', 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Trust Feature Header CMS Entries
            ['id' => 11, 'language_id' => 1, 'name' => null, 'title' => 'Ihr Vertrauen ist unsere Priorität', 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 12
            ['id' => 12, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 13
            ['id' => 13, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 14
            ['id' => 14, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 15
            ['id' => 15, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 16
            ['id' => 16, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 17
            ['id' => 17, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 18
            ['id' => 18, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 19
            ['id' => 19, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],

            // Reserved CMS Entry 20
            ['id' => 20, 'language_id' => 1, 'name' => null, 'title' => null, 'subtitle' => null, 'button_text_one' => null, 'button_text_two' => null, 'checkout' => null, 'email_text' => null, 'phone' => null, 'total' => null, 'continue' => null, 'back' => null, 'add_to_cart' => null, 'buy_now' => null, 'shipping' => null, 'payment' => null, 'review' => null, 'return' => null, 'order_summary' => null, 'customer_details' => null, 'subtotal' => null, 'products' => null, 'contact' => null, 'city' => null, 'postal_code' => null, 'country' => null, 'description' => null, 'content' => null, 'image' => null, 'image_two' => null, 'image_three' => null, 'image_four' => null, 'image_five' => null, 'slug' => null],
        ];

        foreach ($cmsList as $cms) {
            if (!CMS::where('id', $cms['id'])->exists()) {
                CMS::create($cms);
            } else {
                $this->command->info('Already seeded CMS data for ID: ' . $cms['id']);
            }
        }
    }
}
