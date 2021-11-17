<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function userRoles() {
        return $this->hasMany(UserRole::class);
    }

    public function getClubsAttribute() {
        $clubs = [];
        foreach ($this->userRoles as $userRole) {
            array_push($clubs, $userRole->clubRole->club);
        }

        return $clubs;
    }

    public function isBelong($clubId) {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                return true;
            }
        }
        return false;
    }

    public function roleName($clubId) {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                return $userRole->clubRole->role_name;
            }
        }
        return "";
    }

    public function roleNumber($clubId) {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                return $userRole->clubRole->role_number;
            }
        }
        return "";
    }

    public function roleId($clubId)
    {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                return $userRole->clubRole->role_number;
            }
        }
        return "";
    }

    public function role($clubId)
    {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                return $userRole->clubRole;
            }
        }
        return "";
    }

    public function isAdmin($clubId) {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                if( $userRole->clubRole->role_number == config('const.adminNum')){
                    return true;
                }
            }
        }
        return false;
    }

    public function admin($clubId)
    {
        foreach ($this->userRoles as $userRole) {
            if ($userRole->clubRole->club->id == $clubId) {
                if ($userRole->clubRole->role_number == config('const.adminNum')) {
                    return $userRole->clubRole;
                }
            }
        }
        return "";
    }
}
