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
            'geoip2 库' => $hasLib ? '已安装' : '没装（composer require geoip2/geoip2）',
            '数据库文件' => $hasDb ? $dbPath : '缺 data/GeoLite2-City.mmdb',
            '文件大小' => $hasDb ? round(filesize($dbPath) / 1048576, 1) . ' MB' : '—',
            '更新时间' => $hasDb ? date('Y-m-d H:i', filemtime($dbPath)) : '—',
        ];

        $html = '<table class="table">';
        foreach ($rows as $key => $value) {
            $html .= '<tr><th>' . htmlspecialchars($key) . '</th><td>' . htmlspecialchars((string)$value) . '</td></tr>';
        }
        $html .= '</table>';

        if ($hasLib && $hasDb) {
            $sample = Resolver::getLocation('8.8.8.8');
            $code = Resolver::getCountryCode('8.8.8.8') ?? '—';
            $html .= '<p>8.8.8.8 查出来是 ' . htmlspecialchars($sample) . '（' . htmlspecialchars($code) . '）</p>';
        }

        return $html;
    }
}
