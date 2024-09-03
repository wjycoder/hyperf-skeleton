<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Middleware;

use Hyperf\Codec\Json;
use Hyperf\Context\Context;
use Hyperf\Engine\Http\Stream;
use Hyperf\Stringable\Str;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function App\Kernel\console;

class RequestMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getUri()->getPath() == '/favicon.ico') {
            return $handler->handle($request);
        }
        $requestId = Str::ulid()->toBase32();
        Context::set('requestId', $requestId);
        $response = $handler->handle($request);

        // $contents = $response->getBody()->getContents();
        // $res = Json::decode($contents);
        // $res['requestId'] = $requestId;
        // $response = $response->withBody(new Stream(Json::encode($res)));

        console()->debug('request=' . Json::encode([
                'request_id' => $requestId,
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod(),
                'params' => $request->getParsedBody(),
                'query' => $request->getQueryParams(),
            ], JSON_UNESCAPED_SLASHES));
        console()->debug('response=' . $response->getBody()->getContents());
        return $response;
    }
}
