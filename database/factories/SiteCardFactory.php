<?php

namespace Database\Factories;

use App\Models\SiteCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(6, true)) . '.',
            'url' => $this->faker->unique()->url,
            'description' => $this->faker->text,
        ];
    }
}
