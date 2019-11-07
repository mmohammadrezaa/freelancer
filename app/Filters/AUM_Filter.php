<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/25/2019
 * Time: 2:12 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\AUM\Name;
use App\Filters\AUM\Active;
use App\Filters\AUM\Email;
use Illuminate\Database\Eloquent\Builder;

class AUM_Filter extends AbstractFilter
{
    protected $filters = [
        'name'              => Name::class,
        'active'            => Active::class,
        'email'             => Email::class
    ];
}