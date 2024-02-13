<?php

namespace App\Http\Middleware;

use App\Enums\User\LanguageKeysEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APILanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = $request->header('accept-language');
        if (in_array($language, LanguageKeysEnum::asArray())) {
            // update user default language
            if (auth('api')->check()) {
                $user = auth('api')->user();
                $user->updateDefaultLanguage($user, LanguageKeysEnum::from($language));
            }
            app()->setLocale($language);
        }
        return $next($request);
    }
}
