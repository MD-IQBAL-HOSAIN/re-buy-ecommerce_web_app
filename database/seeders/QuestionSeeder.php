<?php
namespace Database\Seeders;

use App\Models\Question;
use App\Models\SellProduct;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionsByProduct = [
            'iPhone 15 Pro Max' => [
                [
                    'question' => 'What is the device condition?',
                    'price' => 10.00,
                    'options' => [
                        ['text' => 'Brand New', 'price' => 50.00],
                        ['text' => 'Like New', 'price' => 30.00],
                        ['text' => 'Good', 'price' => 20.00],
                        ['text' => 'Fair', 'price' => 10.00],
                    ],
                ],
                [
                    'question' => 'Is the device fully functional?',
                    'price' => 20.00,
                    'options' => [
                        ['text' => 'Yes', 'price' => 20.00],
                        ['text' => 'No', 'price' => 0.00],
                    ],
                ],
                [
                    'question' => 'Does it include the original box?',
                    'price' => 30.00,
                    'options' => [
                        ['text' => 'Yes', 'price' => 10.00],
                        ['text' => 'No', 'price' => 0.00],
                    ],
                ],
            ],
            'Galaxy S24 Ultra' => [
                [
                    'question' => 'What is the device condition?',
                    'price' => 10.00,
                    'options' => [
                        ['text' => 'Brand New', 'price' => 50.00],
                        ['text' => 'Like New', 'price' => 30.00],
                        ['text' => 'Good', 'price' => 20.00],
                        ['text' => 'Fair', 'price' => 10.00],
                    ],
                ],
                [
                    'question' => 'Any screen scratches?',
                    'price' => 20.00,
                    'options' => [
                        ['text' => 'No scratches', 'price' => 30.00],
                        ['text' => 'Light scratches', 'price' => 20.00],
                        ['text' => 'Heavy scratches', 'price' => 10.00],
                    ],
                ],
                [
                    'question' => 'Is the device unlocked?',
                    'price' => 30.00,
                    'options' => [
                        ['text' => 'Yes', 'price' => 20.00],
                        ['text' => 'No', 'price' => 0.00],
                    ],
                ],
            ],
            'Xiaomi 14 Ultra' => [
                [
                    'question' => 'What is the device condition?',
                    'price' => 10.00,
                    'options' => [
                        ['text' => 'Brand New', 'price' => 50.00],
                        ['text' => 'Like New', 'price' => 30.00],
                        ['text' => 'Good', 'price' => 20.00],
                        ['text' => 'Fair', 'price' => 10.00],
                    ],
                ],
                [
                    'question' => 'Battery health status?',
                    'price' => 50.00,
                    'options' => [
                        ['text' => '90% or above', 'price' => 50.00],
                        ['text' => '80% - 89%', 'price' => 30.00],
                        ['text' => 'Below 80%', 'price' => 10.00],
                    ],
                ],
            ],
            'Google Pixel Pixel 8 Pro' => [
                [
                    'question' => 'What is the device condition?',
                    'price' => 10.00,
                    'options' => [
                        ['text' => 'Brand New', 'price' => 50.00],
                        ['text' => 'Like New', 'price' => 30.00],
                        ['text' => 'Good', 'price' => 20.00],
                        ['text' => 'Fair', 'price' => 10.00],
                    ],
                ],
                [
                    'question' => 'Any camera issues?',
                    'price' => 20.00,
                    'options' => [
                        ['text' => 'No', 'price' => 20.00],
                        ['text' => 'Yes', 'price' => 0.00],
                    ],
                ],
            ],
        ];

        foreach ($questionsByProduct as $productName => $questions) {
            $sellProduct = SellProduct::where('name', $productName)->first();

            if (! $sellProduct) {
                $this->command->info('Skipped (sell product missing): ' . $productName);
                continue;
            }

            foreach ($questions as $questionData) {
                $exists = Question::where('sell_product_id', $sellProduct->id)
                    ->where('question', $questionData['question'])
                    ->exists();

                if ($exists) {
                    $this->command->info('Already seeded: ' . $questionData['question']);
                    continue;
                }

                $question = Question::create([
                    'sell_product_id' => $sellProduct->id,
                    'question' => $questionData['question'],
                    'price' => $questionData['price'] ?? 10.00,
                ]);

                foreach ($questionData['options'] as $optionData) {
                    $optionText = is_array($optionData) ? $optionData['text'] : $optionData;
                    $optionPrice = is_array($optionData) ? ($optionData['price'] ?? 0.00) : 0.00;
                    $optionExists = QuestionOption::where('question_id', $question->id)
                        ->where('option', $optionText)
                        ->exists();

                    if (! $optionExists) {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'option' => $optionText,
                            'price' => $optionPrice,
                        ]);
                    }
                }

                $this->command->info('Question seeded: ' . $questionData['question']);
            }
        }
    }
}
