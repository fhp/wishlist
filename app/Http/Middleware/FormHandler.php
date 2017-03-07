<?php

namespace Wenslijst\Http\Middleware;

class FormHandler
{
	public function handle($request, \Closure $next, $guard = null)
	{
		return $next($request);
	}
}
