<?php

namespace Yearbook\Middleware;

use Symfony\Component\HttpFoundation\Request;

interface MiddlewareInterface{

	public function handle(Request $request);

}