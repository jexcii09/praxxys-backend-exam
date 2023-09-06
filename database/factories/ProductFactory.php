<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;

    public function definition(): array
    {
        $randomId = Category::inRandomOrder()->first()->id;

        return [
            'name' => fake()->unique()->word(),
            'category_id' => $randomId,
            'description' => fake()->text($maxNbChars = 300),
            'date' => Carbon::now()
        ];
    }
}
