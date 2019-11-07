<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 6:00 PM
 */

namespace App\Filters\Warranty;


class Time_Term
{
    public function filter($builder , $value)
    {
        return $builder->where('time_term',$value);
    }
}