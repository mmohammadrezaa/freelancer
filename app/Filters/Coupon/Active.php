<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 4:59 PM
 */

namespace App\Filters\Coupon;


class Active
{
    public function filter($builder , $value)
    {
        if ($value == 2){
            $value = 0;
        }
        return $builder->where('active',$value);
    }
}