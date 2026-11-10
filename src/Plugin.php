<?php
/*
 * Copyright (c) 2025-2026 Yunyun (Wang Yaoze)
 * Licensed under the GNU General Public License, version 3 only.
 * Attribution requests are in the NOTICE file.
 * Source: https://github.com/NomenID/plugin-geoip
 * Project: https://nomenid.org/w/plugin-geoip
 */

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
