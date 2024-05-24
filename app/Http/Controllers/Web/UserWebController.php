<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\ChangePasswordApiRequest;
use App\Http\Requests\Web\UpdateUserProfileWebRequest;
use App\Services\NotificationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserWebController extends Controller
{
    public function profile()
    {
        $data = [
            'user' => \auth()->guard('users')->user()
        ];
        return view('frontend.profile.show')->with($data);
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('users')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('web.home');
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            toastr()->error(trans('api.something went wrong'));
            return redirect()->route('web.home');
        }
    }

    public function updateProfile(UpdateUserProfileWebRequest $request)
    {
        try {
            $user = auth('users')->user();
            $user = (new UserService())->updateProfile($user, $request->getDTO());
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            toastr()->error(trans('api.something went wrong'));
        }
        $data = [
            'user' => $user
        ];
        return view('frontend.profile.show')->with($data);
    }

    public function changePassword(ChangePasswordApiRequest $request)
    {

        try {
            $user = auth('users')->user();
            if ((new UserService())->changePassword($user, $request->get('old_password'), $request->get('new_password'))) {
                toastr()->success(trans('api.your password updated successfully'));
                return $this->logout($request);
            } else {
                toastr()->error(trans('api.Invalid old password'));
            }
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            toastr()->error(trans('api.something went wrong'));
        }
        $data = [
            'user' => $user
        ];
        return view('frontend.profile.show')->with($data);
    }

    public function deleteAccount(Request $request)
    {
        try {
            $user = auth('users')->user();
            (new UserService())->deleteAccount($user);
            toastr()->success(trans('api.your account deleted successfully'));

        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            toastr()->error(trans('api.something went wrong'));
        }
        return $this->logout($request);
    }

    public function showNotifications()
    {
        // mark all notifications as read
        (new NotificationService())->markAllAsRead(auth('users')->id());
        return view('frontend.profile.notifications');
    }
}
