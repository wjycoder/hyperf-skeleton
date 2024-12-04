<?php
declare(strict_types=1);

namespace App\Service;


use App\Repository\IRepository;

/**
 * @template T
 * @property IRepository<T> $repository
 */
abstract class IService
{
    public function __construct()
    {
        $this->repository = $this->repository();
    }
    /**
     * @return T|null
     */
    public function getById($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * @return IRepository<T>
     */
    abstract protected function repository();
}