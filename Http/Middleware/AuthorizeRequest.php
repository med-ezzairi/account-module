<?php

namespace Modules\Account\Http\Middleware;

use Modules\Account\Contracts\Gate;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Http\Middleware\AbstractMiddleware;

class AuthorizeRequest extends AbstractMiddleware
{
    protected $auth;
    protected $gate;
    
    public function __construct(Auth $auth, Gate $gate)
    {
        $this->auth = $auth;
        $this->gate = $gate;
    }
    
    public function handle($request, Closure $next, $resource, ...$params)
    {
        $this->auth->authenticate();
        $this->gate->authorize($resource, $params);
        
        return $next($request);
    }
    
}