<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait RestTrait
{
    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCallFrom(Request $request)
    {
        // return $request->wantsJson(); # Add `Accept: application/json` in request
        // return $request->expectsJson();
        // return strpos($request->getUri(), '/api/*') !== false;
        return $request->is('api/*');
    }
}
