<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:15 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Coupon\Active;
use App\Filters\Coupon\Coupon_Balance;
use App\Filters\Coupon\Coupon_Code;
use App\Filters\Coupon\Expiration_Date;
use App\Filters\Coupon\Title;
use Illuminate\Database\Eloquent\Builder;
class Coupon_Filter extends AbstractFilter
{
    protected $filters = [
        'active'            => Active::class,
        'title'             => Title::class,
        'coupon_code'       => Coupon_Code::class,
        'coupon_balance'    => Coupon_Balance::class,
        'expiration_date'   => Expiration_Date::class,
    ];
}