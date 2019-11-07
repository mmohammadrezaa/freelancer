<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:59 PM
 */

namespace App\Filters\Warranty;


class Company_Name
{
    public function filter($builder , $value)
    {
        $www = fopen(public_path().'/tbbvvtt.txt','w');
        fwrite($www,$value);
        fclose($www);
        return $builder->where('company_name','like','%'.$value.'%');
    }
}