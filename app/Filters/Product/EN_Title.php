<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 7:08 PM
 */

namespace App\Filters\Product;


class EN_Title
{
    public function filter($builder , $value)
    {
        return $builder->where('en_title','like','%'.$value.'%')->orwhere('fa_title','like','%'.$value.'%')->orwhere('ro_title','like','%'.$value.'%');
    }
}