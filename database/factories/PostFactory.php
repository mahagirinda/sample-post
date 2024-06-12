<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'draft' => $this->faker->boolean(),
            'title' => $this->faker->sentence(4),
            'image' => $this->faker->word(),
            'category_id' => Category::factory(),
            'contents' => $this->faker->text(),
            'visit_counts' => $this->faker->numberBetween(-100000, 100000),
        ];
    }
}
