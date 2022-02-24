<?php

namespace App\Repositories;

use App\Models\Tenant\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * @param string $name
     * @return User[]
     */
    public function findOne(string $name);
}
