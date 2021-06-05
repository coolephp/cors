# cors

[简体中文](README-CN.md) | [ENGLISH](README.md)

> Adds CORS (Cross-Origin Resource Sharing) headers support in Coole application. - 在 Coole 应用程序中添加 CORS（跨源资源共享）头支持。

[![Tests](https://github.com/coolephp/cors/workflows/Tests/badge.svg)](https://github.com/coolephp/cors/actions)
[![Check & fix styling](https://github.com/coolephp/cors/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/coolephp/cors/actions)
[![codecov](https://codecov.io/gh/coolephp/cors/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/coolephp/cors)
[![Latest Stable Version](https://poser.pugx.org/coolephp/cors/v)](//packagist.org/packages/coolephp/cors)
[![Total Downloads](https://poser.pugx.org/coolephp/cors/downloads)](//packagist.org/packages/coolephp/cors)
[![License](https://poser.pugx.org/coolephp/cors/license)](//packagist.org/packages/coolephp/cors)

## 环境要求

* PHP >= 7.2

## 安装

``` bash
$ composer require coolephp/cors -vvv
```

## 使用

1. 复制 `cors/config/cors.php` 到 `coole-skeleton/config/cors.php`.
2. 配置 `\Coole\Cors\Cors::class` 中间件.

``` php
<?php

return [
    /*
     * App 名称
     */
    'name' => env('APP_NAME', 'Coole'),

    /*
     * 全局中间件
     */
    'middleware' => [
        ...
        \Coole\Cors\Cors::class
        ...
    ],
];
```

## 测试

``` bash
$ composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。
