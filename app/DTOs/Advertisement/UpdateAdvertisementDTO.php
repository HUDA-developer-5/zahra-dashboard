<?php

namespace App\DTOs\Advertisement;

use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementStatusEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class UpdateAdvertisementDTO extends Data
{
    public ?AdvertisementStatusEnums $status;

    public ?string $name;

    public ?string $phone_number;

    public ?string $whatsapp_number;

    public ?int $category_id;

    public ?bool $is_sold;

    public ?int $is_negotiable;

    public ?AdvertisementPriceTypeEnums $price_type;

    public ?float $price;

    public ?float $min_price;

    public ?float $max_price;

    public ?string $currency;

    public ?AdvertisementTypeEnums $type;

    public ?int $nationality_id;

    public ?int $state_id;

    public ?int $city_id;

    public ?string $latitude;

    public ?string $longitude;

    public ?string $description;

    public ?UploadedFile $image;

    public ?array $images;

    public ?array $videos;
}