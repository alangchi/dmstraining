<?php 

namespace App\Http\Middleware;

use Tymon\JWTAuth\Middleware\GetUserFromToken;
use Illuminate\Support\Facades\Log;
class JWTAuth extends GetUserFromToken {

	 /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        Log::debug("JWTAuth@handle1");
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            //return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
            return \Response::json(
		    	[
			    	'status_code' =>400,
			    	'message'     =>'Token_not_provided',
			    	'details'     =>(object)[]
		    	], 400
		    );
        }
        Log::debug("JWTAuth@handle2");
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (! $user) {
            // return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
            return \Response::json(
		    	[
			    	'status_code' =>404,
			    	'message'     =>'User_not_found',
			    	'details'     =>(object)[]
		    	], 404
		    );
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }

}