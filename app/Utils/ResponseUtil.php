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

namespace App\Utils;

use App\Constants\ErrCode;
use Hyperf\Context\Context;
use Hyperf\Contract\Arrayable;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use function App\Kernel\di;

class ResponseUtil
{
    /**
     * @param ErrCode $code
     * @param string|null $message
     * @param Arrayable|array|null $data
     * @return PsrResponseInterface
     */
    public static function result(ErrCode $code, ?string $message = null, Arrayable|array $data = null): PsrResponseInterface
    {
        $requestId = Context::get('requestId');
        $result = [
            'code' => $code->value,
            'message' => $message ?? $code->getMessage(),
        ];
        if (!empty($requestId)) {
            $result['requestId'] = $requestId;
        }
        if (! empty($data)) {
            $result['data'] = $data instanceof Arrayable ? $data->toArray() : $data;
        }
        return di(ResponseInterface::class)->json($result);
    }

    public static function success(Arrayable|array $data = null): PsrResponseInterface
    {
        return static::result(ErrCode::SUCCESS, null, $data);
    }

    public static function fail(ErrCode $code, ?string $message = null): PsrResponseInterface
    {
        return static::result($code, $message);
    }

    public static function paginate(PaginatorInterface $paginator): PsrResponseInterface
    {
        return static::success([
            'total' => $paginator->total(),
            'pageSize' => $paginator->perPage(),
            'currentPage' => $paginator->currentPage(),
            'lastPage' => $paginator->lastPage(),
            'list' => $paginator->items(),
        ]);
    }
}
