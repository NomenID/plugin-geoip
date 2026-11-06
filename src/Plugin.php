<?php
namespace Nomen\Plugin\GeoIP;

use Nomen\Src\GeoIP;

class Plugin
{
    public static function boot(): void
    {
        GeoIP::setResolvers(
            [Resolver::class, 'getCountryCode'],
            [Resolver::class, 'getLocation']
        );
    }
}
