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

namespace App\Kernel\Log;

use Hyperf\Context\Context;
use Hyperf\Stringable\Str;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class AppendRequestIdProcessor implements ProcessorInterface
{
    public const REQUEST_ID = 'log.request.id';

    public function __invoke(LogRecord $record): LogRecord
    {
        $record->extra['request_id'] = Context::getOrSet(self::REQUEST_ID, Context::get('requestId')?:Str::ulid()->toBase32());
        return $record;
    }
}
