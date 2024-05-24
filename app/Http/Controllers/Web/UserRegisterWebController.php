<?php

namespace App\Http\Controllers\Web;

use App\Enums\CommonStatusEnums;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Auth\UserLoginApiRequest;
use App\Http\Requests\Api\User\Auth\UserRegisterApiRequest;
use App\Http\Requests\Web\UserRegisterWebRequest;
use App\Http\Resources\Api\User\AccessTokenApiResource;
use App\Http\Resources\Api\User\UserApiResource;
use App\Models\Nationality;
use App\Services\User\UserLoginService;
use App\Services\User\UserRegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserRegisterWebController extends Controller
{
    public function register(UserRegisterWebRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = (new UserRegisterService())->store($request->getDTO());
            DB::commit();
            Auth::guard('users')->login($user, remember: true);
            toastr()->success(__("web.welcome") . " " . $user->name);
            return redirect()->route('web.home');
        } catch (\Exception|\TypeError $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            toastr()->error(trans('api.something went wrong'));
            return redirect()->route('web.home');
        }
    }

    public function login(UserLoginApiRequest $request)
    {
        try {
            $user = (new UserLoginService())->login($request->get('user_name'), $request->get('password'));
            if (!$user) {
                session()->flash('login_error', trans('api.login.invalid credentials'));
                toastr()->error(trans('api.login.invalid credentials'));
                return redirect()->route('web.home');
            }
            Auth::guard('users')->login($user, remember: true);
            toastr()->success(__("web.welcome") . " " . $user->name);
            return redirect()->route('web.home');
        } catch (\Exception|\TypeError $exception) {
            Log::error($exception->getMessage());
            toastr()->error(trans('api.something went wrong'));
            return redirect()->route('web.home');
        }
    }
}
