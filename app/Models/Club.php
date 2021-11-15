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
            if ($clubRole->role_number == 1) {
                $leaderId = $clubRole->id;
            }
        }

        $userRole = UserRole::find($leaderId);
        $leader = User::find($userRole->user_id);
        return $leader->name;
    }

    public function members() {
        $members = [];
        foreach ($this->clubRoles as $clubRole) {
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
                    return $clubRole->role_name;
                }
            }
        }

        return '';
    }
}
