<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/25/2019
 * Time: 2:12 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\UM\Name;
use App\Filters\UM\Active;
use App\Filters\UM\Email;
use App\Filters\UM\Status;
use Illuminate\Database\Eloquent\Builder;

class UM_Filter extends AbstractFilter
{
    protected $filters = [
        'name'              => Name::class,
        'active'            => Active::class,
        'email'             => Email::class,
        'status'            => Status::class
    ];
}