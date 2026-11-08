<?php
/*
 * Copyright (c) 2025-2026 Yunyun (Wang Yaoze)
 * Licensed under the GNU General Public License, version 3 or any later
 * version, with additional attribution terms in the NOTICE file.
 * Source: https://github.com/NomenID/plugin-geoip
 * Project: https://nomen.caellab.com/w/plugin-geoip
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
