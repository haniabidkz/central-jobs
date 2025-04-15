<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        "upload-profille-img",
        "get-country-states",
        "upload-banner-img",
        "candidate/upload-profille-img",
        "candidate/upload-banner-img",
        "candidate/get-country-states",
        "candidate/remove-prfl-img",
        "company/remove-prfl-img",
        "company/get-country-states",
    ];
}
