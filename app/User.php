<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Filters\AUM_Filter;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    public function scopeFilter(Builder $builder,$request)
    {
        return (new AUM_Filter($request))->filter($builder);
    }
    use Notifiable;
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','access','active','avatar','bio','field','city'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
