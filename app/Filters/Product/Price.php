<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 7:08 PM
 */

namespace App\Filters\Product;


class Price
{
    public function filter($builder , $value)
    {
        if ($value['min'] == ''){
            $value['min'] = 0;
        }
        if ($value['max'] == ''){
            $value['max'] = 10000000;
        }
        return $builder->wherebetween('price',[$value['min'],$value['max']]);
    }
}