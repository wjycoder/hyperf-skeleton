<?php
declare(strict_types=1);

namespace App\Repository;


use App\Model\Model;

/**
 * @template T of Model
 * @property T $model
 */
abstract class IRepository
{
    /**
     * @return null|T
     */
    public function getById($id)
    {
        return $this->model->newQuery()->find($id);
    }

    public function __construct()
    {
        $this->setModel();
    }

    abstract function setModel(): void;
}