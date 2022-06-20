<?php

namespace Lunia\Auditoria\Middlewares;

use Closure;

class AddToRequestAuthUser
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);


        if(auth()->check()){
            $request->request->add(['auditable_user_id' => auth()->id()]);
        }


        return $response;
    }

}