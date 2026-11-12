<?php
/*
 * Copyright (c) 2025-2026 Yunyun (Wang Yaoze)
 * Licensed under the Apache License, Version 2.0.
 * See the LICENSE file in this repository for the full text.
 * Source: https://github.com/NomenID/plugin-geoip
 * Project: https://nomenid.org/w/plugin-geoip
 */

namespace Nomen\Plugin\GeoIP;

class SpecialGeoIP
{
    public static function render(): string
    {
        $dbPath = dirname(__DIR__, 3) . '/data/GeoLite2-City.mmdb';
        $hasLib = class_exists(\GeoIp2\Database\Reader::class);
        $hasDb = file_exists($dbPath);

        $rows = [
            t('geoip2 library') => $hasLib ? t('Installed') : t('Not installed (composer require geoip2/geoip2)'),
            t('Database file') => $hasDb ? $dbPath : t('Missing data/GeoLite2-City.mmdb'),
            t('File size') => $hasDb ? round(filesize($dbPath) / 1048576, 1) . ' MB' : '—',
            t('Updated') => $hasDb ? date('Y-m-d H:i', filemtime($dbPath)) : '—',
        ];

        $html = '<table class="table">';
        foreach ($rows as $key => $value) {
            $html .= '<tr><th>' . htmlspecialchars($key) . '</th><td>' . htmlspecialchars((string)$value) . '</td></tr>';
        }
        $html .= '</table>';

        if ($hasLib && $hasDb) {
            $sample = Resolver::getLocation('8.8.8.8');
            $code = Resolver::getCountryCode('8.8.8.8') ?? '—';
            $html .= '<p>' . htmlspecialchars(t('8.8.8.8 resolves to {:location} ({:code})', [
                'location' => $sample,
                'code'     => $code,
            ])) . '</p>';
        }

        return $html;
    }
}
