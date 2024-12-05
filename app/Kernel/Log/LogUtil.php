<?php
declare(strict_types=1);

namespace App\Kernel\Log;

use Hyperf\Codec\Json;
use Hyperf\Context\Context;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Stringable;
use function App\Kernel\console;
use function App\Kernel\di;
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

    public static function logResponse(?Responseinterface $response = null)
    {
        $request = di(RequestInterface::class);
        $requestId = Context::get('requestId');
        $response = $response?:di(\Hyperf\HttpServer\Contract\ResponseInterface::class);
        LogUtil::debug('request=' . Json::encode([
                'request_id' => $requestId,
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod(),
                'params' => $request->getParsedBody(),
                'query' => $request->getQueryParams(),
                'response' => $response->getBody()->getContents(),
            ], JSON_UNESCAPED_SLASHES));
    }
}