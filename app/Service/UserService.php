<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\IRepository;
use App\Repository\UserRepository;
use function App\Kernel\di;

/**
 * @extends IService<UserRepository>
 */
final class UserService extends IService
{

    protected function repository()
    {
        return di(UserRepository::class);
    }
}