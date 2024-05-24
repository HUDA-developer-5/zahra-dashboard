<?php

namespace App\Services;

use App\DTOs\User\CreateNotificationDTO;
use App\Models\Notification;

class NotificationService
{
    public function save(CreateNotificationDTO $createNotificationDTO): Notification
    {
        $notification = new Notification();
        $notification->action = $createNotificationDTO->action->value;
        $notification->type = $createNotificationDTO->type->value;
        $notification->user_id = $createNotificationDTO->user_id;
        $notification->target_user_id = $createNotificationDTO->target_user_id;
        $notification->title_en = $createNotificationDTO->title_en;
        $notification->title_ar = $createNotificationDTO->title_ar;
        $notification->content_en = $createNotificationDTO->content_en;
        $notification->content_ar = $createNotificationDTO->content_ar;
        $notification->status = $createNotificationDTO->status;
        $notification->comment_id = $createNotificationDTO->comment_id;
        $notification->advertisement_id = $createNotificationDTO->advertisement_id;
        $notification->payload = $createNotificationDTO->payload;
        $notification->save();
        return $notification;
    }

    public function getUserNotifications(int $user_id)
    {
        return Notification::where('user_id', '=', $user_id)
            ->with('user', 'targetUser', 'advertisement', 'comment')
            ->orderBy('is_read', 'desc')
            ->latest()
            ->paginate();
    }

    public function getUnreadUserNotificationsCount(int $user_id)
    {
        return Notification::where('user_id', '=', $user_id)->where('is_read', '=', 0)->count();
    }

    public function markAsRead(int $notification_id, int $user_id): bool
    {
        $notification = Notification::where('id', '=', $notification_id)->where('user_id', '=', $user_id)->first();
        if ($notification) {
            $notification->is_read = 1;
            $notification->save();
            return true;
        }
        return false;
    }

    public function markAllAsRead(int $user_id): void
    {
        Notification::where('user_id', '=', $user_id)
            ->where('is_read', '=', 0)
            ->update(['is_read' => 1]);
    }
}