<?php

declare(strict_types=1);

namespace App\Filters;

use CodeIgniter\Filters\SecureHeaders as BaseSecureHeaders;

/**
 * Custom Secure Headers Filter
 *
 * Overrides default 'same-origin' Referrer-Policy with 'strict-origin-when-cross-origin'
 * so that cross-origin media embeds (like YouTube iframe embeds) pass the origin referrer,
 * preventing YouTube embed "Error 153 (Video player configuration error)".
 */
class SecureHeaders extends BaseSecureHeaders
{
    /**
     * @var array<string, string>
     */
    protected $headers = [
        // https://owasp.org/www-project-secure-headers/#x-frame-options
        'X-Frame-Options' => 'SAMEORIGIN',

        // https://owasp.org/www-project-secure-headers/#x-content-type-options
        'X-Content-Type-Options' => 'nosniff',

        // https://docs.microsoft.com/en-us/previous-versions/windows/internet-explorer/ie-developer/compatibility/jj542450(v=vs.85)#the-noopen-directive
        'X-Download-Options' => 'noopen',

        // https://owasp.org/www-project-secure-headers/#x-permitted-cross-domain-policies
        'X-Permitted-Cross-Domain-Policies' => 'none',

        // Send origin for cross-origin HTTPS requests (required by YouTube player & embed APIs)
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
    ];
}

