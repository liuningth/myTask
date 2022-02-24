<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProductRepository.
 *
 * @package namespace App\Repositories;
 */
interface ProductRepository extends RepositoryInterface
{
    /**
     *
     * select all
     * @return mixed
     */
    public function findAll();


    /**
     *
     * find detail
     * @return mixed
     */
    public function findOne($id);


    /**
     *
     * delete one
     * @return mixed
     */
    public function deleteOne($id);



}
