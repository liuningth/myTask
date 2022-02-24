<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Coupon.
 *
 * @package namespace App\Entities;
 */
class Coupon extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'coupons';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['money', 'start_time', 'end_time'];

}
