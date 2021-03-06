<?php

/**
 * This file is part of the coolephp/cors.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Coole\Cors;

use Asm89\Stack\CorsService;
use Closure;
use Guanguans\Coole\Facade\App;
use Guanguans\Coole\Middleware\MiddlewareInterface;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tightenco\Collect\Support\Collection;

class Cors implements MiddlewareInterface
{
    /**
     * @var \Tightenco\Collect\Support\Collection
     */
    protected $config;

    /**
     * @var \Asm89\Stack\CorsService
     */
    protected $corsService;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->initConfig();
        $this->config = app('config')['cors'];
        $this->corsService = $this->buildCorsService($this->config);
    }

    public function initConfig()
    {
        $initConfig = require __DIR__.'/../config/cors.php';

        App::addConfig(['cors' => $initConfig]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        if (! $this->shouldRun($request)) {
            return $next($request);
        }

        // For Preflight, return the Preflight response
        if ($this->corsService->isPreflightRequest($request)) {
            $response = $this->corsService->handlePreflightRequest($request);

            $this->corsService->varyHeader($response, 'Access-Control-Request-Method');

            return $response;
        }

        $response = $next($request);

        if ('OPTIONS' === $request->getMethod()) {
            $this->corsService->varyHeader($response, 'Access-Control-Request-Method');
        }

        return $this->addHeaders($request, $response);
    }

    protected function addHeaders(Request $request, Response $response): Response
    {
        if (! $response->headers->has('Access-Control-Allow-Origin')) {
            $response = $this->corsService->addActualRequestHeaders($response, $request);
        }

        return $response;
    }

    protected function shouldRun(Request $request): bool
    {
        return $this->isMatchingPath($request);
    }

    protected function isMatchingPath(Request $request): bool
    {
        $paths = $this->getPathsByHost($request->getHost());

        foreach ($paths as $path) {
            if ('/' !== $path) {
                $path = trim($path, '/');
            }

            $url = trim($request->getRequestUri(), '/');
            if (Str::is($path, $url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array|mixed
     */
    protected function getPathsByHost(string $host)
    {
        $paths = $this->config->get('paths', []);
        if (isset($paths[$host])) {
            return $paths[$host];
        }

        return array_filter($paths, function ($path) {
            return is_string($path);
        });
    }

    protected function buildCorsService(Collection $config): CorsService
    {
        if ($config['exposed_headers'] && ! is_array($config['exposed_headers'])) {
            throw new \RuntimeException('CORS config `exposed_headers` should be `false` or an array');
        }

        foreach (['allowed_origins', 'allowed_origins_patterns',  'allowed_headers', 'allowed_methods'] as $key) {
            if (! is_array($config[$key])) {
                throw new \RuntimeException('CORS config `'.$key.'` should be an array');
            }
        }

        // Convert case to supported options
        $options = [
            'supportsCredentials' => $config['supports_credentials'],
            'allowedOrigins' => $config['allowed_origins'],
            'allowedOriginsPatterns' => $config['allowed_origins_patterns'],
            'allowedHeaders' => $config['allowed_headers'],
            'allowedMethods' => $config['allowed_methods'],
            'exposedHeaders' => $config['exposed_headers'],
            'maxAge' => $config['max_age'],
        ];

        // Transform wildcard pattern
        foreach ($options['allowedOrigins'] as $origin) {
            if (false !== strpos($origin, '*')) {
                $options['allowedOriginsPatterns'][] = $this->convertWildcardToPattern($origin);
            }
        }

        return new CorsService($options);
    }

    /**
     * @param $pattern
     *
     * @return string
     */
    protected function convertWildcardToPattern($pattern)
    {
        $pattern = preg_quote($pattern, '#');

        $pattern = str_replace('\*', '.*', $pattern);

        return '#^'.$pattern.'\z#u';
    }
}
