<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisementMedia extends Model
{
    use HasFactory;

    protected $table = "advertisement_media";

    protected $fillable = ['advertisement_id', 'type', 'mime_type', 'file', 'is_main'];

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }
}
