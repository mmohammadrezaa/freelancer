<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 5:55 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Warranty\Active;
use App\Filters\Warranty\Company_Name;
use App\Filters\Warranty\Time_Term;

class Warranty_Filter extends AbstractFilter
{
    protected $filters = [
        'active'            => Active::class,
        'company_name'      => Company_Name::class,
        'time_term'         => Time_Term::class,
    ];
}