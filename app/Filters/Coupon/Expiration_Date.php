<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:25 PM
 */

namespace App\Filters\Coupon;


class Expiration_Date
{
    public function filter($builder , $value)
    {
        return $builder->where('expiration_date','=',$value);
    }
}