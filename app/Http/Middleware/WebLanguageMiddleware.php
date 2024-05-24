<?php

namespace App\Http\Middleware;

use App\Enums\User\LanguageKeysEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // update user default language
//            if (auth('api')->check()) {
//                $user = auth('api')->user();
//                $user->updateDefaultLanguage($user, LanguageKeysEnum::from($language));
//            }


        app()->setLocale(app()->getLocale());
//        dd($language);
        return $next($request);
    }
}
