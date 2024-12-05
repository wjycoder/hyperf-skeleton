<?php
declare(strict_types=1);

namespace App\Exception\Handler;

use App\Constants\ErrCode;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AuthExceptionHandler extends \Qbhy\HyperfAuth\AuthExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        return $response->withStatus(200)->withBody(new SwooleStream(json_encode([
            'code' => ErrCode::UNAUTHORIZED,
            'message' => $throwable->getMessage(),
        ])));
    }

}