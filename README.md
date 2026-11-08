# GeoIP

按 IP 查国家和位置：注册页预填国家、活动日志补地点。

GeoIP 是独立项目，不属于 Nomen 本体，按 GPLv3 单独发布：
<https://github.com/NomenID/plugin-geoip>。

没装依赖或没有数据文件时静默降级（返回空 /「未知位置」），不影响注册和登录。

## 启用

1. `composer require geoip2/geoip2`
2. 去 MaxMind 下载 GeoLite2-City，放到 `data/GeoLite2-City.mmdb`（要登录并同意它的条款，数据文件不进仓库）
3. `config/plugins.php` 里留着 `'geoip'`

## 第三方组件

插件本身只负责读 MaxMind 格式的 mmdb，数据和库都不随插件分发：

- `geoip2/geoip2` —— Apache-2.0，用 composer 装到项目根
- GeoLite2 数据 —— MaxMind 提供，CC BY-SA 4.0，要自己下载并同意 [MaxMind 的条款](https://www.maxmind.com/en/geolite2/eula)；文件放 `data/GeoLite2-City.mmdb`，不进仓库

别的 MaxMind 格式库也能用，换掉那个文件就行。

## 状态页

管理员打开 `/special/geoip`，能看到库装没装、数据文件的体积和更新时间，以及一次 8.8.8.8 的实测。

## 许可

GPL-3.0-only，协议全文见 [LICENSE](LICENSE)。

Copyright (C) 2025-2026 Yunyun (Wang Yaoze)
