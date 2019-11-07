<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 7:08 PM
 */

namespace App\Filters\Category;


class Title
{
    public function filter($builder , $value)
    {
        return $builder->where('title','like','%'.$value.'%');
    }
}