<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $lastname
 * @property string $cedula
 * @property string|null $phone
 * @property string|null $mobile
 * @property string $email
 * @property string $password
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications*/

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lastname','cedula', 'phone', 'mobile', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }



    public function hasRole($role)
    {
            if($this->role == $role)
            {
                return true;
            }

        return false;
    }

    public function area (){
        return $this->hasOne   ('App\Area');
    }
    /*
    public function departamento (){
        return $this->belongsTo ('App\Area');
    }*/

    public function expedientes ()
    {
        return $this->hasMany ('App\Expediente');
    }

    public function funcionario ()
    {
        return $this->hasOne ('App\Funcionario');
    }
}
