<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Session;

class StateApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        $locale = $request->header('Accept-Language') !== null ? $request->header('Accept-Language') : (Session::get('lang') ?? 'en');
        $locale = Session::get('lang') ? Session::get('lang') : $request->header('Accept-Language', 'en');

        $name = $this->getTranslation('name', $locale);

        return [
            'id' => $this->id,
            'name' => $name,
            'cities' => CityApiResource::collection($this->whenLoaded('cities'))
        ];
    }
}
