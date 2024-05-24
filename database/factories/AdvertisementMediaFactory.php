<?php

namespace Database\Factories;

use App\Enums\Advertisement\AdvertisementMediaTypeEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdvertisementMedia>
 */
class AdvertisementMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file' => fake()->imageUrl(640, 480, 'car', true, true, false, 'png'),
            'advertisement_id' => fake()->numberBetween(1, 10),
            'type' => AdvertisementMediaTypeEnums::Image->value
        ];
    }
}
