<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 4:59 PM
 */

namespace App\Filters\AUM;


class Email
{

    public function filter($builder , $value)
    {
        return $builder->where('email',$value);
    }
}