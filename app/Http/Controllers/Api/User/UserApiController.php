<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\User\PaymentTransactionStatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddCardRequest;
use App\Http\Requests\Api\PayCommissionByCardRequest;
use App\Http\Requests\Api\RechargeWalletRequest;
use App\Http\Requests\Api\User\Auth\ChangePasswordApiRequest;
use App\Http\Requests\Api\User\Auth\UpdateUserProfileApiRequest;
use App\Http\Resources\Api\User\ListCardsApiResource;
use App\Http\Resources\Api\User\ListChatsApiResource;
use App\Http\Resources\Api\User\ListCommissionsApiResource;
use App\Http\Resources\Api\User\ListMessagesApiResource;
use App\Http\Resources\Api\User\ListNotificationsApiResource;
use App\Http\Resources\Api\User\ShowWalletApiResource;
use App\Http\Resources\Api\User\UserApiResource;
use App\Services\ChatMessageService;
use App\Services\NotificationService;
use App\Services\PayCommissionService;
use App\Services\User\PaymentService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserApiController extends Controller
{
    public function getProfile()
    {
        try {
            $user = auth('api')->user();
            return ResponseHelper::successResponse(
                data: [
                    'user' => UserApiResource::make($user)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function changePassword(ChangePasswordApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            if ((new UserService())->changePassword($user, $request->get('old_password'), $request->get('new_password'))) {
                return ResponseHelper::successResponse(data: [], message: trans('api.your password updated successfully'));
            }
            return ResponseHelper::errorResponse(error: trans('api.Invalid old password'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function update(UpdateUserProfileApiRequest $request)
    {
        try {
            $user = auth('api')->user();
            $user = (new UserService())->updateProfile($user, $request->getDTO());
            return ResponseHelper::successResponse(data: ['user' => UserApiResource::make($user)]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function deleteAccount()
    {
        try {
            $user = auth('api')->user();
            (new UserService())->deleteAccount($user);
            return ResponseHelper::successResponse(data: [], message: trans('api.your account deleted successfully'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function showWallet()
    {
        try {
            $user = auth('api')->user();
            return ResponseHelper::successResponse(
                data: [
                    'wallet' => ShowWalletApiResource::make($user)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function rechargeWallet(RechargeWalletRequest $request)
    {
        try {
            $user = auth('api')->user();
            $currency = $user->default_currency;
            $returnPaymentTransactionDTO = (new PaymentService())->chargeWallet($user, $request->get('amount'), $request->get('payment_method'), $currency);

            if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
                $message = trans('api.PaymentSuccess');
            } else {
                $message = trans('api.PaymentFailed');
            }
            return ResponseHelper::successResponse(
                data: [
                    'wallet' => ShowWalletApiResource::make($user->refresh())
                ], message: $message
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listCards()
    {
        try {
            $user = auth('api')->user();
            $userService = new UserService();
            $cards = $userService->listUserCards($user);
            $intent = $userService->createSetupIntent($user);
            $data = [
                'intent' => $intent->client_secret,
                'cards' => ListCardsApiResource::collection($cards),
            ];
            return ResponseHelper::successResponse(
                data: [
                    $data
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listCommissions()
    {
        try {
            $commissions = auth('api')->user()
                ->commissions()
                ->with('advertisement')
                ->orderBy('is_paid', 'asc')
                ->get();
            return ResponseHelper::successResponse(
                data: [
                    'wallet' => ListCommissionsApiResource::collection($commissions)
                ]
            );
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function addCard(AddCardRequest $request)
    {
        try {
            $user = auth('api')->user();
            $userService = new UserService();
            $userService->addPaymentMethod($user, $request->get('payment_method'));
            return ResponseHelper::successResponse(data: [], message: trans('web.PaymentMethod received successfully'));
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function payCommissionByWallet($id)
    {
        try {
            $user = auth('api')->user();
            $response = (new PayCommissionService())->mobilePayCommissionByWallet($user, $id);
            if ($response['status']->value == PaymentTransactionStatusEnum::Failed->value) {
                return ResponseHelper::errorResponse($response['message']);
            }
            return ResponseHelper::successResponse(data: [], message: $response['message']);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function payCommissionByCard(PayCommissionByCardRequest $request)
    {
        try {
            $user = auth('api')->user();
            $response = (new PayCommissionService())->mobilePayCommissionByCard($user, $request->get('payment_method'), $request->get('id'));
            if ($response['status']->value == PaymentTransactionStatusEnum::Failed->value) {
                return ResponseHelper::errorResponse($response['message']);
            }
            return ResponseHelper::successResponse(data: [], message: $response['message']);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function getNotifications()
    {
        try {
            $user = auth('api')->user();
            $notificationService = new NotificationService();
            $notifications = $notificationService->getUserNotifications($user->id);
            return ListNotificationsApiResource::collection($notifications)->additional([
                'unread_count' => $notificationService->getUnreadUserNotificationsCount($user->id)
            ]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function markAsReadNotifications()
    {
        try {
            $user = auth('api')->user();
            $notificationService = new NotificationService();
            $notificationService->markAllAsRead($user->id);
            $notifications = $notificationService->getUserNotifications($user->id);
            return ListNotificationsApiResource::collection($notifications)->additional([
                'unread_count' => 0
            ]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function markAsReadNotification(int $id)
    {
        try {
            $user = auth('api')->user();
            $notificationService = new NotificationService();
            $notificationService->markAsRead($id, $user->id);
            $notifications = $notificationService->getUserNotifications($user->id);
            return ListNotificationsApiResource::collection($notifications)->additional([
                'unread_count' => $notificationService->getUnreadUserNotificationsCount($user->id)
            ]);
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            return ResponseHelper::errorResponse(error: trans('api.something went wrong'));
        }
    }

    public function listChats(Request $request)
    {
        $user = auth('api')->user();
        $chatMessagesService = new ChatMessageService();
        $chats = $chatMessagesService->getUserChats($user->id, $request->get('search'));
        $total_unread_messages = $chatMessagesService->getUserUnreadMessagesCount($user->id);

        if (!count($chats)) {
            return ResponseHelper::errorResponse(error: trans('api.no chat found'));
        }
        return ListChatsApiResource::collection($chats)->additional(['total_unread_messages' => $total_unread_messages]);
    }

    public function listChatMessages(int $chatId)
    {
        $chatMessagesService = new ChatMessageService();
        $chats = $chatMessagesService->getChatMessages($chatId);
        if (!count($chats)) {
            return ResponseHelper::errorResponse(error: trans('api.no chat found'));
        }
        return ListMessagesApiResource::collection($chats);
    }

    public function markChatAsRead(int $chatId)
    {
        $chatMessagesService = new ChatMessageService();
        $chatMessagesService->marchChatMessagesAsRead($chatId, auth('api')->id());
        return ResponseHelper::successResponse([], trans('api.chat marked as read successfully'));
    }
}
