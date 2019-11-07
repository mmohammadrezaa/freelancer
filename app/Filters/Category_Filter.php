<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/25/2019
 * Time: 2:12 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Category\Title;
use App\Filters\Category\Active;
use App\Filters\Category\Head_Category;
use Illuminate\Database\Eloquent\Builder;

class Category_Filter extends AbstractFilter
{
    protected $filters = [
        'title'             => Title::class,
        'active'            => Active::class,
        'head_category'     => Head_Category::class,
    ];
}