<?php
/*
 * Copyright (c) 2025-2026 Yunyun (Wang Yaoze)
 * Licensed under the Apache License, Version 2.0.
 * See the LICENSE file in this repository for the full text.
 * Source: https://github.com/NomenID/plugin-geoip
 * Project: https://nomenid.org/w/plugin-geoip
 */

namespace Nomen\Plugin\GeoIP;

class Resolver
{
    private static ?\GeoIp2\Database\Reader $reader = null;
    private static bool $opened = false;

    private static function getReader(): ?\GeoIp2\Database\Reader
    {
        if (self::$opened) {
            return self::$reader;
        }
        self::$opened = true;

        $dbPath = dirname(__DIR__, 3) . '/data/GeoLite2-City.mmdb';
        if (!class_exists(\GeoIp2\Database\Reader::class) || !file_exists($dbPath)) {
            return null;
        }

        try {
            self::$reader = new \GeoIp2\Database\Reader($dbPath);
        } catch (\Exception $e) {
            error_log('[GeoIP] 打不开数据库：' . $e->getMessage());
        }

        return self::$reader;
    }

    /** MaxMind 地名按当前界面语言取，缺这门语言时退回英文 */
    private static function nameOf(array $names, string $fallback): string
    {
        $code = \Nomen\Src\I18n::code();
        $short = explode('-', $code)[0];

        return (string)($names[$code] ?? $names[$short] ?? $names['en'] ?? $fallback);
    }

    public static function getCountryCode(string $ip): ?string
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return null;
        }

        $reader = self::getReader();
        if (!$reader) {
            return null;
        }

        try {
            return $reader->city($ip)->country->isoCode ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getLocation(string $ip): string
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return '';
        }

        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'], true)) {
            return t('Local');
        }

        $reader = self::getReader();
        if (!$reader) {
            return '';
        }

        try {
            $record = $reader->city($ip);

            $country = self::nameOf($record->country->names, $record->country->name ?? '');
            $region = self::nameOf($record->mostSpecificSubdivision->names, $record->mostSpecificSubdivision->name ?? '');
            $city = self::nameOf($record->city->names, $record->city->name ?? '');

            $parts = [];
            if ($country) {
                $parts[] = $country;
            }
            if ($region && $region !== $country) {
                $parts[] = $region;
            }
            if ($city && $city !== $region) {
                $parts[] = $city;
            }

            return implode(' ', $parts);
        } catch (\Exception $e) {
            return '';
        }
    }
}
