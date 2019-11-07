<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/25/2019
 * Time: 2:12 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Product\EN_Title;
use App\Filters\Product\Price;
use App\Filters\Product\Active;
use App\Filters\Product\RO_Title;
use Illuminate\Database\Eloquent\Builder;

class Product_Fliter extends AbstractFilter
{
    protected $filters = [
        'en_title'          => EN_Title::class,
        'price'             => price::class,
        'active'            => Active::class,
    ];
}