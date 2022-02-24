<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CouponRepository.
 *
 * @package namespace App\Repositories;
 */
interface CouponRepository extends RepositoryInterface
{
    /**
     *
     * find all coupons
     * @return mixed
     */
    public function findAll();

    /**
     *
     * creat
     * @param $request
     * @return mixed
     */
    public function creat($request);

    /**
     *
     * updata
     * @param $request
     * @param $coupon
     * @return mixed
     */
    public function updateCoupon($request, $coupon);

    /**
     *
     *
     * @param $id
     * @return mixed
     */
    public function findOne($id);

    /**
     *
     *
     * @param $id
     * @return mixed
     */
    public function deleteOne($id);
}
