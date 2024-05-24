<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisementMedia extends Model
{
    use HasFactory;

    protected $table = "advertisement_media";

    public static string $destination_path = 'advertisement_media';

    protected $fillable = ['advertisement_id', 'type', 'file'];

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }

    public function getFilePathAttribute(): string
    {
        return FilesHelper::filePath($this->file);
    }
}
