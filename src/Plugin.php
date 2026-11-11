<?php
/*
 * Copyright (c) 2025-2026 Yunyun (Wang Yaoze)
 * Licensed under the Apache License, Version 2.0.
 * See the LICENSE file in this repository for the full text.
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
