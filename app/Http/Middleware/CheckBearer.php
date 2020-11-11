<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckBearer
{
    /**
     * 부분별한 API 콜을 방지하기 위해 config/common.php에 기재된 token->basic의 Bearer Token 값과 비교하여 일치 하지 않으면 403 error를 응답
     *
     * @uses config/common.php
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (base64_decode($request->bearerToken()) !== config('common.token.basic')) {
            return response()->json(['message' => 'Unauthorized action'], 403);
        }

        return $next($request);
    }
}
