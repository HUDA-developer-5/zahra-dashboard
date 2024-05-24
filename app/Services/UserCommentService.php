<?php

namespace App\Services;

use App\DTOs\User\CreateNotificationDTO;
use App\Enums\NotificationActionEnums;
use App\Enums\NotificationTypeEnums;
use App\Models\User;
use App\Models\UserAdsComment;

class UserCommentService
{
    // send notification to all users who follow this comment
    public function sendNotificationToCommentFollowers(UserAdsComment $userAdsComment): void
    {
        $followers = $this->getCommentFollowers($userAdsComment->id)->get();
        if ($followers) {
            foreach ($followers as $follower) {
                // save notification
                (new NotificationService())->save(CreateNotificationDTO::from([
                    'user_id' => $follower->id,
                    'target_user_id' => $userAdsComment->user_id,
                    'action' => NotificationActionEnums::FollowComment->value,
                    'type' => NotificationTypeEnums::Push->value,
                    'title_ar' => $follower->name,
                    'title_en' => $follower->name,
                    'content_ar' => $userAdsComment->comment,
                    'content_en' => $userAdsComment->comment,
                    'payload' => [
                        'user_id' => $userAdsComment->user_id,
                        'comment_id' => $userAdsComment->id,
                        'advertisement_id' => $userAdsComment->advertisement_id,
                        'comment' => $userAdsComment->comment,
                    ],
                    'comment_id' => $userAdsComment->id,
                    'advertisement_id' => $userAdsComment->advertisement_id,
                ]));
            }
        }
    }

    public function sendNotificationToAdvertisementOwner(UserAdsComment $userAdsComment): void
    {
        (new NotificationService())->save(CreateNotificationDTO::from([
            'user_id' => $userAdsComment->advertisement->user->id,
            'target_user_id' => $userAdsComment->user_id,
            'action' => NotificationActionEnums::NotifyAdsOwnerWithNewComment->value,
            'type' => NotificationTypeEnums::Push->value,
            'title_ar' => $userAdsComment->user->name,
            'title_en' => $userAdsComment->user->name,
            'content_ar' => 'أضاف تعليق لمنتجك: "' . $userAdsComment->comment . '"',
            'content_en' => 'Add a comment to your product: "' . $userAdsComment->comment . '"',
            'payload' => [
                'user_id' => $userAdsComment->user_id,
                'comment_id' => $userAdsComment->id,
                'advertisement_id' => $userAdsComment->advertisement_id,
                'comment' => $userAdsComment->comment,
            ],
            'comment_id' => $userAdsComment->id,
            'advertisement_id' => $userAdsComment->advertisement_id,
        ]));
    }

    public function getCommentFollowers(int $commentId)
    {
        return User::whereHas('userAdsCommentFollows', function ($q) use ($commentId) {
            $q->where('comment_id', '=', $commentId);
        });
    }
}