<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setup;

class EnsureDontCompleteSetupTwice
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Setup::count() > 0 && !$this->isEditingRoute($request) && !$this->isUpdatingRoute($request)) {
            return redirect('/repos');
        }

        return $next($request);
    }

    private function isEditingRoute(Request $request): bool
    {
        $route = $request->route();

        return ($route->getName() === 'setup.edit') ||
            (strpos($route->uri(), 'setup/1/edit') !== false);
    }

    private function isUpdatingRoute(Request $request): bool
    {
        $route = $request->route();

        return ($route->getName() === 'setup.update') ||
            (strpos($route->uri(), 'setup/1/update') !== false);
    }
}
