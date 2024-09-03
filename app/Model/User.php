<?php
declare(strict_types=1);

namespace App\Model;

use App\JsonRpc\UserCenter\Contracts\UserCenterInterface;
use Qbhy\HyperfAuth\Authenticatable;
use function App\Kernel\di;

/**
 * @property int $id
 */
class User implements Authenticatable
{

    public function getId()
    {
        return $this->id;
    }

    public static function retrieveById($key): ?Authenticatable
    {
        $res = di(UserCenterInterface::class)->getUserInfo((int)$key);
        $user = new static();
        $user->id = $res['id'];
        return $user;
    }
}