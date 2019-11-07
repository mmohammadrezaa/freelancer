<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:24 PM
 */

namespace App\Filters\Coupon;


class Coupon_Balance
{
    public function filter($builder , $value)
    {
        return $builder->where('coupon_balance','like','%'.$value.'%');
    }
}