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
        '/telegram/sp2020',
        '/telegram/sp2020lf',
        '/telegram/regsosek',
        '/telegram/regsosek_set_unduh',
        '/izin_keluar/data_izin_keluar',
        '/izin_keluar/index_eks',
    ];
}
