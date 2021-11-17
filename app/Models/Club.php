<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class Club extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'unique_name',
    ];

    public function clubRoles() {
        return $this->hasMany(ClubRole::class);
    }

    public function plans() {
        return $this->hasMany(Plan::class);
    }

    public function leaderRoleName() {
        foreach ($this->clubRoles as $clubRole) {
            if ($clubRole->role_number == 1) {
                $leaderRoleName = $clubRole->role_name;
            }
        }
        return $leaderRoleName;
    }

    public function leader() {
        foreach ($this->clubRoles as $clubRole) {
            if ($clubRole->role_number == config('const.adminNum')) {
                $leaderId = $clubRole->id;
            }
        }

        $userRole = userRole::where('club_role_id', $leaderId)->firstOrFail();
        $leader = User::find($userRole->user_id);
        return $leader;
    }



    public function members() {
        $members = [];
        $sortedClubRoles = $this->clubRoles->sortBy('role_number')->values();
        foreach ($sortedClubRoles as $clubRole) {
            foreach($clubRole->userRoles as $userRole) {
                if ($userRole->name != null) {
                    $userRole->user->name = $userRole->name;
                }
                array_push($members, $userRole->user);
            }
        }

        return $members;
    }

    public function role($userId) {
        $userRoles = User::find($userId)->userRoles;
        $clubRoles = $this->clubRoles;
        foreach ($clubRoles as $clubRole) {
            foreach ($userRoles as $userRole) {
                if ($clubRole->id == $userRole->club_role_id) {
                    return $clubRole;
                }
            }
        }

        return '';
    }

    public function isMember($userId)
    {
        $userRoles = User::find($userId)->userRoles;
        $clubRoles = $this->clubRoles;
        foreach ($clubRoles as $clubRole) {
            foreach ($userRoles as $userRole) {
                if ($clubRole->id == $userRole->club_role_id) {
                    if ($clubRole->role_number == config('const.defaultRequestNum')) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function isAdmin($userId)
    {
        $userRoles = User::find($userId)->userRoles;
        $clubRoles = $this->clubRoles;
        foreach ($clubRoles as $clubRole) {
            foreach ($userRoles as $userRole) {
                if ($clubRole->id == $userRole->club_role_id) {
                    if ($clubRole->role_number == config('const.adminNum')) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }

        return false;
    }
}
