<?php

namespace App\JsonRpc\UserCenter\Contracts;

interface UserCenterInterface
{
    public function getUserInfo(int $id): array;
}