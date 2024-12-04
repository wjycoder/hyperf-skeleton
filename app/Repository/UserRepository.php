<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\User;

/**
 * @extends IRepository<User>
 */
class UserRepository extends IRepository
{

    function setModel(): void
    {
        $this->model = new User();
    }
}
