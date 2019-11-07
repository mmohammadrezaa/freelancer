<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 7:07 PM
 */

namespace App\Filters\Support;


class User_id
{
    public function filter($builder , $value)
    {
        return $builder->where('user_id',$value);
    }
}