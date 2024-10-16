<?php

namespace App\Http\Middleware;

use App\Services\LinkService;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveLinkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hash = $request->route()->parameter('hash');

        /** @var LinkService $linkService */
        $linkService = Container::getInstance()->make(LinkService::class);

        if ($hash && !$linkService->isActiveLink($hash)) {
            return redirect()->route('register');
        }

        return $next($request);
    }
}
