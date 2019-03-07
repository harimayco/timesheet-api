<?php

namespace App\Models;

use App\Traits\AttributeHashable;
use App\Traits\ModelValidable;
use App\Traits\QueryFilterable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, QueryFilterable, ModelValidable, AttributeHashable;

    protected $table = 'av_user';
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'passwd', 'pass', 'notelepon', 'type', 'username', 'over', 'lastlog', 'Status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'passwd', 'pass'
    ];


    /**
     * Hash the attributes before saving.
     *
     * @var array
     */
    protected $hashable = [
        'passwd',
    ];

    /**
     * Validation rules for the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*' => [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:6',
            ],
            'UPDATE' => [
                'email' => 'required|unique:users,email,' . $this->id,
                'password' => 'sometimes|min:6',
            ],
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->passwd;
    }
    
}
