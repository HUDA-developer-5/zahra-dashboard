<?php

namespace App\DTOs\User;

use App\Enums\NotificationActionEnums;
use App\Enums\NotificationTypeEnums;
use Spatie\LaravelData\Data;

class CreateNotificationDTO extends Data
{
    public NotificationTypeEnums $type;
    public NotificationActionEnums $action;
    public int $user_id;
    public int $target_user_id;
    public string $title_en;
    public string $title_ar;
    public $content_en;
    public $content_ar;
    public ?array $payload;
    public ?string $status;
    public ?int $advertisement_id;
    public ?int $comment_id;

}