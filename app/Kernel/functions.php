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

namespace App\Kernel;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Framework\Logger\StdoutLogger;
use Hyperf\Logger\LoggerFactory;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

/**
 * @template T
 * @param null|class-string<T> $serviceName
 * @return ContainerInterface|T
 */
function di(?string $serviceName = null)
{
    $container = ApplicationContext::getContainer();
    if (empty($serviceName)) {
        return $container;
    }
    try {
        return $container->get($serviceName);
    } catch (Throwable $e) {
        throw new RuntimeException(sprintf('Service %s not found.', $serviceName));
    }
}

function logger($name = 'hyperf', $group = 'default'): LoggerInterface
{
    return di(LoggerFactory::class)->get($name, $group);
}

function console(): StdoutLogger
{
    return di(StdoutLoggerInterface::class);
}
