<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;


class ThrottleApi extends ThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        // Customize the request signature logic
        return sha1(
            $request->method() . '|' . $request->route()->getName() . '|' . $request->ip()
        );
    }

    public function resolveMaxAttempts($request, $maxAttempts=10){
        return $maxAttempts;
    }

    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $maxAttempts = $this->resolveMaxAttempts($request,$maxAttempts);
        if ($this->limiter->tooManyAttempts($this->resolveRequestSignature($request), $maxAttempts)) {
            $retryAfter = $this->limiter->availableIn($this->resolveRequestSignature($request));
            return failResponse(__("auth.throttle",["seconds"=>$retryAfter]));
        }
        return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
    }
}
