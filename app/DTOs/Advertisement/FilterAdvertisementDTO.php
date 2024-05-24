<?php

namespace App\DTOs\Advertisement;

use Spatie\LaravelData\Data;

class FilterAdvertisementDTO extends Data
{
    public ?int $category_id;

    public ?bool $is_negotiable;

    public ?float $price_from;

    public ?float $price_to;

    public ?int $nationality_id;

    public ?int $state_id;

    public ?int $city_id;

    public ?int $near_by;

    public ?int $available_photo;

    public ?int $most_viewed;

    public ?string $latitude;

    public ?string $longitude;

    public ?string $created_at;

    public ?int $limit = 8;
}