<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 4:59 PM
 */

namespace App\Filters\Category;


class Head_Category
{

    public function filter($builder , $value)
    {
        return $builder->where('head_category',$value);
    }
}