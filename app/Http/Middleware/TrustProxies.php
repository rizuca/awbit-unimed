<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The proxies that should be trusted.
     *
     * @var array|string|null
     */
    protected $proxies = '*'; // Ubah ini menjadi '*'

    /**
     * The headers that should be trusted.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PROTO;
}