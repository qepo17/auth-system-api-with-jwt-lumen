<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'username', 'name', 'email', 'password', 'bio', 'github', 'twitter', 'location', 'viewers', 'photo', 'last_login'
    ];

    protected $hidden = [
        'password', 'email_verified_at', 'remember_token', 'created_at', 'updated_at'
    ];

    public function takeUsername($id)
    {
        return $this->select('username')->where('id', $id)->get();
    }
}
