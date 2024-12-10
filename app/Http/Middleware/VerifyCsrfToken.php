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
        '/admin/users/table',
        '/checkout/secure-iframe',
        '/checkout/secure-process',
        '/checkout/notification',
        '/callback/notification',
        '/callback/usage',
        '/checkout/process',
        '/livewire/message/catalog',
        '/api/validate/mobile',
    ];
}
