<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:00 PM
 */

namespace App\Filters\Coupon;


class Title
{
    public function filter($builder , $value)
    {
        return $builder->where('title','like','%'.$value.'%');
    }
}