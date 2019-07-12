<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsProtocol
{
    public $start, $end;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->start = microtime(true);

        /* if ($request->server('HTTP_X_FORWARDED_PROTO') == 'https') {
        return $next($request);
        } else {
        return redirect()->secure($request->getRequestUri());
        } */

        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->end = microtime(true);
        $duration = number_format(($this->end - $this->start), 3);

        $url = $request->fullUrl();
        $method = $request->getMethod();
        $ip = $request->getClientIp();
        $status = $response->getStatusCode();
        $log = "{$ip}: [{$status}] [{$method}] @ {$url} - {$duration}ms";
        \Log::info('==============================================================');
        // \Log::info($log, ['request' => $request->all(), 'response' => $response]);
        \Log::info($log, ['request' => $request->all()]);
    }
}
