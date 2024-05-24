<?php

namespace Database\Factories;

use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementStatusEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'user_id' => fake()->numberBetween(1, 10),
            'category_id' => fake()->numberBetween(1, 12),
            'is_negotiable' => fake()->boolean(),
            'price_type' => fake()->randomKey(AdvertisementPriceTypeEnums::asArray()),
            'price' => fake()->numberBetween(100, 10000),
            'min_price' => fake()->numberBetween(100, 10000),
            'max_price' => fake()->numberBetween(100, 10000),
            'currency' => fake()->randomElement(['SAR', 'EGP']),
            'status' => AdvertisementStatusEnums::Active->value,
            'image' => fake()->imageUrl(640, 480, 'car', true, true, false, 'png'),
            'phone_number' => fake()->phoneNumber(),
            'whatsapp_number' => fake()->phoneNumber(),
            'type' => fake()->randomKey(AdvertisementTypeEnums::asArray()),
            'nationality_id' => fake()->numberBetween(1, 2),
            'state_id' => fake()->numberBetween(1, 2),
            'city_id' => fake()->numberBetween(1, 2),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'description' => fake()->text(),
        ];
    }
}
