<?php
/**
 * Created by PhpStorm.
 * User: mohammadreza
 * Date: 3/11/2019
 * Time: 7:04 PM
 */

namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\Support\Status;
use App\Filters\Support\Title;
use App\Filters\Support\User_id;

class Support_Filter extends AbstractFilter
{
    protected $filters = [
        'status'            => Status::class,
        'title'             => Title::class,
        'user_id'           => User_id::class,
    ];
}