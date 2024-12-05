<?php
declare(strict_types=1);

namespace App\Kernel\Log;

use Hyperf\Codec\Json;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Stringable;
use function App\Kernel\console;
use function App\Kernel\logger;

/**
 * @method static void debug(string|Stringable $message, array $context = [])
 * @method static void info(string|Stringable $message, array $context = [])
 * @method static void warning(string|Stringable $message, array $context = [])
 * @method static void alert(string|Stringable $message, array $context = [])
 * @method static void critical(string|Stringable $message, array $context = [])
 * @method static void error(string|Stringable $message, array $context = [])
 * @method static void emergency(string|Stringable $message, array $context = [])
 * @method static void notice(string|Stringable $message, array $context = [])
 */
class LogUtil
{
    public static function __callStatic($name, $arguments)
    {
        logger()->$name(...$arguments);
        console()->$name(...$arguments);
    }

    public static function logResponse()
    {
        $request = Context::get(RequestInterface::class);
        $requestId = Context::get('requestId');
        $response = Context::get(ResponseInterface::class);
        LogUtil::debug('request=' . Json::encode([
                'request_id' => $requestId,
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod(),
                'params' => $request->getParsedBody(),
                'query' => $request->getQueryParams(),
            ], JSON_UNESCAPED_SLASHES));
        LogUtil::debug('response=' . $response->getBody()->getContents());
    }
}