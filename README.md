# cors

[简体中文](README-CN.md) | [ENGLISH](README.md)

> Adds CORS (Cross-Origin Resource Sharing) headers support in Coole application. - 在 Coole 应用程序中添加 CORS（跨源资源共享）头支持。

[![Tests](https://github.com/coolephp/cors/workflows/Tests/badge.svg)](https://github.com/coolephp/cors/actions)
[![Check & fix styling](https://github.com/coolephp/cors/workflows/Check%20&%20fix%20styling/badge.svg)](https://github.com/coolephp/cors/actions)
[![codecov](https://codecov.io/gh/coolephp/cors/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/coolephp/cors)
[![Latest Stable Version](https://poser.pugx.org/coolephp/cors/v)](//packagist.org/packages/coolephp/cors)
[![Total Downloads](https://poser.pugx.org/coolephp/cors/downloads)](//packagist.org/packages/coolephp/cors)
[![License](https://poser.pugx.org/coolephp/cors/license)](//packagist.org/packages/coolephp/cors)

## Requirement

* PHP >= 7.2

## Installation

``` bash
$ composer require coolephp/cors -vvv
```

## Usage

1. Copy `cors/config/cors.php` to `coole-skeleton/config/cors.php`.
2. Config `\Coole\Cors\Cors::class` middleware.

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

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
