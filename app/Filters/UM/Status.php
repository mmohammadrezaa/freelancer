<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019-10-22
 * Time: 5:45 PM
 */

namespace App\Filters\UM;


class Status
{
    public function filter($builder , $value)
    {
        if ($value == 4){
            $value = 0;
        }
        return $builder->where('status',$value);
    }
}