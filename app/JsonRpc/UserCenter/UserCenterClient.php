<?php
declare(strict_types=1);

namespace App\JsonRpc\UserCenter;

use App\JsonRpc\UserCenter\Contracts\UserCenterInterface;
use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\RpcClient\AbstractServiceClient;
use Wjy\RpcHelper\RpcClient;

#[RpcClient(nodes: ['127.0.0.1:9502'])]
class UserCenterClient extends AbstractServiceClient implements UserCenterInterface
{
    protected string $protocol = 'jsonrpc-http';
    protected string $serviceName = 'user-center';
    protected string $loadBalancer = 'random';

    #[Cacheable(prefix: 'user-center', value: '#{id}', ttl: 3600)]
    public function getUserInfo(int $id): array
    {
        return $this->__request(__FUNCTION__, compact('id'));
    }
}
