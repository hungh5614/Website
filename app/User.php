<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Users\UserSubscribe;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    protected $table = 'users';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPassWordAttribute($password)
    {
        $this->attributes['password'] = bcrypt(($password));
    }

    public function setUsername($name)
    {
        $this->name = strtolower($name);
    }

    public function getUsername()
    {
        return ucwords($this->name);
    }

    public function user()
    {
        return ucwords($this->name);
    }

    public function usersubscribe()
    {
        return $this->hasMany(UserSubscribe::class);
    }
}
