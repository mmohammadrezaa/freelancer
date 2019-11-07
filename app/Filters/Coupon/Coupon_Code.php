<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:21 PM
 */

namespace App\Filters\Coupon;


class Coupon_Code
{
    public function filter($builder , $value)
    {
        return $builder->where('coupon_code','like','%'.$value.'%');
    }
}